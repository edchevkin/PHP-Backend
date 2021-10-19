<?php
declare(strict_types=1);

function getBMI(int $height, float $weight) : ?float{
    if ($height < 10 or $height > 300 or
        $weight < 1.0 or $weight > 300.0) {
        return null;
    }
    return round($weight/(($height/100)**2), 2, PHP_ROUND_HALF_UP);
    ;
}
