<?php

namespace App\Services;

use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Category;

class CategoryService
{
    private static $manager;
    public function __construct(RegistryInterface $registry)
    {
        self::$manager = $registry->getManagerForClass(Category::class);
    }

    public static function getAllCategorys()
    {
        return self::$manager->getRepository(Category::class)
            ->findAll();
    }
}