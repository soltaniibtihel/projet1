<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DepartementFormType;
use App\Entity\Departement;
use App\Repository\DepartementRepository;
use App\Form\IbtihelFormType;
use App\Form\SoltaniFormType;

class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'app_departement')]
    public function index(): Response
    {
        return $this->render('departement/index.html.twig', [
            'controller_name' => 'DepartementController',
            'path' => 'src/Controller/DepartementController.php',
        ]);
    }
    #[Route('/Departement', name: 'showBDdep')]
    public function showBDdep(DepartementRepository $DepartementRepo): Response
    {
        $x = $DepartementRepo->findAll();
        return $this->render('Departement/showBDdep.html.twig', 
        ['Departement' => $x]
    );
    }
    #[Route('/Departement/search', name: 'searchBDdep')]
    public function searchBDdep(DepartementRepository $DepartementRepo,Request $request): Response
    {
        $departements = $DepartementRepo->findAll();
        $searchForm = $this-> createForm(IbtihelFormType::class);
        $searchForm->handleRequest($request);

        $minmaxForm = $this-> createForm(SoltaniFormType::class);
        $minmaxForm->handleRequest($request);
        
        if($searchForm->isSubmitted())
        {
          $datainput=$searchForm->get('name')->getData();
          $departements=$DepartementRepo->Searchbyname($datainput) ;

           return $this->renderForm('Departement/search.html.twig', [
          'departements' => $departements,
          'f' => $searchForm,
          'f2' => $minmaxForm
               ]);
       }

       if($minmaxForm->isSubmitted())
        {
            $min=$minmaxForm->get('min')->getData();
            $max=$minmaxForm->get('max')->getData();
          $departements=$DepartementRepo->minmax($min,$max) ;

           return $this->renderForm('Departement/search.html.twig', [
          'departements' => $departements,
          'f' => $searchForm,
          'f2' => $minmaxForm
               ]);
       }

   return $this->renderForm('Departement/search.html.twig', [
       'departements' => $departements,
       'f' => $searchForm,
       'f2' => $minmaxForm
   ]);
}
    #[Route('/Departement/form', name: 'Departement_add')]
    public function AddDepartement(ManagerRegistry $doctrine, Request $request): Response
    {
        $Departement =new Departement();
        $form=$this->createForm(DepartementFormType::class,$Departement);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($Departement);
            $em->flush();
            return $this-> redirectToRoute('showBDdep');
        }
        return $this->render('Departement/form.html.twig',[
            'formA'=>$form->createView(),
        ]);
    }
    #[Route('/deleteDepartement/{id}', name: 'deleteDepartement')]
    public function deleteDepartement($id, ManagerRegistry $manager, DepartementRepository $repo): Response
    {
        $emm = $manager->getManager();
        $idremove = $repo->find($id);
        $emm->remove($idremove);
        $emm->flush();


        return $this->redirectToRoute('showBDdep');
    }
}
