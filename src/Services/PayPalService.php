<?php
namespace App\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class PayPalService
{
    private static $manager;
    private static $container;
    public function __construct(ContainerInterface $container)
    {
        self::$container = $container;
    }

    public static function getPayPalPayment()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                getenv('PAYPALCLIENT'),
                getenv('PAYPALSECRET')
            )
        );
    }
}