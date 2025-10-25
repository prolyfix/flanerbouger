<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use App\Helper\StringHelper;
use Twig\Attribute\AsTwigFunction;

class AppExtension
{
    #[AsTwigFunction('dateRange')]
    public function formatDateRange(\DateTimeInterface $start, \DateTimeInterface $end): string
    {
        if ($start->format('Y-m-d') === $end->format('Y-m-d')) {
            return "Le ".$start->format('d')." ".StringHelper::retrieveMonth((int)$start->format('m'))." ".$start->format('Y');
        }

        return "Du ".$start->format('d')." ".StringHelper::retrieveMonth((int)$start->format('m'))." ".$start->format('Y').
               " au ".$end->format('d')." ".StringHelper::retrieveMonth((int)$end->format('m'))." ".$end->format('Y');
    }

    #[AsTwigFunction('hourRange')]
    public function formatHourRange(\DateTimeInterface $start, \DateTimeInterface $end): string
    {
        if($end===null) {
            return "À partir de ".$start->format('H:i');
        }
        if($end->format('H:i') === '00:00'&& $start->format('H:i') === '00:00') {
            return "Toute la journée";
        }
        

        return "De ".$start->format('H:i')." à ".$end->format('H:i');
    }
}