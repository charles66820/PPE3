<?php

namespace App\Controller\Rest;

use App\Entity\Command;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", host="api.%domain%")
 */
class OrderApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/orders/{id}")
     */
    public function getOrderById(Command $order = null)
    {
        if ($order == null) {
            throw new HttpException(404, "Order not found");
        }

        $orderInfo = [
            "id" => $order->getId(),
            "total" => $order->getTotalHT() + $order->getTaxOnCommand(),
            "shipping" => (float)$order->getShipping(),
            "deliveryAddress" => $order->getAddressDelivery()->getAddress(),
            "status" => $order->getStatus(),
            "orderedProduct" => [],
        ];

        foreach ($order->getCommandContents() as $orderContent) {
            $orderInfo["orderedProduct"][] = [
                "id" => $orderContent->getId(),
                "title" => $orderContent->getProduct()->getTitle(),
                "reference" => $orderContent->getProduct()->getReference(),
                "priceTTC" => $orderContent->getUnitPrice(),
                "quantity" => $orderContent->getQuantity(),
            ];
        }

        return $this->handleView($this->view($orderInfo, 200));
    }
}
