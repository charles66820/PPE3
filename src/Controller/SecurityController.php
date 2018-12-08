<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;

use \Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Component\Form\Extension\Core\Type\EmailType;
use \Symfony\Component\Form\Extension\Core\Type\PasswordType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $newClient = new Client();

        $form = $this->createFormBuilder($newClient)
            ->add('login', TextType::class, [
                'label' => 'Votre identifiant',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Identifiant"

                ],
            ])
            ->add('email', RepeatedType::class, [
                'required' => true,
                'invalid_message' => 'L\'email et l\'email de confirmation ne sont pas identique.',
                'type' => EmailType::class,
                'first_options'  => [
                    'label' => 'Votre email',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Votre email"
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez votre email',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => "Confirmez votre email"
                    ],
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre mot de passe"
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Confirmez votre mot de passe',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Confirmez votre mot de passe"
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre nom"
                ],
                'required' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre prénom"
                ],
                'required' => false,
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Votre n° de téléphone',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Votre n° de téléphone"
                ],
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'attr'=> [
                    'class'=> 'btn btn-primary',
                    'placeholder'=> "Je m'inscris"
                ]
            ])
            ->getForm();

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
            ->add('_username', TextType::class, ['label' => 'Email'])
            ->add('_password', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('ok', SubmitType::class)
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
