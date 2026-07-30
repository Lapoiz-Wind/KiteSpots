<?php

namespace App\Request\ParamConverter;

use App\Entity\Spot;
use App\Repository\SpotRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class SpotParamConverter implements ParamConverterInterface
{
    public function __construct(private SpotRepository $repo) {}

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $codeSpot = $request->attributes->get('codeSpot');
        if (!$codeSpot) {
            return false;
        }

        $spot = $this->repo->findOneByCodeSpot($codeSpot);
        if (!$spot) {
            return false;
        }

        $request->attributes->set($configuration->getName(), $spot);
        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Spot::class;
    }
}
