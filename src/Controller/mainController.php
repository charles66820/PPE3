<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class mainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function getHome(Request $request)
    {
        $form = $this->createFormBuilder(new Client())
            ->add('Pseudo', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Motdepasse', PasswordType::class)
            ->add('submit', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newClient = $form->getData();
            $newClient->setDatecreation(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newClient);
            $entityManager->flush();

            //return $this->redirectToRoute('');
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
