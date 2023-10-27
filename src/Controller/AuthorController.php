<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Form\AuthorType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/addauthor', name: 'addauthor')]
    public function addauthor(Request $req, ManagerRegistry $mr): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            

            $entityManager->persist($author);
            
            
            $entityManager->flush();

            return $this->redirectToRoute('listau');   


        }  return $this->render('author/add.html.twig', ['form' => $form->createView()]);}


     #[Route('/editauthor/{id}', name: 'editauthor')]
    public function editauthor(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $author = $entityManager->getRepository(Author::class)->find($id);
    
        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }
    
        $form = $this->createForm(AuthorType::class, $author);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
    

            return $this->redirectToRoute('listau');
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
            
        ]);}
       


        #[Route("/author/{id}", name: "detailAuthor")]
        public function show($id)
           {
               $author = $this->getDoctrine()->getRepository(Author::class)
                   ->find($id);
               return $this->render('author/detail.html.twig',
                   array('author' => $author));
           }

        #[Route('/listau', name: 'listau')]
    public function fetchBook(AuthorRepository $repo){
$authors=$repo->findAll();
return $this->render(
    'author/authors.html.twig', [
        "auth" => $authors,
    ] 
);
    }
    #[Route("/authors/{id}", name: "deleteau")]
public function deleteAuthor(Request $request, int $id): Response
{
    $em = $this->getDoctrine()->getManager();
    $author = $em->getRepository(Author::class)->find($id);

    if (!$author) {
        throw $this->createNotFoundException('Author not found');
    }

    $em->remove($author);
    $em->flush();

     return $this->redirectToRoute('listau');
}
      /*   #[Route('/listau', name: 'listau')]
        public function fetchBook(AuthorRepository $repo){
    $authors=$repo->findAll();
    return $this->render(
        'author/authors.html.twig', [
            "auth" => $authors,
        ] 
    ); */
        




}
