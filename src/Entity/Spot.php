<?php

namespace App\Entity;

use App\Enum\WindQuality;
use App\Repository\SpotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpotRepository::class)]
#[ORM\Table(name: 'spot')]
class Spot
{
    /** Les 16 directions de la rose des vents, dans l'ordre. */
    public const array DIRECTIONS = [
        'n', 'nne', 'ne', 'ene', 'e', 'ese', 'se', 'sse',
        's', 'ssw', 'sw', 'wsw', 'w', 'wnw', 'nw', 'nnw',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Assert\NotBlank]
    private ?string $codeSpot = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $codeRegion = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $localisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $distFromParis = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $distFromParisAutoroute = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $timeFromParis = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $peageFromParis = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $mareeDesc = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $orientationDesc = null;

    #[ORM\Column]
    private bool $isFoil = false;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $foilDesc = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $waveDesc = null;

    #[ORM\Column]
    private bool $isContraintEte = false;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $contraintEteDesc = null;

    #[ORM\Column(nullable: true)]
    private ?float $long = null;

    #[ORM\Column(nullable: true)]
    private ?float $lat = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $windfinder = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $windguru = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $meteoFrance = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $meteoConsult = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $alloSurf = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $merteo = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $tempEau = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $webcam = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $balise = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $maree = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $top = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $ok = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $warn = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $ko = null;

    /**
     * Qualité du vent par direction (clé = une valeur de self::DIRECTIONS, valeur = WindQuality::value ou null).
     *
     * @var array<string, string|null>
     */
    #[ORM\Column(type: 'json')]
    private array $orientations = [];

    /** @var Collection<int, SpotLink> */
    #[ORM\OneToMany(mappedBy: 'spot', targetEntity: SpotLink::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeSpot(): ?string
    {
        return $this->codeSpot;
    }

