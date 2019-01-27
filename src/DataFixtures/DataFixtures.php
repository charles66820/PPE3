<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = json_decode(@file_get_contents(__DIR__."/dbData.json"));
        if ($categories == null) {
            print "   \033[33m> \033[31m\"dbData.json\" not found!\033[0m\n";
            exit;
        }
        foreach ($categories as $category) {
            echo $category->nom."\n";
            foreach ($category->produits as $product){
                echo "  ".$product->lbl."\n";
                foreach ($product->photos as $picture) {
                    echo "    ".$picture->photo."\n";
                }
            }
        }
        die();

        $manager->flush();
    }
}
