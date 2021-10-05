<?php

if (!array_key_exists('HTTP_X_ACCESS_TOKEN',$_SERVER)){
    echo "Запрещено, не задан токен";
    die();
}

if ($_SERVER['HTTP_X_ACCESS_TOKEN'] != 'SECRET_TOKEN'){
    echo "Запрещено, неверный токен";
    die();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo "Запрещено, неверный метод";
    die();
}

if($_SERVER['CONTENT_TYPE'] != 'application/x-www-form-urlencoded'){
    echo "Ошибка, неверный тип данных";
    die();
}

if (!count($_POST)){
    echo "Ошибка, данные не заданы";
    die();
}

if(!array_key_exists('page', $_GET)){
    echo "Ошибка, не здан тип странцы";
    die();
}
else{
    if ($_GET['page'] == 'page1' or
        $_GET['page'] == 'page2' or
        $_GET['page'] == 'page3'){
        echo "Запрошена страница ".htmlentities($_GET['page']),"<br>";;
    }
    else{
        echo 'Ошибка, недопустимый тип страницы';
        die();
    }
}

if(count($_POST)){
    echo "Через POST передано ".htmlentities(count($_POST))." переменных","<br>";
    foreach($_POST as $key => $value){
        echo "Значение [".htmlentities($key)."]: ".htmlentities($value),"<br>";
    }
}

