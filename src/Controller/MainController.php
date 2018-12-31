<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;


class MainController extends AbstractController
{
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
        return $this->redirectToRoute('catalogC', ['cat'=>'all'], 302);
    }

    /**
     * @Route("/catalog/{cat}", name="catalogC")
     */
    public function getCatalogC($cat)
    {
        $products = [];

        if ($cat == 'all') {
            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findAll();
        } else {
            $category = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findOneBy(['name' => $cat]);
            //TODO: star and price and search
            $products = $category->getProducts();
        }

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

        if($product == null){
            return $this->render('error/404.html.twig', [
                'title' => '404 le produit n\'existe pas!',
                'msgerr' => 'Le produit n\'existe pas!',
            ]);
        }

        return $this->render('main/product.html.twig', [
            'title' => 'Produit | '.$product->getTitle(),
            'product' => $product,
        ]);
    }
}
