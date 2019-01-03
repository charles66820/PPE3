<?php

namespace App\Services;

use App\Entity\Product;
use App\Entity\Tax;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class TwigEntityService
{
    private static $manager;
    public function __construct(ObjectManager $em)
    {
        self::$manager = $em;
    }

    public static function getAllCategorys()
    {
        return self::$manager->getRepository(Category::class)
            ->findAllBySQL();
    }

    public static function getAllProduct()
    {
        return self::$manager->getRepository(Product::class)
            ->findAll();
    }

    public static function getTax()
    {
        return self::$manager->getRepository(Tax::class)
            ->findAll()[0]->getTax();
    }



    public static function getStarsClass($moyenneStars){
        $result = 'stars0';
        switch ($moyenneStars) {
            case 0:
                $result = "stars0";
                break;
            case ($moyenneStars <= 0.5):
                $result = "stars0_5";
                break;
            case ($moyenneStars <= 1):
                $result = "stars1";
                break;
            case ($moyenneStars <= 1.5):
                $result = "stars1_5";
                break;
            case ($moyenneStars <= 2):
                $result = "stars2";
                break;
            case ($moyenneStars <= 2.5):
                $result = "stars2_5";
                break;
            case ($moyenneStars <= 3):
                $result = "stars3";
                break;
            case ($moyenneStars <= 3.5):
                $result = "stars3_5";
                break;
            case ($moyenneStars <= 4):
                $result = "stars4";
                break;
            case ($moyenneStars <= 4.5):
                $result = "stars4_5";
                break;
            default:
                $result = 'stars5';
                break;
        }
        return $result;
    }
}