<?php
declare(strict_types=1);

function typesCounter(...$args) : ?array {
    $typesArr = [
        'boolean' => 0,
        'integer' => 0,
        'float' => 0,
        'string' => 0,
        'object' => 0,
        'array' => 0
    ];
    foreach($args as $arg) {
        if (array_key_exists(gettype($arg), $typesArr)) {
            $typesArr[gettype($arg)] += 1;
        }
        elseif (gettype($arg) == 'double'){
            $typesArr['float'] += 1;
        }
        else {
            return null;
        }
    }
    return $typesArr;
}
