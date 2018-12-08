<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'name' => 'estelle',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function getHome()
    {
        return $this->render('main/home.html.twig', [
            'title' => 'Accueil',
        ]);
    }
    /**
     * @Route("/mentionslegales", name="legal")
     */
    public function getLegalNotice()
    {
        return $this->render('main/legal.html.twig', [
            'title' => 'Mentions legales',
        ]);
    }
    /**
     * @Route("/catalog", name="catalog")
     */
    public function getCatalog()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('main/catalog.html.twig', [
            'title' => 'Tous les produits',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function getProduct($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        return $this->render('main/product.html.twig', [
            'title' => 'Produit | '.$product->getTitle(),
            'product' => $product,
        ]);
    }
}
