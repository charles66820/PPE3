<?php
namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class mainController extends AbstractController
{
    public function getHome()
    {
        $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();
        return $this->render('test.twig',
            [
                'clients'   =>  $clients
            ]
        );
    }
}
