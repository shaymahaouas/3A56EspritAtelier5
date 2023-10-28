<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use App\Entity\Author;
use App\Form\AuthorType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class AuthorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/Showauthor/{name}', name: 'app_Showauthor')]
    public function Showauthor($name): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('author/show.html.twig', [
            'nameHTML' => $name ,
            'authorshtml' => $authors ,
        ]);
    }
  #SHOW////////
    #[Route('/showDBauthor', name: 'showDBauthor')]
    public function showDBauthor(AuthorRepository $authorRepo): Response
    {

        $x = $authorRepo->findAll();
        return $this->render('author/showDBauthor.html.twig', [
            'authors' => $x
        ]);
    }

     #AADD WITH FORM////////

     #[Route('/addauthor', name: 'addauthor')] #we nekhdmo b name de route dans ce cas addauthor
     public function addauthor(ManagerRegistry $manager, Request $req): Response
     {
         $em = $manager->getManager();
         $author = new Author();
         $form = $this->createForm(AuthorType::class,   $author);
         $form->handleRequest($req);
         if ($form->isSubmitted() and $form->isValid()) {
             $em->persist($author);
             $em->flush();
 
             return $this->redirectToRoute('showDBauthor');
         }
 
         return $this->renderForm('author/add.html.twig', [
             'f' => $form
         ]);
     }
     #EDITTWITH FORM////////
     #[Route('/editauthor/{id}', name: 'editauthor')]
     public function editauthor($id, ManagerRegistry $manager, AuthorRepository $authorrepo, Request $req): Response
     {
         // var_dump($id) . die();
 
         $em = $manager->getManager();
         $idData = $authorrepo->find($id);
         // var_dump($idData) . die();
         $form = $this->createForm(AuthorType::class, $idData);
         $form->handleRequest($req);
 
         if ($form->isSubmitted() and $form->isValid()) {
             $em->persist($idData);
             $em->flush();
 
             return $this->redirectToRoute('showDBauthor');
         }
 
         return $this->renderForm('author/edit.html.twig', [
             'form' => $form
         ]);
     }
  #DELETTTETWITH FORM////////

     #[Route('/deleteauthor/{id}', name: 'deleteauthor')]
     public function deleteauthor($id, ManagerRegistry $manager, AuthorRepository $repo): Response
     {
         $emm = $manager->getManager();
         $idremove = $repo->find($id);
         $emm->remove($idremove);
         $emm->flush();
 
 
         return $this->redirectToRoute('showDBauthor');
     }
 

     #[Route('/showauthor', name: 'app_showauthor')]
     public function showaut(): Response
     {
 
         return $this->render('author/show.html.twig', [
             'auth' => $this->authors,
         ]);
     }
 
     #[Route('/authorDetails/{id}', name: 'authorDetails')]
     public function authorDetails($id): Response
     {
         //var_dump($id) . die();
 
         $author = null;
         foreach ($this->authors as $authorData) {
             if ($authorData['id'] == $id) {
                 $author = $authorData;
             }
         }
 
         return $this->render('author/details.html.twig', [
             'author' => $author
        ]);
    }
        #[Route('/affiche', name: 'affiche')]
        public function affiche(AuthorRepository $authorRepository): Response
        {
            //var_dump($id) . die();
    
            $author = $authorRepository->showAllAuthorByFirstname();

      
    
            return $this->render('author/affiche.html.twig', [
                'author' => $author
            ]);
    }

    //EMAIL SHOW


    #[Route('/emailAff', name: 'emailaff')]
     
    public function emailAff (AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAllAuthorsOrderedByEmail();

        return $this->render('author/emailaff.html.twig', [
            'authors' => $authors,
        ]);
    }

}
