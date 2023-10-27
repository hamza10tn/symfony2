<?php

namespace App\Controller;




use App\Entity\Reader;
use App\Repository\ReaderRepository;
use App\Form\ReaderType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReaderController extends AbstractController
{
    #[Route('/reader', name: 'app_reader')]
    public function index(): Response
    {
        return $this->render('reader/index.html.twig', [
            'controller_name' => 'ReaderController',
        ]);
    }
    #[Route('/addReader', name: 'addReader')]
    public function addReader(Request $req, ManagerRegistry $mr): Response
    {
        $Reader = new Reader();
        $form = $this->createForm(ReaderType::class, $Reader);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            

            $entityManager->persist($Reader);
            
            
            $entityManager->flush();

            return $this->redirectToRoute('listre');   


        }  return $this->render('Reader/add.html.twig', ['form' => $form->createView()]);}
        #[Route('/editReader/{id}', name: 'editReader')]
    public function editReader(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Reader = $entityManager->getRepository(Reader::class)->find($id);
    
        if (!$Reader) {
            throw $this->createNotFoundException('Reader not found');
        }
    
        $form = $this->createForm(ReaderType::class, $Reader);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
    

            return $this->redirectToRoute('listre');
        }

        return $this->render('Reader/edit.html.twig', [
            'Reader' => $Reader,
            'form' => $form->createView(),
            
        ]);}
        #[Route("/Reader/{id}", name: "detailReader")]
        public function show($id)
           {
               $Reader = $this->getDoctrine()->getRepository(Reader::class)
                   ->find($id);
               return $this->render('Reader/detail.html.twig',
                   array('Reader' => $Reader));
           }
           #[Route('/listre', name: 'listre')]
           public function listre(ReaderRepository $repo){
       $Reader=$repo->findAll();
       return $this->render(
           'Reader/Reader.html.twig', [
               "Reader" => $Reader,
           ] 
       );
       
           }
           #[Route("/delete/{id}", name: "deleteau")]
           public function deleteReader(Request $request, int $id): Response
           {
               $em = $this->getDoctrine()->getManager();
               $Reader = $em->getRepository(Reader::class)->find($id);
           
               if (!$Reader) {
                   throw $this->createNotFoundException('Reader not found');
               }
           
               $em->remove($Reader);
               $em->flush();
           
                return $this->redirectToRoute('listre');
           }
       

}
