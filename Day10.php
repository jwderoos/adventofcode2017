<?php

function processInstructions($list, $instructions, $loopCount)
{
    $index = 0;
    $skipSize = 0;
    $count = count($list);

    for ($i = 0; $i < $loopCount; $i++) {
        foreach ($instructions as $instruction) {
            $tempData = array_merge($list, $list, $list);

            $subSet = array_slice($tempData, $index, $instruction);
            $subSet = array_reverse($subSet);

            foreach ($subSet as $key => $newValue) {
                $idx        = ($index + $key) % $count;
                $list[$idx] = $newValue;
            }

            $index = ($index + $instruction + $skipSize) % $count;
            $skipSize++;
        }
    }

    return $list;
}

$input = '129,154,49,198,200,133,97,254,41,6,2,1,255,0,191,108';
$min = 0;
$count = 256;

$instructions = explode(',', $input);
$list = range($min, $count - 1);

$list = processInstructions($list, $instructions, 1);

$answer = $list[0] * $list[1];
echo "\npart 1: $answer\n";


$instructions = str_split($input);
$list = range($min, $count - 1);

foreach ($instructions as &$instruction) {
    $instruction = ord($instruction);
}
array_push($instructions, 17, 31, 73, 47, 23);

$list = processInstructions($list, $instructions, 64);

$elements = [];
while (count($list)) {
    $elements[] =
        array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list)
        ^ array_shift($list);
}

$output = '';
foreach ($elements as $element) {
    $output .= sprintf('%0.2s', dechex($element));
}

echo "part 2 $output\n";

