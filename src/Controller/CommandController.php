<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Command;
use App\Entity\CommandContent;
use App\Entity\Product;
use App\Entity\Tax;
use App\Services\PayPalService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Exception\PayPalConnectionException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function getOrder(Request $request)
    {
        $leClient = $this->getUser();
        if($leClient == null){
            return $this->json([
                'msg' => 'Client not found!',
            ], 404);
        }
        $form = $this->get('form.factory')
            ->createNamedBuilder('chooseAddress')
            ->add('deliveryAddress', EntityType::class, [
                'label' => 'Adresse de livraison :',
                'label_attr' => [
                    'class' => 'col-12 col-sm-3 col-form-label',
                ],
                'required' => true,
                'class' => Address::class,
                'query_builder' => function (EntityRepository $er) use ($leClient) {
                    return $er->createQueryBuilder('a')
                        ->where('a.client = :idcli')
                        ->setParameter('idcli', $leClient->getId());
                },
                'choice_label' => 'address',
                'attr' => [
                    'class' => 'form-control',
                ],
                'data'=> $leClient->getDefaultAddress(),
            ])
            ->add('submit', SubmitType::class, [
                'label' =>'Commander',
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $idDeliveryAddress = $request->request->get('chooseAddress')['deliveryAddress'];
            $deliveryAddressValid = false;
            foreach ($leClient->getAddress() as $address) {
                if ($address->getId() == $idDeliveryAddress) $deliveryAddressValid = true;
            }

            if ($idDeliveryAddress == null || !$deliveryAddressValid) {
                return $this->render('market/order.html.twig', [
                    'title' => 'Commander',
                    'form' => $form->createView(),
                    'notifOrder' => [
                        'msg' => 'Erreur avec l\'adresse de livraison',
                        'class' => 'alert-danger',
                    ]
                ]);
            }

            $address = $this->getDoctrine()
                ->getRepository(Address::class)
                ->find($idDeliveryAddress);

            //url
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($this->getParameter('completUrl').$this->generateUrl('paymentdone'));
            $redirectUrls->setCancelUrl($this->getParameter('completUrl').$this->generateUrl('paymentcancel'));

            //payment method
            $payer = new Payer();
            $payer->setPaymentMethod("paypal");

            $apiContext = PayPalService::getPayPalApiContext();
            $transaction = PayPalService::getPayPalTransaction($leClient, $address);

            $transaction->setCustom(JSON_encode([
                'idAddress' => $idDeliveryAddress,
            ]));

            // payment
            $payment = new Payment();
            $payment->setIntent('sale');
            $payment->setPayer($payer);
            $payment->setRedirectUrls($redirectUrls);
            $payment->setTransactions([$transaction]);

            try {
                $payment->create($apiContext);
                // echo json_encode([
                //   'id' => $payment->getId()
                // ]);
                return $this->redirect($payment->getApprovalLink());
            } catch (PayPalConnectionException $e) {
                if ($this->getParameter('kernel.environment') == "dev"){
                    dump($e->getData());die();
                }
                return $this->render('market/order.html.twig', [
                    'title' => 'Commander',
                    'form' => $form->createView(),
                    'notifOrder' => [
                        'msg' => 'Erreur avec lors du paiment',
                        'class' => 'alert-danger',
                    ]
                ]);
            } catch (\Exception $e) {
                if ($this->getParameter('kernel.environment') == "dev"){
                    dump($e);die();
                }
                return $this->render('market/order.html.twig', [
                    'title' => 'Commander',
                    'form' => $form->createView(),
                    'notifOrder' => [
                        'msg' => 'Erreur avec lors du paiment',
                        'class' => 'alert-danger',
                    ]
                ]);
            }
        }

        return $this->render('market/order.html.twig', [
            'title' => 'Commander',
            'form' => $form->createView(),
            'notifOrder' => null,
        ]);
    }

    /**
     * @Route("/command/paymentdone", name="paymentdone")
     */
    public function getPaymentDone(Request $request, ObjectManager $manager)
    {
        $leClient = $this->getUser();
        if($leClient == null){
            return $this->json([
                'msg' => 'Client not found!',
            ], 404);
        }

        $apiContext = PayPalService::getPayPalApiContext();
        $payment = Payment::get($_GET["paymentId"], $apiContext);
        $custom = JSON_decode($payment->getTransactions()[0]->getCustom());

        $idDeliveryAddress = $custom->idAddress;
        $deliveryAddressValid = false;
        foreach ($leClient->getAddress() as $a) {
            if ($a->getId() == $idDeliveryAddress) $deliveryAddressValid = true;
        }

        if ($idDeliveryAddress == null || !$deliveryAddressValid) {
            return $this->redirectToRoute('paymenterror');
        }

        $address = $this->getDoctrine()
            ->getRepository(Address::class)
            ->find($idDeliveryAddress);

        $transaction = PayPalService::getPayPalTransaction($leClient, $address);

        $execution = new PaymentExecution();
        $execution->setPayerID($_GET["PayerID"]);
        $execution->setTransactions([$transaction]);

        try {
            $payment->execute($execution, $apiContext);
        } catch (PayPalConnectionException $e) {
            if ($this->getParameter('kernel.environment') == "dev"){
                dump($e->getData());die();
            }
        } catch (\Exception $e) {
            if ($this->getParameter('kernel.environment') == "dev"){
                dump($e);die();
            }
        }

        $command = new Command();
        $command->setClient($leClient);
        $command->setDate(new \DateTime());
        $command->setAddressDelivery($address);
        $command->setShipping($payment->getTransactions()[0]->getAmount()->getDetails()->getShipping());
        $command->setTaxOnCommand($payment->getTransactions()[0]->getAmount()->getDetails()->getTax());
        $command->setTotalHT($payment->getTransactions()[0]->getAmount()->getTotal());
        $manager->persist($command);

        $content = $payment->getTransactions()[0]->getItemList()->getItems();
        foreach ($content as $item) {
            $commandContent = new CommandContent();
            $commandContent->setTax($this->getDoctrine()
                ->getRepository(Tax::class)
                ->find(1));
            $commandContent->setUnitPriceHT($item->getPrice());
            $commandContent->setQuantity($item->getQuantity());
            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findBy(['reference' => $item->getSku()]);
            $commandContent->setProduct($products[0]);
            $commandContent->setCommand($command);
            $command->addCommandContent($commandContent);
            $manager->persist($commandContent);
        }
        $manager->flush();

        //suppretion du panier
        foreach ($leClient->getCartLines() as $cartLine){
            $leClient->removeCartLine($cartLine);
            $manager->remove($cartLine);
        }
        $manager->flush();

        return $this->redirectToRoute('commands');
    }

    /**
     * @Route("/paymentcancel", name="paymentcancel")
     */
    public function getPaymentCancel()
    {
        return $this->render('market/orderCancel.html.twig', [
            'title' => 'Command annuler',
        ]);
    }

    /**
     * @Route("/command/paymenterror", name="paymenterror")
     */
    public function getPaymentFail()
    {
        return $this->render('error/400.html.twig', [
            'title' => '400 : Bad Request!',
            'msgerr' => 'Erreur avec l\'adresse de livraison!',
        ]);
    }

    /**
     * @Route("/commandes", name="commands")
     */
    public function getCommands()
    {
        return $this->render('market/commands.html.twig', [
            'title' => 'Mes commandes',
        ]);
    }
}
