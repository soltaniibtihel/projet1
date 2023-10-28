<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SalleFormType;
use App\Entity\Salle;
use App\Repository\SalleRepository;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle')]
    public function index(): Response
    {
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'SalleController',
            'path' => 'src/Controller/SalleController.php',
        ]);
    }
    #[Route('/Salle', name: 'showBDsal')]
    public function showBDsal(SalleRepository $SalleRepo): Response
    {

        $x = $SalleRepo->findAll();
        return $this->render('Salle/showBDsal.html.twig', 
        ['Salle' => $x,'mykey' => 'hamza']
    );
    }
    #[Route('/Salle/form', name: 'Salle_add')]
    public function AddSalle(ManagerRegistry $doctrine, Request $request): Response
    {
        $Salle =new Salle();
        $form=$this->createForm(SalleFormType::class,$Salle);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($Salle);
            $em->flush();
            return $this-> redirectToRoute('showBDsal');
        }
        return $this->render('Salle/form.html.twig',[
            'formA'=>$form->createView(),
        ]);
    }
}
