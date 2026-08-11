<?php

namespace App\Controller;

use App\Entity\Spot;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ImportController extends AbstractController
{
    #[Route('/admin/import-tidal', name: 'admin_import_tidal')]
    public function importTidal(EntityManagerInterface $em): Response
    {
        $excelFile = __DIR__ . '/../../data Wind.xlsx';

        if (!file_exists($excelFile)) {
            return new Response("File not found: $excelFile", Response::HTTP_NOT_FOUND);
        }

        try {
            $spreadsheet = IOFactory::load($excelFile);
            $sheet = $spreadsheet->getActiveSheet();

            $updated = 0;
            $notFound = 0;
            $errors = [];

            for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
                $nomSpot = $sheet->getCell('A' . $row)->getValue();
                if (!$nomSpot) break;

                $topValue = $sheet->getCell('AF' . $row)->getValue();
                $okValue = $sheet->getCell('AG' . $row)->getValue();
                $warnValue = $sheet->getCell('AH' . $row)->getValue();
                $koValue = $sheet->getCell('AI' . $row)->getValue();

                // Find spot by NOM instead of CodeSpot
                $spot = $em->getRepository(Spot::class)->findOneBy(['nom' => (string)$nomSpot]);

                if (!$spot) {
                    $notFound++;
                    continue;
                }

                $spot->setTop($topValue ? (string)$topValue : null);
                $spot->setOk($okValue ? (string)$okValue : null);
                $spot->setWarn($warnValue ? (string)$warnValue : null);
                $spot->setKo($koValue ? (string)$koValue : null);

                $em->persist($spot);
                $updated++;

                if ($updated % 10 == 0) {
                    $em->flush();
                }
            }

            $em->flush();

            return new Response("
                <h1>✅ Tidal Constraints Imported</h1>
                <p>✓ Updated: $updated spots</p>
                <p>✗ Not found: $notFound spots</p>
                <p><a href='/'>Back to home</a></p>
            ");

        } catch (\Exception $e) {
            return new Response("Error: " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/admin/check-wimereux', name: 'admin_check_wimereux')]
    public function checkWimereux(EntityManagerInterface $em): Response
    {
        $spot = $em->getRepository(Spot::class)->findOneBy(['nom' => 'Wimereux']);

        if (!$spot) {
            return new Response("Spot not found");
        }

        return new Response("
            <h1>Spot: " . $spot->getNom() . "</h1>
            <h2>Tidal Constraints</h2>
            <ul>
                <li>top: " . ($spot->getTop() ?: "(empty)") . "</li>
                <li>ok: " . ($spot->getOk() ?: "(empty)") . "</li>
                <li>warn: " . ($spot->getWarn() ?: "(empty)") . "</li>
                <li>ko: " . ($spot->getKo() ?: "(empty)") . "</li>
            </ul>
            <p><a href='/'>Back to home</a></p>
        ");
    }
}
