<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Form\SpotType;
use App\Repository\SpotRepository;
use App\Enum\WindQuality;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SpotController extends AbstractController
{
    #[Route('/', name: 'spot_index')]
    public function index(SpotRepository $repo): Response
    {
        return $this->render('spot/index.html.twig', [
            'spots' => $repo->findAllOrderedByRegionAndNom(),
        ]);
    }

    #[Route('/carte', name: 'spot_map')]
    public function map(SpotRepository $repo): Response
    {
        return $this->render('spot/map.html.twig', [
            'spots' => $repo->findAllOrderedByRegionAndNom(),
        ]);
    }

    #[Route('/spots/new', name: 'spot_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $spot = new Spot();
        $form = $this->createForm(SpotType::class, $spot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach (Spot::DIRECTIONS as $dir) {
                $val = $form->get("wind_$dir")->getData();
                if ($val !== null && $val !== '') {
                    $spot->setOrientationQuality($dir, WindQuality::from((int)$val));
                }
            }
            $em->persist($spot);
            $em->flush();
            return $this->redirectToRoute('spot_show', ['codeSpot' => $spot->getCodeSpot()]);
        }

        return $this->render('spot/form.html.twig', ['form' => $form, 'spot' => $spot]);
    }

    #[Route('/spots/{codeSpot}', name: 'spot_show')]
    public function show(string $codeSpot, SpotRepository $repo): Response
    {
        $spot = $repo->findOneByCodeSpot($codeSpot);
        if (!$spot) {
            throw $this->createNotFoundException();
        }
        return $this->render('spot/show.html.twig', ['spot' => $spot]);
    }

    #[Route('/spots/{codeSpot}/edit', name: 'spot_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(string $codeSpot, Request $request, EntityManagerInterface $em, SpotRepository $repo): Response
    {
        $spot = $repo->findOneByCodeSpot($codeSpot);
        if (!$spot) {
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(SpotType::class, $spot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach (Spot::DIRECTIONS as $dir) {
                $val = $form->get("wind_$dir")->getData();
                if ($val !== null && $val !== '') {
                    $spot->setOrientationQuality($dir, WindQuality::from((int)$val));
                } else {
                    $spot->setOrientationQuality($dir, null);
                }
            }
            $em->flush();
            return $this->redirectToRoute('spot_show', ['codeSpot' => $spot->getCodeSpot()]);
        }

        return $this->render('spot/form.html.twig', ['form' => $form, 'spot' => $spot]);
    }

    #[Route('/spots/{codeSpot}/delete', name: 'spot_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(string $codeSpot, EntityManagerInterface $em, Request $request, SpotRepository $repo): Response
    {
        $spot = $repo->findOneByCodeSpot($codeSpot);
        if (!$spot) {
            throw $this->createNotFoundException();
        }
        $this->validateCsrfToken('delete_' . $spot->getId(), $request->request->get('_token'));
        $em->remove($spot);
        $em->flush();
        return $this->redirectToRoute('spot_index');
    }
}
