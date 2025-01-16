<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\Poste;
use App\Form\DeveloperType;
use App\Repository\CompanyVisiteDeveloperRepository;
use App\Repository\DeveloperRepository;
use App\Repository\DeveloperVisitePosteRepository;
use App\Repository\PosteRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app/developer')]
final class DeveloperController extends AbstractController
{
    #[Route(name: 'app_developer_home', methods: ['GET'])]
    public function index(DeveloperVisitePosteRepository $developerVisitePosteRepository, PosteRepository $posteRepository, CompanyVisiteDeveloperRepository $companyVisiteDeveloperRepository): Response
    {
        // dd($companyVisiteDeveloperRepository->findVisitsForDeveloper($this->getUser()->getDeveloper(), 5));
        return $this->render('developer/home.html.twig', [
            // 'developers' => $developerRepository->findAll(),
            'lastVisites' => $companyVisiteDeveloperRepository->findVisitsForDeveloper($this->getUser()->getDeveloper(), 5),
            'bestPostes' => $developerVisitePosteRepository->findTopMostVisitedPostes(3),
            'latestPostes' => $developerVisitePosteRepository->findLastPostes(3),
            // 'latestPostes' => $posteRepository->findLatest(3),
        ]);
    }

    #[Route('/new', name: 'app_developer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $developer = new Developer();
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($developer);
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developer/new.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }


    #[Route('/profile', name: 'app_developer_profile', methods: ['GET', 'POST'])]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $developer = $this->getUser()->getDeveloper();
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form->get('avatar')->getData();
            if ($avatarFile) {
                $filename = uniqid() . '.' . $avatarFile->guessExtension();

                $avatarFile->move(
                    $this->getParameter('avatars_directory'),
                    $filename
                );
                // Enregistrer le nom du fichier dans l'entité
                $developer->setAvatar($filename);
            }
                
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developer/manage/show.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }
    
    #[Route('/show/{id}', name: 'app_developer_show', methods: ['GET'])]
    public function show(Developer $developer, CompanyVisiteDeveloperRepository $companyVisiteDeveloperRepository): Response
    {
        $companyVisiteDeveloperRepository->recordVisit($this->getUser()->getCompany(), $developer);
        return $this->render('developer/show.html.twig', [
            'developer' => $developer,
        ]);
    }

    // #[Route('/profile', name: 'app_developer_profile', methods: ['GET'])]
    // public function profile(Request $request, EntityManagerInterface $entityManager, DeveloperRepository $developerRepository): Response
    // {
    //     // dd($request);
    //     $developer = $this->getUser()->getDeveloper();
    //     $form = $this->createForm(DeveloperType::class, $developer);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_developer_profile', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('developer/profile.html.twig', [
    //         'developer' => $developer,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_developer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_developer_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('developer/profile.html.twig', [
            'developer' => $developer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_developer_delete', methods: ['POST'])]
    public function delete(Request $request, Developer $developer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $developer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($developer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_developer_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/postes', name: 'app_developer_index_poste', methods: ['GET', 'POST'])]
    public function indexPoste(Request $request, PosteRepository $posteRepository, DeveloperVisitePosteRepository $developerVisitePosteRepository, SkillRepository $skillRepository): Response
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
    
    #[Route('/postes/show/{id}', name: 'app_developer_show_poste', methods: ['GET'])]
    public function showPoste(Poste $poste, DeveloperVisitePosteRepository $developerVisitePosteRepository): Response
    {
        $developerVisitePosteRepository->addPostVisit($this->getUser()->getCompany(), $poste);
        return $this->render('poste/show.html.twig', [
            'poste' => $poste,
        ]);
    }

    #[Route('/developers', name: 'app_developer_index_developer', methods: ['GET', 'POST'])]
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
}