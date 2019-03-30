<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllBySQL(string $cat = null, string $q = null, string $mprice = null, int $stars = null, $page = null)
    {
        $conn = $this->getEntityManager()->getConnection();
        $execParam = [];

        $sqlStart = 'SELECT DISTINCT p.id_product as id, p.product_title as title, p.unit_price_HT as unitPriceHT, (SELECT pp.picture_name FROM product_picture as pp WHERE p.id_product = pp.id_product LIMIT 1 OFFSET 0) as picture, po.avgstars ';
        $sqlCount = 'SELECT COUNT(*) ';
        $sql = 'FROM product as p, (SELECT pr.id_product as id, ROUND(AVG(o.score), 1) as avgstars FROM opinion as o RIGHT JOIN product as pr ON o.id_product = pr.id_product GROUP BY pr.id_product ';

        if ($stars !== null && $stars > 0 && $stars < 6) {
            $sql .= 'HAVING avgstars >= :stars ';
            $execParam['stars'] = $stars;
        }

        $sql .= ') as po ';

        if ($cat !== null && $q !== null) {
            $sql .= 'WHERE p.id_category = (SELECT DISTINCT c.id_category FROM category as c WHERE c.name_category = :cat ) AND (p.product_title LIKE :q OR p.description LIKE :q ) ';
            $execParam['cat'] = $cat;
            $execParam['q'] = '%'.$q.'%';
        } else if ($cat !== null) {
            $sql .= 'WHERE p.id_category = (SELECT DISTINCT c.id_category FROM category as c WHERE c.name_category = :cat ) ';
            $execParam['cat'] = $cat;
        } else if ($q !== null) {
            $sql .= 'WHERE (p.product_title LIKE :q OR p.description LIKE :q ) ';
            $execParam['q'] = '%'.$q.'%';
        } else {
            $sql .= 'WHERE 1 ';
        }

        $sql .= 'AND po.id = p.id_product ';

        $sqlCount = $sqlCount.$sql;

        if ($mprice == 'DESC') {
            $sql .= 'ORDER BY unit_price_HT, product_title DESC ';
        } else if ($mprice == 'ASC') {
            $sql .= 'ORDER BY unit_price_HT, product_title ASC ';
        } else {
            $sql .= 'ORDER BY product_title ASC ';
        }

        $page -=1;
        if ($page !== null && $page !== '') {
            $sql .= 'LIMIT 20 OFFSET '.(20 * abs($page)).' ';
        }
        $conn->beginTransaction();

        $stmt = $conn->prepare($sqlStart.$sql);
        $index = 0;
        foreach ($execParam as $p) {
            $stmt->bindValue(array_keys($execParam)[$index++], $p);
        }
        $stmt->execute();

        $allp = $conn->prepare($sqlCount);
        $index = 0;
        foreach ($execParam as $p) {
            $allp->bindValue(array_keys($execParam)[$index++], $p);
        }
        $allp->execute();
        $conn->commit();

        $data = [];
        $data['products'] = $stmt->fetchAll();
        $data['nbProduct'] = $allp->rowCount();
        return $data;
    }
}