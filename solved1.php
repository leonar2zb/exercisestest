// PHP
<?php

/**
 * Finds a combination of multiplying items reaching a value
 * @param array $L items from the list(the multiplying numbers)
 * @param int $R value to reach to
 * @return string resulting combination or "-1" when no solution is found
 */
function findComb(array $L, int $R): string
{
    $result = [];
    $comb = [];

    // Finds combination recursively
    function backtrack($L, $R, &$comb, &$result, $start)
    {
        if ($R == 1 && !empty($comb)) {
            $result[] = $comb;
            return;
        }
        if ($R < 1) {
            return;
        }

        for ($i = $start; $i < count($L); $i++) {
            if ($R % $L[$i] == 0) {
                $comb[] = $L[$i];
                backtrack($L, $R / $L[$i], $comb, $result, $i);
                array_pop($comb);
            }
        }
    }

    $result = [];
    // edge case: value to reach is zero
    if ($R == 0) {
        $zero = array_search(0, $L, true); // a number zero must exists
        if ($zero)
            $result = "1 0"; // shorter solution no matter the other elements in the array
        else
            $result = "-1"; // there is no solution, no way to reach zero
    }

    $divisors = [];
    // generate a new list with only divisors numbers, exludes "1" also
    foreach ($L as $number) {
        if ($number > 1)
            if ($R % $number == 0)
                $divisors[] = $number;
    }
    if (count($divisors) == 0) // there must me at least one divisor
        $result = "-1";

    sort($divisors, SORT_NUMERIC); // sort the array


    // starts recursivelly
    if (empty($result))
        backtrack($divisors, $R, $comb, $result, 0);


    if (is_array($result)) {
        // determines the shortest array length
        $minLength = count($result[0]);
        $lexFirst = [];
        foreach ($result as $comb) {
            if (count($comb) < $minLength) {
                $minLength = count($comb);
                $lexFirst = $comb;
            }
        }

        // compares and seeks Lexicographically smaller
        foreach ($result as $comb) {
            if (count($comb) == $minLength) {
                $i = 0;
                while (($i < $minLength) && ($comb[$i] > $lexFirst[$i])) $i++;
                if ($i < $minLength)
                    $lexFirst = $comb;
            }
        }

        /*echo "Samples reaching $R:\n";
        foreach ($result as $comb) {
            echo implode(' * ', $comb) . " = $R\n";
        }
        echo "Lexicographically smaller:\n";
        echo implode(' * ', $lexFirst) . " = $R\n";*/
        $result = '1 ' . implode(' ', $lexFirst);
    }
    return $result;
}

// sample use case
$listnumber = [4, 3, 2, 2, 1, 5, 8];
$valueToReach = 100;

$result = findComb($listnumber, $valueToReach);

echo $result;
