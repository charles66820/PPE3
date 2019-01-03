<?php

namespace App\Controller;

use App\Entity\Product;
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
        //Votre panier
    }
    /**
     * @Route("/card/add/{id}/{qty}", name="cardLineAdd")
     */
    public function postCardLineAdd(Product $product, $qty)
    {
        dump($product, $qty);
        return new Response(
            '<html><body>card line add</body></html>'
        );
    }
    /**
     * @Route("/card/remove/{id}/{qty}", name="cardLineRemove")
     */
    public function postCardLineRemove(Product $product, $qty)
    {
        dump($product, $qty);die();
        return new Response(
            '<html><body>card line remove </body></html>'
        );
    }
    /**
     * @Route("/card/remove/{id}", name="cardLineRemoveAll")
     */
    public function postCardLineRemoveAll(Product $product)
    {
        dump($product);die();
        return new Response(
            '<html><body>card line remove all</body></html>'
        );
    }
    /**
     * @Route("/card/remove", name="cardRemove")
     */
    public function postCardRemove()
    {
        return new Response(
            '<html><body>card remove all</body></html>'
        );
    }
}
