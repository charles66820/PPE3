<?php

namespace App\Services;

use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Category;

class CategoryService
{
    private $manager;
    public function __construct(RegistryInterface $registry)
    {
        $this->manager = $registry->getManagerForClass(Category::class);
    }

    public function getAllCategorys()
    {
        return $this->manager->getRepository(Category::class)
            ->findAll();
    }
}