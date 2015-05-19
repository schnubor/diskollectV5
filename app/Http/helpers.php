<?php

/**
 * Calculate time difference from now to given time
 *
 * @param (string) $timeString  // 2010-04-28 17:25:43
 */
function humanTiming ($timeString)
{
    $time = strtotime($timeString);
    $time = time() - $time; // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}

?>