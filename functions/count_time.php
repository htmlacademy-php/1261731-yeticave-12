<?php
/**
 * Вычисляет время до даты окончания торгов по лоту
 *
 * @param $expiration_date дата окончания действия цены лота введенная пользователем
 *
 * @return array часы и минуты в массиве
 */
function countTime(string $expiration_date) : array
{
    $current_date = date('Y-m-d H:i');

    $diff_in_hour = (strtotime($expiration_date) - strtotime($current_date)) / 3600;
    $diff_in_hour = floor($diff_in_hour);

    $diff_in_min = (strtotime($expiration_date) - strtotime($current_date)) / 60;
    $diff_in_min = $diff_in_min - ($diff_in_hour * 60);
    $diff_in_min = round($diff_in_min);

    if (0 <= $diff_in_hour) {
        $time_limit[] = $diff_in_hour;
        $time_limit[] = $diff_in_min;
    } else {
        $time_limit[] = 0;
        $time_limit[] = 0;
    }

    return $time_limit;
}
