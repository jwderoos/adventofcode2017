<?php

function isConfigurationKnown($input, &$knownConfigurations)
{
    $config = implode(',', $input);
    if (in_array($config, $knownConfigurations)) {
        return true;
    }

    $knownConfigurations[] = $config;

    return false;
}

function getMaxPosition($input)
{
    $maxValue = 0;
    $maxKey   = 0;
    foreach ($input as $key => $value) {
        if ($value > $maxValue) {
            $maxValue = $value;
            $maxKey   = $key;
        }
    }

    return $maxKey;
}

$input = '14	0	15	12	11	11	3	5	1	6	8	4	9	1	8	4';

$mem = explode("\t", $input);
$positions = count($mem) -1;

$knownConfigurations = [];
$step = 0;
$loop = false;


while (true) {

    if (isConfigurationKnown($mem, $knownConfigurations)) {
        if ($loop) {
            echo "$step\n";
            return;
        }

        $knownConfigurations = [];
        echo "$step\n";
        $step = 0;
        $loop = true;
        isConfigurationKnown($mem, $knownConfigurations);
    }

    $maxPosition = getMaxPosition($mem);

    $val = $mem[$maxPosition];
    $mem[$maxPosition] = 0;
    $pos = $maxPosition;

    while ($val > 0) {
        $pos++;
        if ($pos > $positions) {
            $pos = 0;
        }

        $mem[$pos]++;
        $val--;
    }

    $step++;
}


