<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture implements FixtureGroupInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    private function p($msg, $b = false) {
        return $b? print "   \033[33m> \033[32m".$msg."\033[0m" : "   \033[33m> \033[32m".$msg."\033[0m";
    }

    public function load(ObjectManager $manager)
    {
        $v = true;

        //add admin
        $admin = new Client();
        $admin->setConfirmed(true);
        $admin->setEmail('charles.goedefroit@gmail.com');
        $admin->setToken(md5(uniqid()));
        $admin->setCreationDate(new \DateTime());
        $admin->setLogin('admin');
        $password = $this->encoder->encodePassword($admin, '123456');
        $admin->setPassword($password);
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);
        if ($v) $this->p("Admin created\n", true);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['AppFixtures'];
    }
}