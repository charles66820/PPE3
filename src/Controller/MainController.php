<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Command;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\Product;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function getHome()
    {
        return $this->render('main/home.html.twig', [
            'title' => 'Accueil',
        ]);
    }
    /**
     * @Route("/mentionslegales", name="legal")
     */
    public function getLegalNotice()
    {
        return $this->render('main/legal.html.twig', [
            'title' => 'Mentions legales',
        ]);
    }

    /**
     * @Route("/catalog", name="catalog")
     */
    public function getCatalog()
    {
        return $this->redirectToRoute('catalogC', ['cat'=>'all'], 302);
    }

    /**
     * @Route("/catalog/{cat}", name="catalogC")
     */
    public function getCatalogC($cat, Request $request)
    {
        $qry = $request->query;
        $cat = ($cat == 'all')? null : $cat;

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllBySQL($cat, $qry->get('q'), $qry->get('shortPrice'), $qry->get('stars'));

        return $this->render('main/catalog.html.twig', [
            'title' => 'Tous les produits',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function getProduct(Product $product = null, Request $request, ObjectManager $manager)
    {
        if($product == null){
            return $this->render('error/404.html.twig', [
                'title' => '404 le produit n\'existe pas!',
                'msgerr' => 'Le produit n\'existe pas!',
            ]);
        }

        $leClient = $this->getUser();
        $newComment = new Comment();
        $formV = null;
        if ($leClient !== null){
            $form = $this->createForm(CommentType::class, $newComment);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $newComment->setClient($leClient);
                $newComment->setProduct($product);
                $newComment->setDate(new \DateTime());
                $manager->persist($newComment);
                $manager->flush();

                return $this->redirectToRoute('product', ['id' => $product->getId()]);
            }
            $formV = $form->createView();
        }

        return $this->render('main/product.html.twig', [
            'title' => 'Produit | '.$product->getTitle(),
            'product' => $product,
            'form' => $formV,
        ]);
    }

    /**
     * @Route("/comment/{id}", name="removeComment")
     */
    public function deleteComment(Comment $comment, Request $request, ObjectManager $manager){
        //pour l'ajax
        if ($request->isXmlHttpRequest()) {
            if ($this->getUser() != $comment->getClient()) return new Response(json_encode(['error'=>'le commentaire n\'apartin pas au client']));
            $manager->remove($comment);
            $manager->flush();
            return new Response(json_encode(['comment' => $comment->getProduct()->getComments()]));
        }
        //pour les site non dinamic
        if ($this->getUser() == $comment->getClient()) {
            $manager->remove($comment);
            $manager->flush();
        }
        return $this->redirectToRoute('product', ['id' => $comment->getProduct()->getId()]);
    }

    /**
     * @Route("/testmail", name="test")
     */
    public function test(\Swift_Mailer $mailer) {
        $command = $this->getDoctrine()
            ->getRepository(Command::class)
            ->find(1);
        $message = (new \Swift_Message('Votre commande'))
            ->setFrom('poulpi@ppe.magicorp.fr')
            ->setTo('charles.goedefroit@gmail.com')
            ->setBody(
                $this->renderView(
                    'emails/order.html.twig',
                    [
                        'name' => 'charles',
                        'command' => $command,
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView(
                    'emails/base.txt.twig',
                    ['name' => 'charles']
                ),
                'text/plain'
            )
        ;
        $mailer->send($message);
        return new Response('mail send'. $this->renderView(
                'emails/order.html.twig',
                [
                    'name' => 'charles',
                    'command' => $command,
                ]
            ));
    }
}
