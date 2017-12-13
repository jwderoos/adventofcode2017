<?php
class Layer {
    private $direction = '1';
    private $position = 0;
    private $maxPosition = 0;

    /**
     * Layer constructor.
     *
     * @param int $positions
     */
    public function __construct($positions)
    {
        $this->maxPosition = $positions - 1;
    }

    public function move()
    {
        if ($this->maxPosition == -1) {
            return;
        }

        if ($this->position == 0) {
            $this->direction = 1;
        }

        if ($this->position == $this->maxPosition) {
            $this->direction = -1;
        }

        $this->position += $this->direction;
    }

    public function isDetecting()
    {
        return $this->maxPosition != -1 && $this->position == 0;
    }

    public function getRange()
    {
        return $this->maxPosition + 1;
    }

    public function reset()
    {
        $this->position = 0;
        $this->direction = 1;
    }
}

$input = file_get_contents('input13');
/** @var Layer[] $layers */
$layers = [];
foreach (explode("\n", trim($input)) as $item) {
    list($depth, $range) = explode(": ", $item);
    $layers[$depth] = new Layer($range);
}

$severity = 0;
for ($currentDepth = 0; $currentDepth <= max(array_keys($layers)); $currentDepth++) {
    foreach ($layers as $depth => $layer) {
        if ($depth == $currentDepth) {
            if ($layer->isDetecting()) {
                $severity += $depth * $layer->getRange();
            }
        }
        $layer->move();
    }
}

echo "1: $severity\n";

foreach($layers as $layer) {
    $layer->reset();
}

$wait = 0;
while (true) {
    $caught = false;
    foreach ($layers as $depth => $layer) {
        if (($wait + $depth) % (2 * ($layer->getRange() -1)) == 0) {
            $caught = true;
            $wait++;
            break;
        }
    }

    if (!$caught) {
        echo "part 2 = $wait\n";
        break;
    }
}
