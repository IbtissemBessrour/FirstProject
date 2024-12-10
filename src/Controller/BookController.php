<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;





class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/read', name: 'read_book')]
    public function readBook (BookRepository $bR){
        $list=$bR->findAll();
        return $this-> render( 'book/read.html.twig',['book'=>$list]);
    }

    #[Route('/addBook',name:'add_Book')]
    public function addBook(Request $request,ManagerRegistry $Doctrine):Response
    {
        //creation de nouveau objet de type book
        $Book = new Book();
        // creation de form from booktype
        $form = $this->createForm(BookType::class,$Book);
        // traite les données recus de formulaire
        $form->handleRequest($request); 
        // issubmitted permet de verifier si le formulaire a était soumis , isvalid permet de faire le controle de saisis
        if($form->isSubmitted() && $form->isValid()){
            // perme de recuperer les données
            $Book = $form->getData();
            $nbBooks = $Book->getAuthor()->getNbBooks();
            $Book->getAuthor()->setNbBooks($nbBooks+1);
            // permet de faire le persiste (l'ajout)
            $Dt = $Doctrine->getManager();
            $Dt->persist($Book);
            // update dans la base
            $Dt->flush();
            return $this->redirectToRoute('read_book');
        }
        return $this->render('Book/addBook.html.twig',[
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/updateBook/{id}',name:'update_book')]
    public function updateBook(Request $request,ManagerRegistry $Doctrine, BookRepository $BookR,int $id):Response
    {
        //modifier objet de type book
        $Book = $BookR->find( $id);
        // modifier form from booktype
        $form = $this->createForm(BookType::class,$Book);
        // traite les données recus de formulaire
        $form->handleRequest($request); 
        // issubmitted permet de verifier si le formulaire a était soumis , isvalid permet de faire le controle de saisis
        if($form->isSubmitted() && $form->isValid()){
            // perme de recuperer les données
            $Book = $form->getData();
            
            // permet de faire le persiste (l'ajout)
            $Dt = $Doctrine->getManager();
            // $Dt->persist($Book);
            // update dans la base
            $Dt->flush();
            return $this->redirectToRoute('read_book');
        }
        return $this->render('Book/updateBook.html.twig',[
            'form' => $form->createView()
        ]);

    }
    #[Route('/deleteBook/{id}',name:'delete_Book')]
    public function deleteBook(ManagerRegistry $Doctrine, BookRepository $BookR, $id):Response
    {
        $Book = $BookR->find( $id);

            $Dt = $Doctrine->getManager();
            
            $Dt->remove($Book);
            $Dt->flush();
        
        return $this->redirectToRoute('read_Book');
    }

    #[Route('/triBook',name:'tri')]

    public function tri(BookRepository $BookR ) {

        $Book = $BookR->tri();
        return $this->render('book/tri.html.twig',['book'=>$Book]);

    }


    #[Route('/triQuery',name:'triQuery')]

    public function triQB(BookRepository $BookR ) {

        $Book = $BookR->tri();
        return $this->render('book/tri.html.twig',['book'=>$Book]);

    }


    #[Route('/search',name:'search')]

    public function searchBookById(BookRepository $BookR, Request $request ) {

        
        $id = $request->get('id');
        $Book = $BookR->searchBookByRef($id);
        return $this->render('book/tri.html.twig',['book'=>$Book]);

    }    
    
}
