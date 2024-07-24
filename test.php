<?php

function checkString($string)
{
    $array = str_split($string);

    $startChars = ['(','{','['];
    $endChars = [')','}',']'];
    $set = [];

    if(count($array) % 2 != 0) {
        echo "false1\n";
        return false;
    }
    if(!in_array($array[0], $startChars)) {
        echo "false2\n";
        return false;
    }

    foreach ($array as $char) {

        if (in_array($char, $startChars)) {
            $set[] = $char;
        } else {

            $endIndex = array_search($char, $endChars);
            if($endIndex === false) {
                echo "false3\n";
                return false;
            }

            if(isset($set[count($set) - 1])) {
                $startIndex = array_search($set[count($set) - 1], $startChars);

                if ($startIndex == $endIndex) {
                    unset($set[count($set) - 1]);
                } else {
                    echo "false4\n";
                    return false;
                }
            } else {
                echo $char;
                echo "false5\n";
                return false;
            }
        }
    }


//    var_dump($set);
    if (count($set) > 0) {
        echo "false6\n";
        return false;
    }

    echo "true\n";
    return true;
}


//checkString("((()))))");

function binarySearch($target)
{
    $arrays = [0,1,2,3,4,5,6,7,8,9,10,11,12];

    $left = 0;
    $right = count($arrays) - 1;

    $found = false;

    while ($left <= $right) {
        $middle = floor(($right + $left) / 2);

        if($arrays[$middle] == $target) {
            $found = $middle;
            break;
        } elseif($arrays[$middle] < $target) {
            $left = $middle + 1;
        } else {
            $right = $middle - 1;
        }

    }

    return $found;
}

$searchResult = binarySearch(12);
if($searchResult) {
    echo $searchResult."\n";
} else {
    echo "false\n";
}


function printStar($line)
{
    echo "<pre>";
    for ($i = 1; $i <= $line; $i++) {
        $maxStart = ($line * 2) - 1;
        $currentStar = ($i * 2) - 1;
        $space = ($maxStart - $currentStar) / 2;
        for ($j = 1; $j<=$space; $j++) {
            echo "_";
        }
        for ($j = 1; $j<=$currentStar; $j++) {
            echo " ";
        }
        for ($j = 1; $j<=$space; $j++) {
            echo "_";
        }
        echo "</br>";
    }
    echo "</pre>";
}

//printStar(100);



function printStar2($line)
{
    echo "<pre>";
    $maxStart = ($line * 2) - 1;
    for ($i = 1; $i <= $line; $i++) {
        $currentStar = ($i * 2) - 1;
        $space = ($maxStart - $currentStar) / 2;
        for ($j = 1; $j<=$space; $j++) {
            echo " ";
        }
        for ($j = 1; $j<=$currentStar; $j++) {
            echo "*";
        }
        for ($j = 1; $j<=$space; $j++) {
            echo " ";
        }
        echo "</br>";
    }
    for ($i = $line - 1; $i >= 1; $i--) {
        $currentStar = ($i * 2) - 1;
        $space = ($maxStart - $currentStar) / 2;
        for ($j = 1; $j<=$space; $j++) {
            echo " ";
        }
        for ($j = 1; $j<=$currentStar; $j++) {
            echo "*";
        }
        for ($j = 1; $j<=$space; $j++) {
            echo " ";
        }
        echo "</br>";
    }
    echo "</pre>";
}

//printStar2(10);
