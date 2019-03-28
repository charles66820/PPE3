<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Command;
use App\Entity\CommandContent;
use App\Entity\Comment;
use App\Entity\Opinion;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    private function genRandTxt($l = 10) {
        return substr(
            str_shuffle(
                str_repeat(
                    $x='0123 4567 89ab cdef ghij klmn opqr stuv wxyz ABCD EFGH IJKL MNOP QRST UVWX YZ',
                    ceil($l/strlen($x)
                    )
                )
            ),
            1,
            $l
        );
    }

    private function p($msg, $b = false) {
        return $b? print "   \033[33m> \033[32m".$msg."\033[0m" : "   \033[33m> \033[32m".$msg."\033[0m";
    }

    private function pr($msg, $row = 1) {
        print "\033[".$row."A\r".$this->p($msg)."\033[100D\033[".$row."B";
    }

    private function alreadyInCommand(Command $command, Product $product) {
        foreach ($command->getCommandContents() as $commandContent) {
            if ($commandContent->getProduct() === $product) return true;
        }
        return false;
    }

    public function load(ObjectManager $manager)
    {
        //les variable
        $nbCat = 6;
        $nbProductByCat = 100000;
        $nbClient = 2500;
        $nbMaxCommand = 4;
        $nbMaxCommandContent = 6;
        $v = true;
        $products = [];
        $tax = $this->getReference(TaxFixtures::TAX_REFERENCE);

        if ($v) $this->p("Category 0%\n", true);
        if ($v) $this->p("Product 0%\n", true);

        //les categori
        for ($i = 0; $i < $nbCat; $i++) {
            $cat = new Category();
            $cat->setName('cat'.$i);
            $cat->setTitle('une categorie '.$i);
            $manager->persist($cat);

            //les produit
            for ($j = 0; $j < $nbProductByCat; $j++) {
                $product = new Product();
                $product->setTitle('Produit n°'.$j.$i);
                $product->setQuantity(rand(1,100));
                $product->setUnitPriceHT(rand(10,50));
                $product->setCategory($cat);
                $product->setDescription('Une description du produit '.$j.$i);
                $product->setReference(uniqid());
                $product->setBarcode(rand(1000000000000,9999999999999));
                $manager->persist($product);

                $products[] = $product;

                if ($v) $this->pr("Products ".round(($j + ($nbProductByCat * $i)) * 100 / ($nbProductByCat * $nbCat))."% | (".($j + ($nbProductByCat * $i))."/".($nbProductByCat * $nbCat).")");
            }
            if ($v) $this->pr("Categories ".round(($i * 100) / $nbCat)."% | (".$i."/".$nbCat.")",2);
        }
        if ($v) $this->pr("Categories 100% | (".$nbCat."/".$nbCat.")",2);
        if ($v) $this->pr("Products 100% | (".($nbProductByCat * $nbCat)."/".($nbProductByCat * $nbCat).")");

        if ($v) $this->p("Client 0%\n", true);

        //les clients
        for ($i = 0; $i < $nbClient; $i++) {
            $client = new Client();
            $client->setConfirmed(true);
            $client->setEmail('toto'.$i.'@gmail.com');
            $client->setFirstName('Toto'.$i);
            $client->setLastName('Tutu');
            $client->setToken(md5(uniqid()));
            $client->setCreationDate(new \DateTime());
            $client->setLogin('toto'.$i);
            $client->setPhoneNumber('0652'.rand(10,99).'05'.rand(10,99));
            $password = $this->encoder->encodePassword($client, '123456');
            $client->setPassword($password);
            $manager->persist($client);

            //commantaire du client
            $nbComment = rand(0,4);
            for ($j = 0; $j < $nbComment; $j++) {
                $comment = new Comment();
                $comment->setTitle('commentaire du client '.$j);
                $comment->setClient($client);
                $comment->setDate(new \DateTime());
                $comment->setContent($this->genRandTxt(rand(100,1000)));
                $comment->setProduct($products[rand(0,count($products)-1)]);
                $manager->persist($comment);
            }

            //avis du client
            for ($j = 0; $j < rand(0,4); $j++) {
                $opinion = new Opinion();
                $opinion->setDate(new \DateTime());
                $opinion->setScore(rand(1,5));
                $opinion->setClient($client);
                $opinion->setProduct($products[rand(0,count($products)-1)]);
                $manager->persist($opinion);
            }

            //address du client
            for ($j = 0; $j < rand(1,4); $j++) {
                $address = new Address();
                $address->setClient($client);
                $address->setCity('ville'.$i.$j);
                $address->setWay('une adresse au pif'.$i.$j);
                if (rand(0,1)) $address->setComplement('un complement d\'adresse au pif'.$i.$j);
                $address->setZipCode(rand(01000,99999));
                $address->setCountry('france');
                $manager->persist($address);

                $client->addAddress($address);
            }

            //commandes du client
            for ($j = 0; $j < rand(0,$nbMaxCommand); $j++) {
                $command = new Command();
                $command->setClient($client);
                $command->setDate(new \DateTime());
                $command->setShipping(10);
                $command->setAddressDelivery($client->getAddress()[rand(0,count($client->getAddress())-1)]);

                $totalPrice = 0;
                for ($k = 0; $k < rand(1,$nbMaxCommandContent); $k++) {
                    $cContent = new CommandContent();
                    $cContent->setQuantity(rand(1,6));
                    $cContent->setTax($tax);
                    $cContent->setCommand($command);

                    //évite d'avoire deux fois le meme produit
                    do {
                        $product = $products[rand(0,count($products)-1)];
                    }
                    while ($this->alreadyInCommand($command, $product));
                    $cContent->setProduct($product);
                    $cContent->setUnitPriceHT($product->getUnitPriceHT());
                    $totalPrice += ($product->getUnitPriceHT() * (($tax->getTax()/100)+1)) * $cContent->getQuantity();

                    $manager->persist($cContent);
                }

                $command->setTaxOnCommand(($totalPrice * (($tax->getTax()/100)+1)) - $totalPrice);
                $command->setTotalHT($totalPrice + $command->getShipping());
                $manager->persist($command);
            }
            if ($v) $this->pr("Client ".round($i * 100 / $nbClient)."% | (".$i."/".$nbClient.")");
        }
        if ($v) $this->pr("Client 100% | (".$nbClient."/".$nbClient.")");

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AdminFixtures::class,
            TaxFixtures::class,
        ];
    }
}
