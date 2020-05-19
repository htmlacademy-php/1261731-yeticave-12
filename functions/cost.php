<?php

/**
 * @param $cost
 * @return string
 */

function cost($cost)
{
    $cost = ceil($cost);
    if (1000 <= $cost) {
        $cost = number_format($cost, 0, '', ' ');
    }

    return $cost . " ";
}

;
