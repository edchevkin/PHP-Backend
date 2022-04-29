<?php
declare(strict_types=1);

class SimpleCalcBuf
{
    public float $result;

    public function __construct (float $result = 0)
    {
        $this->result = $result;
    }

    public function add (float $figure) : SimpleCalcBuf
    {
        $this->result += $figure;
        return $this;
    }

    public function multiply (float $multiplier) : SimpleCalcBuf
    {
        $this->result *= $multiplier;
        return $this;
    }

    public function substract (float $figure) : SimpleCalcBuf
    {
        $this->result -= $figure;
        return $this;
    }

    public function divide (float $divisor, int $precision = 2) : SimpleCalcBuf
    {
        $this->result = round($this->result / $divisor, $precision);
        return $this;
    }

    public function getResult () : float
    {
        return $this->result;
    }
}

//$myCalc = new SimpleCalcBuf(10);
//echo ($myCalc->add(14)->getResult().PHP_EOL);
//echo($myCalc->multiply(5)->getResult().PHP_EOL);
//echo($myCalc->substract(20)->getResult().PHP_EOL);
//echo($myCalc->divide(3)->getResult().PHP_EOL);