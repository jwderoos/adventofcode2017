<?php

$input = explode("\n", file_get_contents('input8'));

$registers = [];

foreach ($input as $inputLine) {
    $registers[explode(' ',$inputLine)[0]] = 0;
}
$max = PHP_INT_MIN;
foreach($input as $inputLine) {
    if (strlen($inputLine) == 0 ) {
        continue;
    }
    $parts = explode(' ', $inputLine);
    list($name, $operator, $modifier, $if, $lookup, $compare, $expectedValue) = $parts;

    $currentValue = $registers[$name];
    $compareValue = $registers[$lookup];

    $action = false;
    eval("if ($compareValue $compare $expectedValue) {\$action = true;}");

    if ($action) {
        $currentValue = $operator == 'inc' ? $currentValue + $modifier : $currentValue - $modifier;
    }

    $max = max($currentValue, $max);
    $registers[$name] = $currentValue;
}

echo "maxValue: " . max($registers) . "\n";
echo "maxValue during: $max\n";
