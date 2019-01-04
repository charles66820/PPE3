<?php

namespace App\Controller;

use App\Entity\CartLine;
use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;
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
        $leClient = $this->getUser();
        if($leClient == null){
            return $this->render('error/404.html.twig', [
                'title' => '404 le client n\'a pas été trouvé!',
                'msgerr' => 'le client n\'a pas été trouvé!',
            ]);
        }
        return $this->render('market/cart.html.twig', [
            'title' => 'Votre panier',
        ]);
    }
    /**
     * @Route("/cart/add/{id}/{qty<\d+>}", name="cartLineAdd")
     */
    public function postCartLineAdd(Product $product = null, $qty, ObjectManager $manager)
    {
        if($product == null){
            return $this->json([
                'msg' => 'Product not found!',
            ], 404);
        }

        $leClient = $this->getUser();
        if($leClient == null){
            return $this->json([
                'msg' => 'Client not found!',
            ], 404);
        }

        //vérification pour que la quentitée se trouve entre 0 et le nombre max de produit
        if ($qty <= 0 ) $qty = 1;
        if ($qty > $product->getQuantity()) $qty = $product->getQuantity();

        $cartLine = null;
        //TODO: $cartLine product existe
        foreach ($leClient->getCartLines() as $oneCartLine){
            if ($oneCartLine->getProduct() == $product){
                $cartLine = $oneCartLine;
            }
        }

        //création de la ligne du panier
        if ($cartLine == null) {
            $cartLine = new CartLine();
            $cartLine->setClient($leClient);
            $cartLine->setProduct($product);
            $cartLine->setQuantity($qty);
            $leClient->addCartLine($cartLine);
        } else {
            if ($cartLine->getQuantity() + $qty > $product->getQuantity()) {
                $qty = $product->getQuantity();
            } else {
                $qty += $cartLine->getQuantity();
            }
            $cartLine->setQuantity($qty);
        }

        $manager->persist($cartLine);
        $manager->flush();

        return $this->json([
            'msg' => 'Le produit a bien ete ajoute au panier',
        ], 200);
    }
    /**
     * @Route("/cart/remove/{id}/{qty}", name="cartLineRemove")
     */
    public function postCartLineRemove(Product $product = null, $qty)
    {
        return new Response(
            '<html><body>cart line remove </body></html>'
        );
    }
    /**
     * @Route("/cart/remove/{id}", name="cartLineRemoveAll")
     */
    public function postCartLineRemoveAll(Product $product = null)
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
