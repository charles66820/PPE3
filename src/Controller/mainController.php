<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class mainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function getHome(Request $request)
    {
        $unClient = new Client();
        $form = $this->createFormBuilder($unClient)
            ->add('Pseudo', TextType::class)
            ->add('Email', TextType::class)
            ->add('submit', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            echo "toto";
            dump($data);
            //$newClient
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($newClient);
            // $entityManager->flush();

            //return $this->redirectToRoute('log');
        }

        $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();
        return $this->render('test.twig',
            [
                'form' => $form->createView(),
                'clients'   =>  $clients
            ]
        );
    }

    /**
     * @Route("/test", name="test")
     */
    public function getTest()
    {
        return $this->render('base.html.twig', [] );
    }
}
