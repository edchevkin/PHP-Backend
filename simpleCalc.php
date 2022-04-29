<?php
declare(strict_types=1);

class SimpleCalc
{


    public static function add (float $figure, float $figure_2) : float
    {
        return $figure + $figure_2;
    }

    public static function multiply (float $figure, float $multiplier) : float
    {
        return $figure * $multiplier;
    }

    public static function substract (float $figure, float $figure_2) : float
    {
        return $figure - $figure_2;
    }

    public static function divide (float $divisible, float $divisor) : float
    {
        return round($divisible / $divisor, 2);
    }
}

//echo (SimpleCalc::add(14, 10).PHP_EOL);
//echo (SimpleCalc::multiply(14 ,10).PHP_EOL);
//echo (SimpleCalc::substract(14, 10).PHP_EOL);
//echo (SimpleCalc::divide(14, 10));