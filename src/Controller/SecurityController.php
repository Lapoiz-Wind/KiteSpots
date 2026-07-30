<?php

namespace App\Controller;

use App\Service\SpotExporter;
use App\Service\SpotImporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): never
    {
        throw new \LogicException('This method can be blank.');
    }

    #[Route('/spots/import', name: 'spots_import', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function import(Request $request, SpotImporter $importer): Response
    {
        if ($request->isMethod('POST')) {
            $file = $request->files->get('file');
            if ($file instanceof UploadedFile) {
                $tmpPath = sys_get_temp_dir() . '/' . uniqid() . '.xlsx';
                $file->move(sys_get_temp_dir(), basename($tmpPath));
                $count = $importer->import($tmpPath);
                @unlink($tmpPath);
                $this->addFlash('success', "Imported $count spots");
                return $this->redirectToRoute('spot_index');
            }
        }

        return $this->render('spot/import.html.twig');
    }

    #[Route('/spots/export', name: 'spots_export')]
    #[IsGranted('ROLE_ADMIN')]
    public function export(SpotExporter $exporter): Response
    {
        $filePath = $exporter->export();
        return $this->file($filePath, 'data Wind.xlsx', 'inline');
    }
}
