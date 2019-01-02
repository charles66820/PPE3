<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MarketController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function getCard()
    {
        return new Response(
            '<html><body>card page </body></html>'
        );
    }
}
