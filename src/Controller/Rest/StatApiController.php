<?php

namespace App\Controller\Rest;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
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

        $date = new \DateTime();
        $nbOrders = $nbOrders["nbOrders"];
        $totalOrdersTTC = $totalOrdersTTC["totalOrdersTTC"];
        $avgOrders = $totalOrdersTTC/$nbOrders;
        $nbCustomers = $nbCustomers["nbCustomers"];
        $nbCustomersOrdered = $nbCustomersOrdered["nbCustomersOrdered"];

        $stats = [
            "date" => $date->format("Y-m-d H:i:s"),
            "nbOrders" => $nbOrders,
            "totalOrdersTTC" => $totalOrdersTTC,
            "avgOrders" => $avgOrders,
            "nbCustomers" => $nbCustomers,
            "nbCustomersOrdered" => $nbCustomersOrdered,
        ];

        $this->postStats($date, $nbOrders, $totalOrdersTTC, $avgOrders, $nbCustomers, $nbCustomersOrdered, $manager);

        return $this->handleView($this->view($stats, 200));
    }

    public function postStats(\DateTime $date, $nbOrders, $totalOrdersTTC, $avgOrders, $nbCustomers, $nbCustomersOrdered, ObjectManager $manager)
    {
        $conn = $manager->getConnection();

        $sql = 'SELECT * FROM stats';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $nbStats = $stmt->rowCount();

        if ($nbStats < 1) {
            $sql = 'INSERT INTO stats (date, nb_orders, total_ttc, avgorder_cost, nb_clients, nb_client_have_order) VALUES (:date, :nb_orders, :total_ttc, :avgorder_cost, :nb_clients, :nb_client_have_order)';
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                "date" => $date->format("Y-m-d H:i:s"),
                "nb_orders" => $nbOrders,
                "total_ttc" => $totalOrdersTTC,
                "avgorder_cost" => $avgOrders,
                "nb_clients" => $nbCustomers,
                "nb_client_have_order" => $nbCustomersOrdered
            ]);
        } else {
            $sql = 'UPDATE stats SET date=:date, nb_orders=:nb_orders, total_ttc=:total_ttc, avgorder_cost=:avgorder_cost, nb_clients=:nb_clients, nb_client_have_order=:nb_client_have_order';
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                "date" => $date->format("Y-m-d H:i:s"),
                "nb_orders" => $nbOrders,
                "total_ttc" => $totalOrdersTTC,
                "avgorder_cost" => $avgOrders,
                "nb_clients" => $nbCustomers,
                "nb_client_have_order" => $nbCustomersOrdered
            ]);
        }
        
        return $this->handleView($this->view(["message" => "stats updated"], 201));
    }
}
