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


checkString("((()))))");
