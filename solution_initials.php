<?php
declare(strict_types=0);

function surname_processing(string $surname) : string{
    $chars = mb_str_split($surname);
    $chars[0] = mb_strtoupper($chars[0]);
    $hyphen_ind = array_search('-', $chars);
    if ($hyphen_ind){
        $chars[$hyphen_ind + 1] = mb_strtoupper($chars[$hyphen_ind + 1]);
    }
    return implode('', $chars);
}

function name_processing(string $name) : string{
    if (mb_strlen($name) == 0){
        return '';
    }
    $chars = mb_str_split($name);
    $first = mb_strtoupper($chars[0]).".";
    $hyphen_ind = array_search('-', $chars);
    if ($hyphen_ind) {
        $second = mb_strtoupper($chars[$hyphen_ind + 1]).".";
        return $first.'-'.$second;
    }
    return $first;
}

function patronymic_processing(array $patr) : string {
    if ($patr[0] == ''){
        return '';
    }
    foreach ($patr as &$word) {
        if (!mb_strpos($word, '-',)) {
            $word = mb_str_split($word);
            $word = mb_strtoupper($word[0]) . ".";
        }
        else{
            $chars = mb_str_split($word);
            $hyphen_ind = array_search('-', $chars);
            $word = mb_strtoupper($chars[0]).".-".mb_strtoupper($chars[$hyphen_ind + 1]).".";
        }
    }
    return implode('', $patr);
}

function getInitials(string $FIO) : ?string{
    if (!mb_strlen($FIO)){
        return null;
    }
    $FIO = mb_strtolower($FIO);
    $words = mb_split("\s", $FIO);
    if (count($words) < 2){
        return null;
    }
    // F
    $F = surname_processing($words[0]);
    // I
    $I = name_processing($words[1]);
    // O
    $O = array_slice($words, 2);
    $O = patronymic_processing($O);
    //ans
    return $F.' '.$I.''.$O;
}
