<?php
$input = file_get_contents('input11');

//$input = 'ne,ne,ne'; //3
//$input = 'ne,ne,sw,sw'; //0
//$input = 'ne,ne,s,s'; //2
//$input = 'se,sw,se,sw,sw'; //3

$moves = explode(',', trim($input));

$x = $y = $z = 0;
$steps = 1;
$dists = [];
foreach ($moves as $move) {
    switch ($move) {
        case 'n' :
            $y++;
            $z--;
            break;
        case 's' :
            $y--;
            $z++;
            break;
        case 'ne';
            $x++;
            $z--;
            break;
        case 'nw';
            $x--;
            $y++;
            break;
        case 'se';
            $x++;
            $y--;
            break;
        case 'sw';
            $x--;
            $z++;
            break;
        default :
            echo "Unexpected character: $move\n";
            die;
            break;
    }
    $dists[] = (abs($x) + abs($y) + abs($z)) / 2;
}

echo "X $x Y $y Z $z\n";
echo (abs($x) + abs($y) + abs($z)) / 2 . "\n";
echo max($dists) . "\n";

//echo "Steps from origin ". max($x, $y) . "\n";

