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
            'lineCount' => $leClient->getCartLines()->Count(),
            'totalPriceHT' => number_format($leClient->getTotalPriceHT(), 2, ',', ' '),
            'totalPrice' => number_format($leClient->getTotalPrice(),2,',',' '),
        ], 200);
    }
    /**
     * @Route("/cart/remove/{id}/{qty<\d+>}", name="cartLineRemove")
     */
    public function postCartLineRemove(Product $product = null, $qty, ObjectManager $manager)
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

        $cartLine = null;
        foreach ($leClient->getCartLines() as $oneCartLine){
            if ($oneCartLine->getProduct() == $product){
                $cartLine = $oneCartLine;
            }
        }
        dump($cartLine);
        //création de la ligne du panier
        if ($cartLine == null) {
            return $this->json([
                'msg' => 'Le produit n\'a pas pu ete supprimer du panier',
            ], 404);
        } else {
            $qty = $cartLine->getQuantity() - $qty;

            if ($qty > $product->getQuantity()) {
                $cartLine->setQuantity($product->getQuantity());
                $manager->persist($cartLine);
            } else if ($qty <= 0 ) {
                $leClient->removeCartLine($cartLine);
                $manager->remove($cartLine);
            } else {
                $cartLine->setQuantity($qty);
                $manager->persist($cartLine);
            }
        }
        $manager->flush();

        return $this->json([
            'msg' => 'Le produit a bien ete supprimer du panier',
        ], 200);
    }
    /**
     * @Route("/cart/remove/{id}", name="cartLineRemoveAll")
     */
    public function postCartLineRemoveAll(Product $product = null, ObjectManager $manager)
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

        $cartLine = null;
        foreach ($leClient->getCartLines() as $oneCartLine){
            if ($oneCartLine->getProduct() == $product){
                $cartLine = $oneCartLine;
            }
        }

        if ($cartLine == null) {
            return $this->json([
                'msg' => 'Le produit n\'a pas pu ete elevee du panier',
            ], 404);
        }
        $leClient->removeCartLine($cartLine);
        $manager->remove($cartLine);
        $manager->flush();

        return $this->json([
            'msg' => 'Le produit a bien ete elevee du panier',
        ], 200);
    }
    /**
     * @Route("/cart/remove", name="cartRemove")
     */
    public function postCartRemove(ObjectManager $manager)
    {
        $leClient = $this->getUser();
        if($leClient == null){
            return $this->json([
                'msg' => 'Client not found!',
            ], 404);
        }

        foreach ($leClient->getCartLines() as $cartLine){
            $leClient->removeCartLine($cartLine);
            $manager->remove($cartLine);
            $manager->flush();
        }

        return $this->json([
            'msg' => 'Le panier a bien ete vidé',
        ], 200);
    }
}
