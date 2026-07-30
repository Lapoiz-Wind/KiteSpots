<?php

namespace App\Service;

use App\Entity\Spot;
use App\Entity\SpotLink;
use App\Enum\WindQuality;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SpotImporter
{
    public function __construct(private EntityManagerInterface $em) {}

    public function import(string $filePath): int
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (empty($rows)) {
            return 0;
        }

        $headers = array_map('trim', $rows[0] ?? []);
        $headerMap = array_flip($headers);
        $count = 0;

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $codeSpot = $row[$headerMap['CodeSpot'] ?? -1] ?? null;

            if (!$codeSpot) {
                continue;
            }

            $spot = $this->em->getRepository(Spot::class)->findOneByCodeSpot($codeSpot)
                ?? new Spot();

            $spot->setCodeSpot($codeSpot);
            $spot->setNom($row[$headerMap['Nom'] ?? -1] ?? null);
            $spot->setRegion($row[$headerMap['Region'] ?? -1] ?? null);
            $spot->setCodeRegion($row[$headerMap['CodeRegion'] ?? -1] ?? null);
            $spot->setNote($this->toFloat($row[$headerMap['Note'] ?? -1] ?? null));
            $spot->setShortDescription($row[$headerMap['ShortDescription'] ?? -1] ?? null);
            $spot->setDescription($row[$headerMap['Description'] ?? -1] ?? null);
            $spot->setLocalisation($row[$headerMap['Localisation'] ?? -1] ?? null);
            $spot->setDistFromParis($row[$headerMap['DistFromParis'] ?? -1] ?? null);
            $spot->setDistFromParisAutoroute($row[$headerMap['DistFromParisAutoroute'] ?? -1] ?? null);
            $spot->setTimeFromParis($row[$headerMap['TimeFromParis'] ?? -1] ?? null);
            $spot->setPeageFromParis($row[$headerMap['PéageFromParis'] ?? -1] ?? null);
            $spot->setMareeDesc($row[$headerMap['MareeDesc'] ?? -1] ?? null);
            $spot->setOrientationDesc($row[$headerMap['OrientationDesc'] ?? -1] ?? null);
            $spot->setIsFoil($this->toBool($row[$headerMap['IsFoil'] ?? -1] ?? false));
            $spot->setFoilDesc($row[$headerMap['FoilDesc'] ?? -1] ?? null);
            $spot->setWaveDesc($row[$headerMap['WaveDesc'] ?? -1] ?? null);
            $spot->setIsContraintEte($this->toBool($row[$headerMap['IsContraintEte'] ?? -1] ?? false));
            $spot->setContraintEteDesc($row[$headerMap['ContraintEteDesc'] ?? -1] ?? null);
            $spot->setLong($this->toFloat($row[$headerMap['Long'] ?? -1] ?? null));
            $spot->setLat($this->toFloat($row[$headerMap['Lat'] ?? -1] ?? null));
            $spot->setWindfinder($row[$headerMap['Windfinder'] ?? -1] ?? null);
            $spot->setWindguru($row[$headerMap['Windguru'] ?? -1] ?? null);
            $spot->setMeteoFrance($row[$headerMap['Meteo France'] ?? -1] ?? null);
            $spot->setMeteoConsult($row[$headerMap['MeteoConsult'] ?? -1] ?? null);
            $spot->setAlloSurf($row[$headerMap['AlloSurf'] ?? -1] ?? null);
            $spot->setMerteo($row[$headerMap['Merteo'] ?? -1] ?? null);
            $spot->setTempEau($row[$headerMap['Temp eau'] ?? -1] ?? null);
            $spot->setWebcam($row[$headerMap['Webcam'] ?? -1] ?? null);
            $spot->setBalise($row[$headerMap['Balise'] ?? -1] ?? null);
            $spot->setMaree($row[$headerMap['Maree'] ?? -1] ?? null);

            $orientations = [];
            foreach (Spot::DIRECTIONS as $dir) {
                $val = $row[$headerMap[$dir] ?? -1] ?? null;
                if ($val !== null && $val !== '' && $val !== -1) {
                    $orientations[$dir] = (string)(int)$val;
                }
            }
            $spot->setOrientations($orientations);

            $spot->getLinks()->clear();
            for ($linkIdx = 1; $linkIdx <= 4; $linkIdx++) {
                $url = $row[$headerMap["URL$linkIdx"] ?? -1] ?? null;
                if ($url && is_string($url) && trim($url)) {
                    $link = new SpotLink();
                    $link->setUrl(trim($url));
                    $link->setTitre($row[$headerMap["Titre$linkIdx"] ?? -1] ?? null);
                    $link->setCommentaire($row[$headerMap["Commentaire$linkIdx"] ?? -1] ?? null);
                    $link->setPosition($linkIdx - 1);
                    $spot->addLink($link);
                }
            }

            $this->em->persist($spot);
            $count++;
        }

        $this->em->flush();
        return $count;
    }

    private function toFloat($val): ?float
    {
        if ($val === null || $val === '') {
            return null;
        }
        $f = (float)$val;
        return $f !== 0.0 ? $f : null;
    }

    private function toBool($val): bool
    {
        return $val == 1 || $val === true;
    }
}
