<?php

namespace App\Controller\Rest;

use App\Entity\Category;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", host="api.%domain%")
 */
class CategoryApiController extends AbstractFOSRestController
{
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
