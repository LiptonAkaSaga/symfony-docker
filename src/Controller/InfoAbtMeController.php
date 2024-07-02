<?php

namespace App\Controller;

use App\Entity\AboutMeInfo;
use App\Form\AboutMeInfoFormType;
use App\Repository\AboutMeInfoRepository;
use App\Services\AboutMeInfoProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/about-me')]
class InfoAbtMeController extends AbstractController
{
    private $aboutMeInfoRepository;
    private $aboutMeInfoProvider;

    public function __construct(AboutMeInfoRepository $aboutMeInfoRepository, AboutMeInfoProvider $aboutMeInfoProvider)
    {
        $this->aboutMeInfoRepository = $aboutMeInfoRepository;
        $this->aboutMeInfoProvider = $aboutMeInfoProvider;
    }

    #[Route('', name: 'app_about_me')]
    public function index(): Response
    {
        $aboutMeInfos = $this->aboutMeInfoRepository->findAllSorted();
        $transformedData = $this->aboutMeInfoProvider->transformDataForTwig($aboutMeInfos);

        return $this->render('info_abt_me/index.html.twig', [
            'aboutMeInfo' => $transformedData,
            'totalEntries' => $this->aboutMeInfoRepository->countEntries(),
        ]);
    }

    #[Route('/new', name: 'app_about_me_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aboutMeInfo = new AboutMeInfo();
        $form = $this->createForm(AboutMeInfoFormType::class, $aboutMeInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aboutMeInfo);
            $entityManager->flush();

            $this->addFlash('success', 'Nowa informacja została dodana.');

            return $this->redirectToRoute('app_about_me');
        }

        return $this->render('info_abt_me/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_about_me_edit')]
    public function edit(Request $request, AboutMeInfo $aboutMeInfo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AboutMeInfoFormType::class, $aboutMeInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Informacja została zaktualizowana.');

            return $this->redirectToRoute('app_about_me');
        }

        return $this->render('info_abt_me/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_about_me_delete')]
    public function delete(Request $request, AboutMeInfo $aboutMeInfo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aboutMeInfo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($aboutMeInfo);
            $entityManager->flush();

            $this->addFlash('success', 'Informacja została usunięta.');
        }

        return $this->redirectToRoute('app_about_me');
    }

    #[Route('/delete-multiple', name: 'app_about_me_delete_multiple', methods: ['POST'])]
    public function deleteMultiple(Request $request, AboutMeInfoRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $ids = $request->request->all()['delete_ids'] ?? [];
        if (!empty($ids)) {
            $repository->deleteMultiple($ids);
            $this->addFlash('success', 'Wybrane informacje zostały usunięte.');
        } else {
            $this->addFlash('warning', 'Nie wybrano żadnych informacji do usunięcia.');
        }

        return $this->redirectToRoute('app_about_me');
    }
}
