<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('amount', [$this, 'amountFormat']),
            new TwigFunction('category', [$this, 'getCategory']),
        ];
    }

    public function amountFormat($number)
    {
        if (str_contains($number, '€')) {
            $amount = substr($number, 0, -3);
        }
        else {
            $amount = $number;
        }
        return number_format($amount, 2, '.', ' ')."€";
    }

    public function getCategory($category)
    {
        switch ($category) {
            case 1:
                $type = "Loyer";
                break;
            case 2:
                $type = "Courses";
                break;
            case 3:
                $type = "Achat & Shopping";
                break;
            case 4:
                $type = "Restauration";
                break;
            case 5:
                $type = "Transport";
                break;
            case 6:
                $type = "Abonnement";
                break;
            default:
                $type = "Autres";
                break;
        }

        return $type;
    }
}