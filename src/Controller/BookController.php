<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class BookController extends AbstractController
{
    
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/addbook', name: 'addbook')]
    public function addbook(Request $req, ManagerRegistry $mr): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);     
        $form->handleRequest($req);
        if ($form->isSubmitted() ) {
  
            //$cat = $book->getCategory();
        
                //new \Datetime('now')
                //date_create('now')
              //  $age=$book->getAuthors()->getAge();

                $book->setPublicationDate(new \DateTime('now'));
                $em = $mr->getManager();
                $em->persist($book);
                $em->flush();
               
                return $this->redirectToRoute('fetchbook');
            } return $this->renderForm(
                'book/newbook.html.twig', [
                    "f" => $form
                ] 
            );}
        
      /*  return $this->render('book/newbook.html.twig', [
            "f" => $form->createView()
        ]);*/
        
    

    #[Route('/book/{id}', name: 'editbook')]
    public function update(Request $req, ManagerRegistry $mr,$id,BookRepository $repo): Response
    {
        $book = $repo->find($id);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($req);
        if ($form->isSubmitted() ) {
            //$cat = $book->getCategory();
          
            {
                //new \Datetime('now')
                //date_create('now')
            
                //if($age>60){
                $book->setPublicationDate(new \DateTime('now'));
                $em = $mr->getManager();
               $em->persist($book);
                $em->flush();
        }

        return $this->redirectToRoute('fetchbook');
     }
      /*  return $this->render('book/newbook.html.twig', [
            "f" => $form->createView()
        ]);*/
        return $this->renderForm(
            'book/newbook.html.twig', [
                "f" => $form
            ] );
       
    }
    


    #[Route('/fetchbook', name: 'fetchbook')]
    public function fetchBook(BookRepository $repo){
$books=$repo->findAll();
return $this->render(
    'book/books.html.twig', [
        "books" => $books
    ] 
);
    }

    #[Route("/bookDetail/{id}", name: "detailbook")]
 public function show($id)
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        return $this->render('book/detailbook.html.twig',
            array('book' => $book));
    }


    #[Route("/bookd/{id}", name: "deletebook")]
    public function deletebook(Request $request, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);
    
        if (!$book) {
            throw $this->createNotFoundException('book not found');
        }
    
        $em->remove($book);
        $em->flush();
    
         return $this->redirectToRoute('fetchbook');
    }
}
