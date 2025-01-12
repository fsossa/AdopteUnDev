<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Repository\CompanyVisiteDeveloperRepository;
use App\Repository\DeveloperRepository;
use App\Repository\DeveloperVisitePosteRepository;
use App\Repository\PosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/developers', name: 'index_developer', methods: ['GET', 'POST'])]
    public function indexDev(HttpFoundationRequest $request, DeveloperRepository $developerRepository, CompanyVisiteDeveloperRepository $companyVisiteDeveloperRepository): Response
    {
        $developers = $developerRepository->findAll(); //findBy([])
        return $this->render('developer/index.html.twig', [
            'developers' => $developerRepository->findAll(),
            'serchText' => $request->get('serchText')->getData(),
            'searchLocation' => $request->get('searchLocation')->getData(),
            'searchExp' => $request->get('searchExp')->getData(),
            'searchSalary' => $request->get('searchSalary')->getData(),
            'favDevs' => $developers,
            'visitedDevs' => $developers,
        ]);
    }
    
    // #[Route('/developers/show/{id}', name: 'app_company_show_developer', methods: ['GET'])]
    // public function showDev(Developer $developer, CompanyVisiteDeveloperRepository $companyVisiteDeveloperRepository): Response
    // {
    //     $companyVisiteDeveloperRepository->recordVisit($this->getUser()->getCompany(), $developer);
    //     return $this->render('developer/show.html.twig', [
    //         'developer' => $developer,
    //     ]);
    // }

    
    #[Route('/postes', name: 'index_poste', methods: ['GET', 'POST'])]
    public function indexPoste(HttpFoundationRequest $request, PosteRepository $posteRepository, DeveloperVisitePosteRepository $developerVisitePosteRepository): Response
    {
        $postes = $posteRepository->findAll(); //findBy([])
        return $this->render('poste/index.html.twig', [
            'postes' => $posteRepository->findAll(),
            'serchText' => $request->get('serchText')->getData(),
            'searchLocation' => $request->get('searchLocation')->getData(),
            'searchExp' => $request->get('searchExp')->getData(),
            'searchSalary' => $request->get('searchSalary')->getData(),
            'favPostes' => $postes,
            'visitedPostes' => $postes,
        ]);
    }
    
    // #[Route('/postes/show/{id}', name: 'show_poste', methods: ['GET'])]
    // public function showPoste(Developer $developer, CompanyVisiteDeveloperRepository $companyVisiteDeveloperRepository): Response
    // {
    //     $companyVisiteDeveloperRepository->recordVisit($this->getUser()->getCompany(), $developer);
    //     return $this->render('developer/show.html.twig', [
    //         'developer' => $developer,
    //     ]);
    // }
}
