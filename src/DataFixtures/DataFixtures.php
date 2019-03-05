<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductPicture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DataFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = json_decode(@file_get_contents(__DIR__."/dbData.json"));
        if ($categories == null) {
            print "   \033[33m> \033[31m\"dbData.json\" not found!\033[0m\n";
            exit;
        }

        foreach ($categories as $category) {
            $cat = new Category();
            $cat->setName($category->nom);
            $cat->setTitle($category->lbl);
            $manager->persist($cat);

            foreach ($category->produits as $p){
                $product = new Product();
                $product->setTitle($p->lbl);
                $product->setUnitPriceHT($p->prix);
                $product->setReference($p->reference);
                $product->setQuantity($p->quantite);
                $product->setDescription($p->description);
                $product->setCategory($cat);
                $manager->persist($product);

                foreach ($p->photos as $picture) {
                    $pic = new ProductPicture();
                    $pic->setProduct($product);
                    $pic->setPictureName($picture->photo);
                    $pic->setUpdatedAt(new \DateTime());
                    $manager->persist($pic);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TaxFixtures::class,
        ];
    }
}
