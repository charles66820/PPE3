<?php

namespace App\DataFixtures;

use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TaxFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $tax = new Tax();
        $tax->setTax(20);
        $manager->persist($tax);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['AppFixtures', 'DataFixtures'];
    }
}