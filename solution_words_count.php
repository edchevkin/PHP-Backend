<?php
declare(strict_types=1);

function wordsCount(string $sourceString) : array {
    if ($sourceString == ""){
        return [];
    }
    $charArr = mb_str_split(mb_strtolower($sourceString));
    $bad = '-,.;:"'."'";
    $bad = mb_str_split($bad);
    $word = '';
    $dict = [];
    foreach($charArr as $key => $char) {
        if (in_array($char, $bad)) {
            unset($charArr[$key]);
        }
    }
    foreach($charArr as $char){
        if ($char != ' '){
            $word .= $char;
        }
        else{
            if ($word) {
                if (array_key_exists($word, $dict)) {
                    $dict[$word] += 1;
                }
                else {
                    $dict[$word] = 1;
                }
                $word = '';
            }
        }
    }
    if ($word){
        if (array_key_exists($word, $dict)) {
            $dict[$word] += 1;
        }
        else {
            $dict[$word] = 1;
        }
    }
    ksort($dict);
    return $dict;
}