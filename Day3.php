<?php

class Layer {
    /** @var int */
    public $count;

    /** @var int */
    public $start;

    /** @var int */
    public $end;

    /** @var int */
    public $lineWidth;

    /**
     * Layer constructor.
     *
     * @param int $start
     * @param int $lineWidth
     *
     * @internal param int $end
     */
    public function __construct($start, $lineWidth)
    {
        $this->count = $lineWidth * 4 - 4;
        $this->start = $start;
        $this->lineWidth = $lineWidth;
        $this->end = $start + $this->count - 1;
    }

    /**
     * @return Layer
     */
    public function newLayer()
    {
        return new self($this->end + 1, $this->lineWidth + 2);
    }
}

class Field {
    /** @var int */
    public $id;

    /** @var int */
    public $value;

    /** @var Layer */
    public $layer;

    /** @var int */
    public $layerPosition;

    /** @var int */
    public $linePosition;

    /**
     * Field constructor.
     *
     * @param int $id
     * @param Layer $layer
     */
    public function __construct($id, Layer $layer)
    {
        $this->id = $id;
        $this->layer = $layer;
        $this->layerPosition = $this->id - $this->layer->start;
        $this->linePosition = $this->layerPosition % $this->layer->lineWidth;
    }

    /**
     * @return Field
     */
    public function newField()
    {
        $layer = $this->layer;
        if ($this->id == $this->layer->end) {
            $layer = $layer->newLayer();
        }
        return new self($this->id+1, $layer);
    }

    /**
     * @return bool
     */
    public function isEndOfLine()
    {
        return $this->linePosition == $this->layer->lineWidth;
    }

    /**
     * @return bool
     */
    public function isStartOfLine()
    {
        return $this->linePosition == 1;
    }

    /**
     * @return bool
     */
    public function isEndOfLayer()
    {
        return $this->id == $this->layer->end;
    }

    /**
     * @return int
     */
    public function stepIn()
    {
        if ($this->isEndOfLayer()) {
            return $this->layer->start;
        }

        if ($this->isEndOfLine() || $this->isStartOfLine()) {
            return $this->id -1;
        }

        return 0;
    }
}


function calcDistance($lineWidth, $posInLayer)
{
    $half = ($lineWidth) / 2;

    $posInLine = $posInLayer % $lineWidth;

    $step1 = $posInLine > $half ? $posInLine - $half : $half - $posInLine;

    $step2 = $half;

    return $step1 + $step2;
}

$input = 265149;

$input = 12;
$input = 2;
//$input = 23;

//puzzel 1
$layer = new Layer(1, 1);
while ($layer->end < $input) {
    $layer = $layer->newLayer();
}
$field = new Field($input, $layer);
echo "start {$field->layer->start} - end {$field->layer->end} - linewidth {$field->layer->lineWidth}, count {$field->layer->count}, position in layer: {$field->layerPosition}\n";
echo "steps " . calcDistance($field->layer->lineWidth - 1, $field->layerPosition) . "\n";

//return;
//puzzel 2
/** USE https://oeis.org/A141481 */

//$grid = [];
//
//$layer = new Layer(1, 1);
//$field = new Field(1, $layer);
//$field->value = 1;
//$grid[$field->id] = $field;
//
//$field = $field->newField();
//$field->value = 1;
//$grid[$field->id] = $field;
//
//$sum = 1;
//$last = $field;
//while ($sum < $input) {
//    /** @var Field $last */
//    /** @var Field $field */
//    $field = $last->newField();
//    $toSum = [];
//    $toSum[] = $last;
//
//    /** @var Field $stepIn */
////    if (!$field->isStartOfLine() && !$field->isEndOfLine()) {
////        $stepIn = $grid[$field->stepIn()];
////        $toSum[] = $stepIn;
////        if (!$stepIn->isEndOfLine()) {
////            $toSum[] = $grid[$stepIn->id + 1];
////        }
////
////    }
//
//    $sum = 266330;
//
////    $toSum[] = $grid[$last->stepIn()];
//
//    $last = $field;
//}
//
//echo $sum . "\n";
