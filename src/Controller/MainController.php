<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Command;
use App\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\Product;
use function Symfony\Component\VarDumper\Dumper\esc;

/**
 * @Route("/", host="%domain%")
 */
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

        $data = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllBySQL($cat, $qry->get('q'), $qry->get('shortPrice'), $qry->get('stars'), $qry->get('p'));

        return $this->render('main/catalog.html.twig', [
            'title' => 'Tous les produits',
            'products' => $data['products'],
            'nbProduct' => $data['nbProduct'],
        ]);
    }

    /**
     * @Route("/product/{id}/picture", name="productPicture")
     */
    public function addProductPicture(Product $product = null, Request $request){
        if ($product == null){
            return new Response("none");
        }

        if ($request->query->get("token") !== getenv("ACCESSTOKEN")) {
            return new Response("none");
        }

        $file = $request->files->get('file');
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        try {
            $file->move(
                $this->getParameter('products_directory'),
                $filename
            );
            return new Response($filename);
        } catch (\Exception $e) {
            return new Response("none");
        }
    }

    /**
     * @Route("/product/picture", name="delProductPicture")
     */
    public function deleteProductImage(Request $request){

        if ($request->query->get("token") !== getenv("ACCESSTOKEN")) {
            return new Response("none");
        }

        if (!empty($request->query->get("name"))) {
            @unlink($this->getParameter('products_directory').$request->query->get("name"));
        }

        return new Response("good");
    }

    /**
     * @Route("/client/picture", name="delClientPicture")
     */
    public function deleteClientImage(Request $request){

        if ($request->query->get("token") !== getenv("ACCESSTOKEN")) {
            return new Response("none");
        }

        if (!empty($request->query->get("name"))) {
            @unlink($this->getParameter('clients_directory').$request->query->get("name"));
        }

        return new Response("good");
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
     * @Route("/confirm/{id}/{token}", name="confirm")
     */
    public function confirm(Client $client = null, $token, ObjectManager $manager){
        if($client == null){
            return $this->render('error/404.html.twig', [
                'title' => '404 le client n\'existe pas!',
                'msgerr' => 'Le client n\'existe pas!',
            ]);
        }

        if($token == null || $token == ''){
            return $this->render('error/400.html.twig', [
                'title' => '400 token manquant!',
                'msgerr' => 'Le token n\'a pas été renseigné!',
            ]);
        }

        if ($client->getToken() == $token) {
            $client->setConfirmed(true);
            $manager->persist($client);
            $manager->flush();

            return $this->render('security/confirm.html.twig', [
                'title' => 'Votre compte est validé!',
            ]);
        } else {
            return $this->render('error/400.html.twig', [
                'title' => '400 token non valide!',
                'msgerr' => 'Le token n\'est pas été valide!',
            ]);
        }
    }
}
