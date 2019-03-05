<?php

namespace App\Controller;

use App\Form\AddressType;
use App\Form\ClientRegisterType;
use App\Form\ClientType;
use App\Repository\AddressRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Client;
use App\Entity\Address;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use \Symfony\Component\Form\Extension\Core\Type\PasswordType;
use \Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SecurityController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function getProfile(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder)
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
                    $client->setPassword($newPassword);
                    $notifProfile = [
                        'msg' => 'profil mis à jour et mots de passe modifier!',
                        'class' => 'alert-success',
                    ];
                } else {
                    $notifProfile = [
                        'msg' => 'profil mis à jour!',
                        'class' => 'alert-success',
                    ];
                }
                $file = $client->getAvatarFile();
                if ($file != null) {
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('clients_directory'),
                            $fileName
                        );
                        @unlink($this->getParameter('clients_directory').$client->getAvatarUrl());
                    } catch (FileException $e) {
                        if ($this->getParameter('kernel.environment') == "dev"){
                            dump($file,$fileName,$e);die();
                        }
                        return $this->render('error/500.html.twig', [
                            'title' => '500 erreur avec l\'envois du ficher!',
                            'msgerr' => 'L\'envois du fichier ne peut ce faire car apache n\'a pas les droit en écriture sur le dossier /public/img/',
                        ]);
                    }
                    $client->setAvatarUrl($fileName);
                }
                //save client in db
                $manager->persist($client);
                $manager->flush();
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
    public function deleteAddress(Address $address, Request $request, ObjectManager $manager){
        //pour l'ajax
        if ($request->isXmlHttpRequest()) {
            if ($this->getUser() != $address->getClient()) return new Response(json_encode(['error'=>'l\adresse n\'apartin pas au client']));
            $manager->remove($address);
            $manager->flush();
            return new Response(json_encode(['address'=>$this->getUser()->getAddress()]));
        }
        //pour les site non dinamic
        if ($this->getUser() == $address->getClient()) {
            $manager->remove($address);
            $manager->flush();
        }
        return $this->redirectToRoute('address');
    }

    /**
     * @Route("/profile/address", name="address")
     */
    public function getAddress(Request $request, ObjectManager $manager){
        $leClient = $this->getUser();
        $newAddress = new Address();
        $form = $this->createForm(AddressType::class, $newAddress);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newAddress->setClient($leClient);
            $manager->persist($newAddress);
            $manager->flush();

            return $this->redirectToRoute('address');
        }

        return $this->render('security/address.html.twig', [
            'title' => 'Adresse',
            'address' => $leClient->getAddress(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register", name="register")
    */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, ObjectManager $manager, \Swift_Mailer $mailer)
    {
        $newClient = new Client();

        $form = $this->createForm(ClientRegisterType::class, $newClient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($newClient, $newClient->getPlainPassword());
            $newClient->setPassword($password);
            $newClient->setCreationDate(new \DateTime());
            $newClient->setToken(md5(uniqid()));
            $manager->persist($newClient);
            $manager->flush();

            $message = (new \Swift_Message('Confirmation de votre inscription'))
                ->setFrom('poulpi@ppe.magicorp.fr')
                ->setTo($newClient->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/registed.html.twig',
                        [
                            'client' => $newClient,
                        ]
                    ),
                    'text/html'
                )
                ->addPart(
                    $this->renderView(
                        'emails/base.txt.twig'
                    ),
                    'text/plain'
                )
            ;
            $mailer->send($message);

            return $this->redirectToRoute('login');
        }
        return $this->render('security/register.html.twig', [
            'title' => 'Connexion',
            'form' => $form->createView(),
            'test' => [
                md5(uniqid()),

            ]
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

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/profile/sendEmailConfirm", name="sendEmailConfirm")
     */
    public function sendEmailConfirm(\Swift_Mailer $mailer){
        $message = (new \Swift_Message('Confirmation de votre compte'))
            ->setFrom('poulpi@ppe.magicorp.fr')
            ->setTo($this->getUser()->getEmail())
            ->setBody(
                $this->renderView(
                    'emails/confirm.html.twig',
                    [
                        'client' => $this->getUser(),
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView(
                    'emails/base.txt.twig'
                ),
                'text/plain'
            )
        ;
        $mailer->send($message);

        return $this->redirectToRoute('order');
    }

}

