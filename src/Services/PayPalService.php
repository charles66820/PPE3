<?php
namespace App\Services;

use App\Entity\Address;
use App\Entity\Client;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PayPalService
{
    private static $container;
    public function __construct(ContainerInterface $container)
    {
        self::$container = $container;
    }

    public static function getPayPalApiContext()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                getenv('PAYPALCLIENT'),
                getenv('PAYPALSECRET')
            )
        );
        return $apiContext;
    }

    public static function getPayPalTransaction(Client $leClient, Address $address)
    {

        //adresse de livraision
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setRecipientName(
            $leClient->getLogin().' | '.$leClient->getLastName().' '.$leClient->getFirstName()
        );
        $shippingAddress->setLine1($address->getWay());
        $shippingAddress->setLine2($address->getComplement());
        $shippingAddress->setCity($address->getCity());
        $shippingAddress->setCountryCode("FR");
        $shippingAddress->setPostalCode($address->getZipCode());

        // liste des elements du panier
        $list = new ItemList();
        $list->setShippingAddress($shippingAddress);

        foreach ($leClient->getCartLines() as $cartLine) {
            $item = new Item();
            $item->setSku($cartLine->getProduct()->getReference());
            $item->setName($cartLine->getProduct()->getTitle());
            $item->setPrice($cartLine->getProduct()->getUnitPriceHT());
            $item->setCurrency("EUR");
            $item->setQuantity($cartLine->getQuantity());

            $list->addItem($item);
        }

        $details = new Details();
        $details->setShipping(10);
        $details->setTax($leClient->getTotalPrice()-$leClient->getTotalPriceHT());
        $details->setSubTotal($leClient->getTotalPriceHT());

        // payment amount
        $amount = new Amount();
        $amount->setCurrency("EUR");
        $amount->setTotal($leClient->getTotalPrice()+10);
        $amount->setDetails($details);

        // transaction
        $transaction = new Transaction();
        $transaction->setItemList($list);
        $transaction->setDescription("Achat sur le site de vente en ligne Ô'Tako");
        $transaction->setAmount($amount);

        return $transaction;
    }
}