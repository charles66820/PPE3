<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MarketController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function getCart()
    {
        return new Response(
            '<html><body>cart page </body></html>'
        );
        //Votre panier
    }
    /**
     * @Route("/cart/add/{id}/{qty}", name="cartLineAdd")
     */
    public function postCartLineAdd(Product $product, $qty)
    {
        return new Response(
            '<html><body>cart line add</body></html>'
        );
    }
    /**
     * @Route("/cart/remove/{id}/{qty}", name="cartLineRemove")
     */
    public function postCartLineRemove(Product $product, $qty)
    {
        return new Response(
            '<html><body>cart line remove </body></html>'
        );
    }
    /**
     * @Route("/cart/remove/{id}", name="cartLineRemoveAll")
     */
    public function postCartLineRemoveAll(Product $product)
    {
        return new Response(
            '<html><body>cart line remove all</body></html>'
        );
    }
    /**
     * @Route("/cart/remove", name="cartRemove")
     */
    public function postCartRemove()
    {
        return new Response(
            '<html><body>cart remove all</body></html>'
        );
    }
}
