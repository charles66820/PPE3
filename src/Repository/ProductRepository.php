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

        $sql = 'SELECT DISTINCT p.id_product as id, p.product_title as title, p.unit_price_HT as unitPriceHT, (SELECT pp.picture_name FROM product_picture as pp WHERE p.id_product = pp.id_product LIMIT 1 OFFSET 0) as picture, ROUND(AVG(o.score), 1) as avgstars FROM opinion as o RIGHT JOIN product as p ON o.id_product = p.id_product ';
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
        }

        $sql .= 'GROUP BY p.id_product, p.product_title, p.unit_price_HT ';

        if ($stars !== null && $stars > 0 && $stars < 6) {
            $sql .= 'HAVING avgstars >= :stars ';
            $execParam['stars'] = $stars;
        }

        if ($mprice == 'DESC') {
            $sql .= 'ORDER BY unit_price_HT, product_title DESC ';
        } else if ($mprice == 'ASC') {
            $sql .= 'ORDER BY unit_price_HT, product_title ASC ';
        } else {
            $sql .= 'ORDER BY product_title ASC ';
        }

        if ($page !== null) {
            $sql .= 'LIMIT 20 OFFSET '.(20 * $page).' ';
        }

        $stmt = $conn->prepare($sql);
        $index = 0;
        foreach ($execParam as $p) {
            $stmt->bindValue(array_keys($execParam)[$index++], $p);
        }
        $stmt->execute();

        return $stmt->fetchAll();
    }
}