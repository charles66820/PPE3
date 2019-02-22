<?php

namespace App\DataFixtures;

use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TaxFixtures extends Fixture implements FixtureGroupInterface
{
    public const TAX_REFERENCE = 'tax';

    private function p($msg, $b = false) {
        return $b? print "   \033[33m> \033[32m".$msg."\033[0m" : "   \033[33m> \033[32m".$msg."\033[0m";
    }

    public function load(ObjectManager $manager)
    {
        $v = true;

        $tax = new Tax();
        $tax->setTax(20);
        $manager->persist($tax);
        if ($v) $this->p("Tax 100%\n", true);

        $manager->flush();

        $this->addReference(self::TAX_REFERENCE, $tax);
    }

    public static function getGroups(): array
    {
        return ['AppFixtures', 'DataFixtures'];
    }
}