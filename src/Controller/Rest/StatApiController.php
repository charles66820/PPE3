<?php

namespace App\Controller\Rest;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", host="api.%domain%")
 */
class StatApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get( "/stats" )
     */
    public function getStats(ObjectManager $manager)
    {
        $conn = $manager->getConnection();

        $sql = 'SELECT COUNT(*) as nbOrders FROM command';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $nbOrders = $stmt->fetch();

        $sql = 'SELECT SUM(c.total_HT + c.tax_on_command) as totalOrdersTTC FROM command as c';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $totalOrdersTTC = $stmt->fetch();

        $sql = 'SELECT COUNT(*) as nbCustomers FROM client';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $nbCustomers = $stmt->fetch();

        $sql = 'SELECT COUNT(*) as nbCustomersOrdered FROM client as c, command as co WHERE c.id_client = co.id_client';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $nbCustomersOrdered = $stmt->fetch();

        $stats = [
            "date" => new \DateTime(),
            "nbOrders" => $nbOrders["nbOrders"],
            "totalOrdersTTC" => $totalOrdersTTC["totalOrdersTTC"],
            "nbCustomers" => $nbCustomers["nbCustomers"],
            "nbCustomersOrdered" => $nbCustomersOrdered["nbCustomersOrdered"],
        ];

        return $this->handleView($this->view($stats, 200));
    }
}
