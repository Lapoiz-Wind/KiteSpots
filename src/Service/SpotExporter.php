<?php

namespace App\Service;

use App\Entity\Spot;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class SpotExporter
{
    public function __construct(private EntityManagerInterface $em) {}

    public function export(): string
    {
        $spots = $this->em->getRepository(Spot::class)->findAllOrderedByRegionAndNom();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Spots from LaPoiz');

        $headers = [
            'Nom', 'CodeSpot', 'Region', 'CodeRegion', 'Note', 'ShortDescription', 'Description',
            'Localisation', 'DistFromParis', 'DistFromParisAutoroute', 'TimeFromParis', 'PéageFromParis',
            'MareeDesc', 'OrientationDesc', 'IsFoil', 'FoilDesc', 'WaveDesc', 'IsContraintEte',
            'ContraintEteDesc', 'Long', 'Lat', 'Windfinder', 'Windguru', 'Meteo France', 'MeteoConsult',
            'AlloSurf', 'Merteo', 'Temp eau', 'Webcam', 'Balise', 'Maree',
            'top', 'OK', 'warn', 'KO', 'n', 'nne', 'ne', 'ene', 'e', 'ese', 'se', 'sse',
            's', 'ssw', 'sw', 'wsw', 'w', 'wnw', 'nw', 'nnw',
            'URL1', 'Titre1', 'Commentaire1', 'URL2', 'Titre2', 'Commentaire2',
            'URL3', 'Titre3', 'Commentaire3', 'URL4', 'Titre4', 'Commentaire4',
        ];

        for ($i = 0; $i < count($headers); $i++) {
            $col = Coordinate::stringFromColumnIndex($i + 1);
            $sheet->setCellValue($col . '1', $headers[$i]);
        }

        $row = 2;
        foreach ($spots as $spot) {
            $col = 1;
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getNom());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getCodeSpot());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getRegion());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getCodeRegion());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getNote());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getShortDescription());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getDescription());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getLocalisation());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getDistFromParis());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getDistFromParisAutoroute());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getTimeFromParis());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getPeageFromParis());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getMareeDesc());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getOrientationDesc());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->isFoil() ? 1 : 0);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getFoilDesc());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getWaveDesc());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->isContraintEte() ? 1 : 0);
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getContraintEteDesc());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getLong());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getLat());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getWindfinder());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getWindguru());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getMeteoFrance());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getMeteoConsult());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getAlloSurf());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getMerteo());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getTempEau());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getWebcam());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getBalise());
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $spot->getMaree());

            foreach (Spot::DIRECTIONS as $dir) {
                $val = $spot->getOrientationQuality($dir)?->value;
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $val);
            }

            foreach ($spot->getLinks() as $link) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $link->getUrl());
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $link->getTitre());
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($col++) . $row, $link->getCommentaire());
            }

            $row++;
        }

        $filePath = sys_get_temp_dir() . '/export_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filePath;
    }
}
