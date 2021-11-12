<?php
declare(strict_types=1);

function getSumNK ($input, int $N, int $K) : int {
    foreach($input as $value) {
        if (gettype($value) != "integer") {
            return -1;
        }
    }
    if (count($input) == 0){
        return 0;
    }
    if (count($input) < $N + $K - 1) {
        return -1;
    }
    if ($K < 0 or $N < 0){
        return -1;
    }
    if ($N == 0) {
        return array_sum($input);
    }
    if ($K == 0) {
        $K = 1;
    }
    $input = array_slice($input, $K - 1, $N);
    return array_sum($input);
}
