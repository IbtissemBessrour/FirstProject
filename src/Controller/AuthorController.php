<?php

namespace App\Controller;

use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Author;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/list.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    /*#[Route('/listAuthor', name: 'listAuthor')]
    public function listAuthor(): Response
    {
        $Authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
        );
        return $this->render('author/list.html.twig',["Authors" => $Authors]);
    }
    */
////////////////////////  a verifier ///////////////////////////////////////////////////////////////////////
    /*#[Route('/detail/{id}', name: 'detail')]
    public function detail($id): Response
    {   $Authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300)
        );
    return $this->render('author/show.html.twig',["Authors" => $Authors,'id'=>$id]);
    }
    
    #[Route('/create',name:'create_author')]
    public function create(ManagerRegistry $Doctrine){
        $Author = new Author();
        $Author-> setUsername('nabil');
        $Author->setEmail('abc@gmail.com');
        $em=$Doctrine->getManager();
        $em->remove($Author);
        $em->flush();
        return $this->redirectToRoute('listauth');
    }*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

    #[Route('/addAuthor',name:'add_Author')]
    public function addAuthor(Request $request,ManagerRegistry $Doctrine):Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            $author = $form->getData();
            $Dt = $Doctrine->getManager();
            
            $Dt->persist($author);
            $Dt->flush();
        }
        return $this->render('author/addAuthor.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/readAuthor',name:'readAuthor')]

    public function readAuthor (AuthorRepository $aR){
        $list=$aR->findAll();
        return $this-> render( 'author/read.html.twig',['author'=>$list]);
    }

    #[Route('/updateAuthor/{id}',name:'update_Author')]
    public function updateAuthor(Author $author , Request $request,ManagerRegistry $Doctrine):Response
    {
        //$author = $Doctrine->getRepository(Author::class)->findOneBy(['id'=> $id]);
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()){
            $author = $form->getData();
            $Dt = $Doctrine->getManager();
            
            $Dt->persist($author);
            $Dt->flush();
        return $this->redirectToRoute('readAuthor');
        }
        return $this->render('author/updateAuthor.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/deleteAuthor/{id}',name:'delete_Author')]
    public function deleteAuthor(Author $author ,ManagerRegistry $Doctrine):Response
    {
            $Dt = $Doctrine->getManager();
            
            $Dt->remove($author);
            $Dt->flush();
        
        return $this->redirectToRoute('readAuthor');
    }
    
    
}
