<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/addbook', name: 'addbook')] #we nekhdmo b name de route dans ce cas addauthor
     public function addbook(ManagerRegistry $manager, Request $req): Response
     {
         $em = $manager->getManager();
         $book = new Book();
         $form = $this->createForm(BookType::class,   $book);
         $form->handleRequest($req);
         if ($form->isSubmitted() and $form->isValid()) {
             $em->persist($book);
             $em->flush();
 
            
         }
 
         return $this->renderForm('book/addb.html.twig', [
             'book' => $form
         ]);
     }
     #SHOOW/////

     #[Route('/showBOOk', name: 'showBOOK')]
     public function showBOOK(BookRepository $bookRepo): Response
     {
 
         $book = $bookRepo->findAll();
         return $this->render('book/showb.html.twig', [
             'books' => $book
         ]);
     }

    # #[Route('/Testb', name: 'Testb')]
   #  public function Testb(BookRepository $bookRepository): Response
   #  {
         //var_dump($id) . die();
 
 #        $book= $bookRepository->listBookByClass(1);

   
 
  #       return $this->render('book/BookTest.html.twig', [
   #          'book' => $book
    #     ]);
# }

#[Route('/searchbook', name: 'searchbook')]
public function searchBooks(Request $request, BookRepository $bookRepository): Response
    {
        $bookId = $request->query->get('bookId');

        if ($bookId) {
            $books = $bookRepository->findBy(['id' => $bookId]);
        } else {
            
            $books = $bookRepository->findAll();
       }

        return $this->render('book/search.html.twig', [
            'books' => $books,
        ]);
    }
    #[Route('/triAuthor', name: 'triAuthor')]
    public function triauthor(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAllBooksOrderedByAuthor();

        return $this->render('book/triAuthor.html.twig', [
            'books' => $books,
        ]);
    }
    #[Route('/DQLcatg', name: 'DQLcatg')]
    public function countScienceFictionBooks(BookRepository $bookRepository): Response
    {

        $Books = $bookRepository->findAll();
        $count = $bookRepository->countScienceFictionBooks();
        $countPublishedBooks = $bookRepository->countPublishedBooks();

        return $this->render('book/catg.html.twig', [
            'count' => $count,
            'book' => $Books,
            'pub' => $countPublishedBooks,
        ]);
    }

}
