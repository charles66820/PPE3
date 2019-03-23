<?php

namespace App\Controller\Rest;

use App\Entity\Category;
use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api")
 */
class ProductsApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/products/{id}")
     */
    public function getProductsById(Product $product = null)
    {
        if ($product == null) {
            throw new HttpException(404, "Product not found");
        }

        $productInfo = [
            "id" => $product->getId(),
            "title" => $product->getTitle(),
            "priceTTC" => $product->getUnitPrice(),
            "reference" => $product->getReference(),
            "quantity" => $product->getQuantity(),
            "category" => [
                "id" => $product->getCategory()->getId(),
                "title" => $product->getCategory()->getTitle(),
                "name" => $product->getCategory()->getName(),
            ],
            "description" => $product->getDescription(),
            "pictures" => [],
            "comments" => [],
            "opinionAVG" => $product->GetAverageOpinion(),
        ];

        foreach ($product->getPictures() as $productPicture) {
            $productInfo["pictures"][] = [
                "fileName" => $productPicture->getPictureName(),
            ];
        }

        foreach ($product->getComments() as $comment) {
            $productInfo["comments"][] = [
                "id" => $comment->getId(),
                "date" => $comment->getDate(),
                "title" => $comment->getTitle(),
                "content" => $comment->getContent(),
                "author" => $comment->getClient()->getFullName(),
            ];
        }

        return $this->handleView($this->view($productInfo, 200));
    }

    /**
     * @Rest\Get("/products")
     */
    public function getProducts()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findall();

        $allProducts = [];
        foreach ($products as $product) {
            $allProducts[] = [
                "id" => $product->getId(),
                "title" => $product->getTitle(),
                "priceTTC" => $product->getUnitPrice(),
                "quantity" => $product->getQuantity(),
                "mainPicture" => (count($product->getPictures()) > 0 )? $product->getPictures()[0]->getPictureName() : null,
                "opinionAVG" => $product->GetAverageOpinion(),
            ];
        }

        return $this->handleView($this->view($allProducts, 200));
    }

    /**
     * @Rest\Get("/catalog")
     */
    public function getCatalog()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findall();

        $allCategories = [];
        foreach ($categories as $category) {
            $allProducts = [];
            foreach ($category->getProducts() as $product) {
                $allProducts[] = [
                    "id" => $product->getId(),
                    "title" => $product->getTitle(),
                    "priceTTC" => $product->getUnitPrice(),
                    "quantity" => $product->getQuantity(),
                    "mainPicture" => (count($product->getPictures()) > 0 )? $product->getPictures()[0]->getPictureName() : null,
                    "opinionAVG" => $product->GetAverageOpinion(),
                ];
            }

            $allCategories[] = [
                "id" => $category->getId(),
                "title" => $category->getTitle(),
                "name" => $category->getName(),
                "products" => $allProducts,
            ];
        }

        return $this->handleView($this->view($allCategories, 200));
    }

    /**
     * @Rest\Get("/categories")
     */
    public function getCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findall();

        $allCategories = [];
        foreach ($categories as $category) {
            $allCategories[] = [
                "id" => $category->getId(),
                "title" => $category->getTitle(),
                "name" => $category->getName(),
            ];
        }

        return $this->handleView($this->view($allCategories, 200));
    }
}
