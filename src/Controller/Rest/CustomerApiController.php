<?php

namespace App\Controller\Rest;

use App\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", host="api.%domain%")
 */
class CustomerApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/customer/{login}")
     */
    public function getCustomerByLogin($login, ObjectManager $manager)
    {
        if ($login == null) {
            throw new HttpException(400, "Bad request");
        }

        $conn = $manager->getConnection();
        $sql = 'SELECT * FROM client WHERE login = :log';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["log" => $login]);
        $data = $stmt->fetch();

        //check if customer exist
        if ($stmt->rowCount() == 0) {
            throw new HttpException(404, "Customer not found");
        }

        $customer = [
            "id" => $data['id_client'],
            "login" => $data['login'],
            "email" => $data['email'],
            "lastName" => $data['last_name'],
            "firstName" => $data['first_name'],
            "phoneNumber" => $data['phone_number'],
            "avatar" => $data['avatar_url'],
            "createdDate" => $data['creation_date'],
        ];

        return $this->handleView($this->view($customer, 200));
    }

    /**
     * @Rest\Get("/customer/{id}/addresses")
     */
    public function getAddressesByCustomerId(Client $client, ObjectManager $manager)
    {
        if ($client == null) {
            throw new HttpException(404, "Customer not found");
        }

        $conn = $manager->getConnection();
        $sql = 'SELECT * FROM address WHERE id_client = :idclient';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["idclient" => $client->getId()]);
        $data = $stmt->fetchAll();

        $addresses = [];
        foreach ($data as $d) {
            $addresses[] = [
                "id" => $d['id_address'],
                "way" => $d['way'],
                "complement" => $d['complement'],
                "postalCode" => $d['zip_code'],
                "city" => $d['city'],
                "country" => $d['country'],
            ];
        }

        return $this->handleView($this->view(["addresses"=>$addresses], 200));
    }

    /**
     * @Rest\Get("/customer/{id}/orders")
     */
    public function getOrdersByCustomerId(Client $client = null)
    {
        if ($client == null) {
            throw new HttpException(404, "Customer not found");
        }

        $orders = [];
        foreach ($client->getCommands() as $order) {
            $orders[] = [
                "id" => $order->getId(),
                "total" => $order->getTotalHT() + $order->getTaxOnCommand(),
                "shipping" => (float)$order->getShipping(),
                "deliveryAddress" => $order->getAddressDelivery()->getAddress(),
                "status" => $order->getStatus(),
            ];
        }

        return $this->handleView($this->view(["orders"=>$orders], 200));
    }
}
