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
}