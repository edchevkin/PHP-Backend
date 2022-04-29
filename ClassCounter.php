<?php
declare(strict_types=1);

class ClassCounter
{
    private static int $callCounter = 0;
    private static int $objCounter = 0;

    public function __construct()
    {
        self::$objCounter += 1;
    }

    public function __destruct()
    {
        self::$objCounter -= 1;
    }

    public function __call($name, array $params)
    {
        if ($name == "callMethod")
        {
            self::$callCounter += 1;
        }
    }

    public static function getObjectsNum() : int
    {
        return self::$objCounter;
    }

    public static function getMethodCallNum() : int
    {
        return self::$callCounter;
    }
}

//$a = new ClassCounter();
//echo ClassCounter::getObjectsNum().PHP_EOL; // 1
//$a->callMethod();
//echo ClassCounter::getMethodCallNum().PHP_EOL; //1
//$a->callMethod();
//echo ClassCounter::getMethodCallNum().PHP_EOL; //2
//$b = new ClassCounter();
//echo ClassCounter::getObjectsNum().PHP_EOL; // 2
//$b->callMethod();
//echo ClassCounter::getMethodCallNum().PHP_EOL; //3
//unset( $a );
//echo ClassCounter::getObjectsNum().PHP_EOL; // 1
