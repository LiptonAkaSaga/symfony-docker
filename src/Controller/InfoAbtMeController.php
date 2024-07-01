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
use Symfony\Component\Routing\Attribute\Route;

class InfoAbtMeController extends AbstractController
{
    public function __construct(private AboutMeInfoRepository $aboutMeInfoRepository, private AboutMeInfoProvider $aboutMeInfoProvider)
    {

    }
    #[Route('/me', name: 'app_info_abt_me')]
    public function listInfo(AboutMeInfoRepository $aboutMeInfoRepository, AboutMeInfoProvider $aboutMeInfoProvider): Response
    {
  $AboutMeInfo = $aboutMeInfoRepository->findAll();

  return $this->render('info_abt_me/index.html.twig', ['aboutMeInfo' => $AboutMeInfo]);
    }

    #[Route('/me/edit/{id}', name: 'editInfoAboutMe')]
public function editInfo(AboutMeInfo $aboutMeInfo, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AboutMeInfoFormType::class, $aboutMeInfo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($aboutMeInfo);
            $em->flush();

            $this->addFlash('success', 'Information updated successfully.');

            return $this->redirectToRoute('app_about_me');
        }

        return $this->render('info_abt_me/edit.html.twig', [
            'form' => $form->createView(),
            ]);
    }
}
