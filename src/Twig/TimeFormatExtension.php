<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TimeFormatExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('formatTime', [$this, 'formatTime']),
        ];
    }

    public function formatTime($minutes): string
    {
        if (!$minutes || !is_numeric($minutes)) {
            return '';
        }

        $minutes = (int)$minutes;
        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;

        if ($hours === 0) {
            return $mins . ' min';
        }

        if ($mins === 0) {
            return $hours . ' h';
        }

        return $hours . ' h ' . $mins . ' min';
    }
}