    public function setCodeSpot(?string $codeSpot): static
    {
        $this->codeSpot = $codeSpot;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getCodeRegion(): ?string
    {
        return $this->codeRegion;
    }

    public function setCodeRegion(?string $codeRegion): static
    {
        $this->codeRegion = $codeRegion;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDistFromParis(): ?string
    {
        return $this->distFromParis;
    }

    public function setDistFromParis(?string $distFromParis): static
    {
        $this->distFromParis = $distFromParis;

        return $this;
    }

    public function getDistFromParisAutoroute(): ?string
    {
        return $this->distFromParisAutoroute;
    }

    public function setDistFromParisAutoroute(?string $distFromParisAutoroute): static
    {
        $this->distFromParisAutoroute = $distFromParisAutoroute;

        return $this;
    }

    public function getTimeFromParis(): ?string
    {
        return $this->timeFromParis;
    }

    public function setTimeFromParis(?string $timeFromParis): static
    {
        $this->timeFromParis = $timeFromParis;

        return $this;
    }

    public function getPeageFromParis(): ?string
    {
        return $this->peageFromParis;
    }

    public function setPeageFromParis(?string $peageFromParis): static
    {
        $this->peageFromParis = $peageFromParis;

        return $this;
    }

    public function getMareeDesc(): ?string
    {
        return $this->mareeDesc;
    }

    public function setMareeDesc(?string $mareeDesc): static
    {
        $this->mareeDesc = $mareeDesc;

        return $this;
    }

    public function getOrientationDesc(): ?string
    {
        return $this->orientationDesc;
    }

    public function setOrientationDesc(?string $orientationDesc): static
    {
        $this->orientationDesc = $orientationDesc;

        return $this;
    }

    public function isFoil(): bool
    {
        return $this->isFoil;
    }

    public function setIsFoil(bool $isFoil): static
    {
        $this->isFoil = $isFoil;

        return $this;
    }

    public function getFoilDesc(): ?string
    {
        return $this->foilDesc;
    }

    public function setFoilDesc(?string $foilDesc): static
    {
        $this->foilDesc = $foilDesc;

        return $this;
    }

    public function getWaveDesc(): ?string
    {
        return $this->waveDesc;
    }

    public function setWaveDesc(?string $waveDesc): static
    {
        $this->waveDesc = $waveDesc;

        return $this;
    }

    public function isContraintEte(): bool
    {
        return $this->isContraintEte;
    }

    public function setIsContraintEte(bool $isContraintEte): static
    {
        $this->isContraintEte = $isContraintEte;

        return $this;
    }

    public function getContraintEteDesc(): ?string
    {
        return $this->contraintEteDesc;
    }

    public function setContraintEteDesc(?string $contraintEteDesc): static
    {
        $this->contraintEteDesc = $contraintEteDesc;

        return $this;
    }

    public function getLong(): ?float
    {
        return $this->long;
    }

    public function setLong(?float $long): static
    {
        $this->long = $long;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getWindfinder(): ?string
    {
        return $this->windfinder;
    }

    public function setWindfinder(?string $windfinder): static
    {
        $this->windfinder = $windfinder;

        return $this;
    }

    public function getWindguru(): ?string
    {
        return $this->windguru;
    }

    public function setWindguru(?string $windguru): static
    {
        $this->windguru = $windguru;

        return $this;
    }

    public function getMeteoFrance(): ?string
    {
        return $this->meteoFrance;
    }

    public function setMeteoFrance(?string $meteoFrance): static
    {
        $this->meteoFrance = $meteoFrance;

        return $this;
    }

    public function getMeteoConsult(): ?string
    {
        return $this->meteoConsult;
    }

    public function setMeteoConsult(?string $meteoConsult): static
    {
        $this->meteoConsult = $meteoConsult;

        return $this;
    }

    public function getAlloSurf(): ?string
    {
        return $this->alloSurf;
    }

    public function setAlloSurf(?string $alloSurf): static
    {
        $this->alloSurf = $alloSurf;

        return $this;
    }

    public function getMerteo(): ?string
    {
        return $this->merteo;
    }

    public function setMerteo(?string $merteo): static
    {
        $this->merteo = $merteo;

        return $this;
    }

    public function getTempEau(): ?string
    {
        return $this->tempEau;
    }

    public function setTempEau(?string $tempEau): static
    {
        $this->tempEau = $tempEau;

        return $this;
    }

    public function getWebcam(): ?string
    {
        return $this->webcam;
    }

    public function setWebcam(?string $webcam): static
    {
        $this->webcam = $webcam;

        return $this;
    }

    public function getBalise(): ?string
    {
        return $this->balise;
    }

    public function setBalise(?string $balise): static
    {
        $this->balise = $balise;

        return $this;
    }

    public function getMaree(): ?string
    {
        return $this->maree;
    }

    public function setMaree(?string $maree): static
    {
        $this->maree = $maree;

        return $this;
    }

    /** @return array<string, string|null> */
    public function getOrientations(): array
    {
        return $this->orientations;
    }

    /** @param array<string, string|null> $orientations */
    public function setOrientations(array $orientations): static
    {
        $this->orientations = $orientations;

        return $this;
    }

    public function getOrientationQuality(string $direction): ?WindQuality
    {
        $value = $this->orientations[$direction] ?? null;

        return $value !== null ? WindQuality::from($value) : null;
    }

    public function setOrientationQuality(string $direction, ?WindQuality $quality): static
    {
        $this->orientations[$direction] = $quality?->value;

        return $this;
    }

    /** @return Collection<int, SpotLink> */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(SpotLink $link): static
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setSpot($this);
        }

        return $this;
    }

    public function removeLink(SpotLink $link): static
    {
        if ($this->links->removeElement($link) && $link->getSpot() === $this) {
            $link->setSpot(null);
        }

        return $this;
    }

    public function getTop(): ?string
    {
        return $this->top;
    }

    public function setTop(?string $top): static
    {
        $this->top = $top;
        return $this;
    }

    public function getOk(): ?string
    {
        return $this->ok;
    }

    public function setOk(?string $ok): static
    {
        $this->ok = $ok;
        return $this;
    }

    public function getWarn(): ?string
    {
        return $this->warn;
    }

    public function setWarn(?string $warn): static
    {
        $this->warn = $warn;
        return $this;
    }

    public function getKo(): ?string
    {
        return $this->ko;
    }

    public function setKo(?string $ko): static
    {
        $this->ko = $ko;
        return $this;
    }

    public function getTidalConstraintsChart(): array
    {
        $constraints = [];
        $ranges = [];

        if ($this->top) {
            $ranges[] = ['type' => 'top', 'value' => $this->top];
        }
        if ($this->ok) {
            $ranges[] = ['type' => 'ok', 'value' => $this->ok];
        }
        if ($this->warn) {
            $ranges[] = ['type' => 'warn', 'value' => $this->warn];
        }
        if ($this->ko) {
            $ranges[] = ['type' => 'ko', 'value' => $this->ko];
        }

        $allNumbers = [];
        foreach ($ranges as $range) {
            preg_match('/(\d+\.?\d*)\s*->\s*(\d+\.?\d*)/', $range['value'], $matches);
            if (!empty($matches)) {
                $min = (float)$matches[1];
                $max = (float)$matches[2];
                $constraints[] = [
                    'type' => $range['type'],
                    'label' => $this->getConstraintLabel($range['type']),
                    'min' => $min,
                    'max' => $max,
                    'value' => $range['value'],
                ];
                $allNumbers[] = $min;
                $allNumbers[] = $max;
            }
        }

        return [
            'constraints' => $constraints,
            'maxHeight' => !empty($allNumbers) ? ceil(max($allNumbers)) : 6,
        ];
    }

    private function getConstraintLabel(string $type): string
    {
        return match ($type) {
            'top' => 'Top',
            'ok' => 'OK',
            'warn' => 'Attention',
            'ko' => 'Non praticable',
            default => '',
        };
    }

    public function __toString(): string
    {
        return $this->nom ?? '';
    }
}
