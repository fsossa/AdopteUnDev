<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Developer;
use App\Form\CompanyType;
use App\Repository\CompanyFavDeveloperRepository;
use App\Repository\CompanyRepository;
use App\Repository\CompanyVisiteDeveloperRepository;
use App\Repository\DeveloperRepository;
use App\Repository\PosteRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app/company')]
final class CompanyController extends AbstractController
{
    #[Route(name: 'app_company_home', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository, PosteRepository $posteRepository, CompanyVisiteDeveloperRepository $companyVisiteDeveloperRepository): Response
    {
        // dd($companyVisiteDeveloperRepository->findAll());
        return $this->render('company/home.html.twig', [
            // 'companies' => $companyRepository->findAll(),
            'lastPostes' => $posteRepository->findBy(['company' => $this->getUser()->getCompany()], ['id' =>'DESC'], 5),
            'bestDevs' => $companyVisiteDeveloperRepository->findTopMostVisitedDevelopers(3),
            'lastDevs' => $companyVisiteDeveloperRepository->findLastDevelopers(3),
        ]);
    }

    #[Route('/new', name: 'app_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_company_show', methods: ['GET'])]
    // public function show(Company $company): Response
    // {
    //     // dd($company);
    //     return $this->render('company/show.html.twig', [
    //         'company' => $company,
    //     ]);
    // }

    #[Route('/profile/', name: 'app_company_profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = $this->getUser()->getCompany();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_company_profile', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('company/profile.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Company $company, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_delete', methods: ['POST'])]
    public function delete(Request $request, Company $company, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/developers', name: 'app_company_index_developer', methods: ['GET'])]
    public function indexDev(Request $request, DeveloperRepository $developerRepository, SkillRepository $skillRepository): Response
    {
        $developers = $developerRepository->findAll(); //findBy([])
        return $this->render('developer/index.html.twig', [
            'developers' => $developerRepository->findAll(),
            'searchReq' => $request,
            'favDevs' => $developers,
            'visitedDevs' => $developers,
            'skills' => $skillRepository->findAll(),
        ]);
    }
    
    #[Route('/developers/show/{id}', name: 'app_company_show_developer', methods: ['GET'])]
    public function showDev(Developer $developer, CompanyVisiteDeveloperRepository $companyVisiteDeveloperRepository): Response
    {
        $companyVisiteDeveloperRepository->recordVisit($this->getUser()->getCompany(), $developer);
        return $this->render('developer/show.html.twig', [
            'developer' => $developer,
        ]);
    }

    
    #[Route('/postes', name: 'app_company_show_poste', methods: ['GET', 'POST'])]
    public function indexPoste(Request $request, PosteRepository $posteRepository, SkillRepository $skillRepository): Response
    {
        $postes = $posteRepository->findAll(); //findBy([])
        return $this->render('poste/index.html.twig', [
            'postes' => $posteRepository->findAll(),
            'searchReq' => $request,
            'favPostes' => $postes,
            'visitedPostes' => $postes,
            'skills' => $skillRepository->findAll(),
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
