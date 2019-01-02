<?php

namespace App\Services;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Category;

class TwigEntityService
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

    public static function getAllProduct()
    {
        return self::$manager->getRepository(Product::class)
            ->findAll();
    }
}