<?php

namespace App\Controller;

use App\Entity\Address;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function getOrder()
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
        return $this->render('command/order.html.twig', [
            'title' => 'Commander',
            'form' => $form->createView(),
        ]);
    }
}
