// PHP

<?php

/**
 * Determines if remains wrestlers for fighting based on theirs potentials
 * @param array $remaining list of potencials remaining to analyze
 * @param int $at possition where a fight might produce if it is possible
 * @return bool wheter its posible or not to.
 */
function canFight(array $remaining, int &$at): bool
{
    $sameSign = true;
    $pos = 0;
    $can = false;
    if (count($remaining) >= 2)
        do {
            $sameSign = $remaining[$pos] * $remaining[$pos + 1] > 0;
            $can = !$sameSign && ($remaining[$pos] > $remaining[$pos + 1]);
            $pos++;
        } while (($pos <= count($remaining) - 2) && (!$can));
    if ($can) {
        $at = $pos == 0 ? 0 : $pos - 1;
    }
    return $can;
}

/**
 * Starts the struggle, removing the wrestlers based on the rules. Order matters
 * @param array $fighters list of the potentials from each wretlers
 * @return array remaining wrestlers after the struggle
 */
function fight(array $fighters): array
{
    $i = 0;
    while (canFight($fighters, $i)) {
        if (abs($fighters[$i]) > abs($fighters[$i + 1])) {
            array_splice($fighters, $i + 1, 1);
        } else if (abs($fighters[$i]) < abs($fighters[$i + 1])) {
            array_splice($fighters, $i, 1);
        } else {
            array_splice($fighters, $i, 2);
        }
    }
    sort($fighters, SORT_NUMERIC);
    return $fighters;
}

/* samples
$potentials = [5, 10, -15, 6, 7, -3]; // -15 6 7
$potentials = [-5, 1]; // -5 1
$potentials = []; // []
$potentials = [5, -5, 3]; // 3
$potentials = [5, 3, -5]; // []
$potentials = [-5, 5, 3]; // -5 3 5
$potentials = [5, -5]; // []
$potentials = [5]; // 5
$potentials = [-5, 5, -3]; // -5 5
$potentials = [-5, -3, 5]; // -5 -3 5
$potentials = [-5, -10, 15, 6, -7, -3]; // -10 -5 15 */
$potentials = [5, 10, -5]; // 5 10

$lords = fight($potentials);
//print_r($lords);
echo '[' . implode(', ', $lords) . ']';
