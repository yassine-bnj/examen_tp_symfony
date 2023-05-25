<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Product;
use App\Entity\PropertySearch;
use App\Entity\rechercheProduit;
use App\Form\ArticleType;
use App\Form\PropertySearchType;
use App\Form\RechercheProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{



 #[Route('/index', name: 'index')]   
 public function home()
 {

 return $this->render('welcome.html.twig');
 }

 

            #[Route('/products', name: 'allArticles')]
            public function articles(Request $request,EntityManagerInterface $entityManager)
            {
                $propertySearch = new PropertySearch();
                $form = $this->createForm(PropertySearchType::class,$propertySearch);
                $form->handleRequest($request);
                //initialement le tableau des articles est vide,
                //c.a.d on affiche les articles que lorsque l'utilisateur
                //clique sur le bouton rechercher
                $articles= [];
                if($form->isSubmitted() && $form->isValid()) {
                //on récupère le nom d'article tapé dans le formulaire
                $nom = $propertySearch->getNom();
    if ($nom!="")
    //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
    $articles= $entityManager->getRepository(Product::class)->findBy(['nom' => $nom] );
    else
    //si si aucun nom n'est fourni on affiche tous les articles
    $articles= $entityManager->getRepository(Product::class)->findAll();
    }
    return $this->render('index.html.twig',[  'articles' => $articles,'form' =>$form->createView()]);
    }
    #[Route('/product/{id}', name: 'article')]
    public function article($id,EntityManagerInterface $entityManager)
    {
    $article= $entityManager->getRepository(Product::class)->find($id);
    return $this->render('show.html.twig',[  'article' => $article]);
    }



}