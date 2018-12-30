<?php

namespace App\Controller;

use App\Form\ClientRegisterType;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Client;
use App\Entity\Address;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Component\Form\Extension\Core\Type\PasswordType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/admin", name="adminhome")
     */
    public function getAdmin()
    {
        return new Response(
            '<html><body> admin page </body></html>'
        );
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function getProfile(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $notifProfile = null;
        $client = $this->getUser();
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordValid = $passwordEncoder->isPasswordValid($client, $client->getPlainPassword());
            $newPassword = $passwordEncoder->encodePassword($client, $client->getNewPassword());
            if (!$passwordValid) {
                $notifProfile = [
                    'msg' => 'mots de passe incorrecte!',
                    'class' => 'alert-danger',
                ];
            } else {
                if ($client->getNewPassword() != null) {
                    dump('change');
                    $client->setPassword($newPassword);
                    $notifProfile = [
                        'msg' => 'profil mis à jour et mots de passe modifier!',
                        'class' => 'alert-success',
                    ];
                } else
                    $notifProfile = [
                        'msg' => 'profil mis à jour!',
                        'class' => 'alert-success',
                    ];

                //save client in db
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($client);
                $entityManager->flush();
            }
        }

        return $this->render('security/profile.html.twig', [
            'title' => 'Profil',
            'form' => $form->createView(),
            'notifProfile' => $notifProfile,
        ]);
    }

    /**
     * @Route("/profile/address/{id}", name="removeAddress")
     */
    public function deleteAddress($id, Request $request){
//        for remode addresse
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($a);
//            $entityManager->flush();
//        }
        return new Response(
            '{error:"address not remove"}'
        );
    }

    /**
     * @Route("/profile/address", name="address")
     */
    public function getAddress(Request $request){
        $leClient = $this->getUser();
        $address = $leClient->getAddress();


        return $this->render('security/address.html.twig', [
            'title' => 'Adresse',
            'address' => $address,
            //'form' => $form,
        ]);
    }

    /**
     * @Route("/register", name="register")
    */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $newClient = new Client();

        $form = $this->createForm(ClientRegisterType::class, $newClient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($newClient, $newClient->getPlainPassword());
            $newClient->setPassword($password);
            $newClient->setCreationDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newClient);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render('security/register.html.twig', [
            'title' => 'Connexion',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $form = $this->get('form.factory')
            ->createNamedBuilder(null)
            ->add('_username', TextType::class, [
                'label' => 'Identifiant',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Identifiant"
                    ],
                ])
            ->add('_password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Mots de passe"
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' =>'Se connecter',
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ])
            ->getForm();
        return $this->render('security/login.html.twig', [
            'title' => 'Connexion',
            'form' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}

