<?php

namespace App\Twig;

use Carbon\Carbon;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CarbonExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('diffForHumans', [$this, 'diffForHumans']),
        ];
    }

    public function diffForHumans($date)
    {
        // Utilisation de Carbon pour la date relative
        return Carbon::parse($date)->diffForHumans();
    }
}
