<?php
class Program {
    private $name;

    private $weight;

    /** @var Program */
    private $parent;

    /** @var array|Program[]  */
    private $children = [];

    private $childString = '';

    private $totalWeight;

    /**
     * Program constructor.
     * @param $name
     */
    public function __construct($name, $weight)
    {
        $this->name = $name;
        $this->weight = $weight;
    }

    public static function fromNameString($nameString)
    {
        $exp = explode(" ", $nameString);
        $name = $exp[0];
        $weight = trim($exp[1], "()");
        return new self($name, $weight);
    }

    public function addChild(Program $newChild)
    {
        if (!in_array($newChild, $this->children)) {
            $this->children[] = $newChild;
            $newChild->setParent($this);
        }
    }

    /**
     * @return array|Program[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function setParent(Program $newParent) {
        $this->parent = $newParent;
        $newParent->addChild($this);
    }

    public function hasParent()
    {
        return $this->parent instanceof Program;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getTotalWeight()
    {
        if (is_null($this->totalWeight)) {
            foreach ($this->children as $child) {
                $this->totalWeight += $child->getTotalWeight();
            }

            $this->totalWeight += $this->weight;
        }

        return $this->totalWeight;
    }

    public function isBalanced() {
        $lastWeight = 0;
        foreach ($this->children as $child) {
            if ($lastWeight == 0) {
                $lastWeight = $child->getTotalWeight();
            }

            if ($lastWeight <> $child->getTotalWeight()) {
                return false;
            }
        }

        return true;
    }

    public function setChildString($chldString)
    {
        $this->childString = trim($chldString);
    }

    public function getChildString()
    {
        return $this->childString;
    }

    public function getChildNames()
    {
        return explode(', ', $this->childString);
    }

    public function hasChildString()
    {
        return strlen($this->childString) > 0;
    }

    /**
     * @return $this|Program
     */
    public function findUnbalancedNode() {
        foreach ($this->children as $child) {
            if (!$child->isBalanced()) {
                return $child->findUnbalancedNode();
            }
        }

        return $this;
    }

}

/** @var Program[] $programs */
$programs = [];

$input = explode("\n", file_get_contents('input8'));

foreach ($input as $line) {
    $lineParts = explode("->", $line);
    $program = Program::fromNameString($lineParts[0]);
    $programs[$program->getName()] = $program;
    if (isset($lineParts[1])) {
        $program->setChildString($lineParts[1]);
    }
}

foreach ($programs as $program) {
    if ($program->hasChildString()) {
        foreach ($program->getChildNames() as $childName) {
            $program->addChild($programs[$childName]);
        }
    }
}

foreach ($programs as $program) {
    if (!$program->hasParent()) {
        $parent = $program;
    }
}

echo "Parent = " . $parent->getName() . "\n";
$unbalancedNode = $parent->findUnbalancedNode();
echo "Unbalanced node = " . $unbalancedNode->getName() . " -> {$unbalancedNode->getWeight()}\n";
$weights = [];
foreach ($unbalancedNode->getChildren() as $child) {
    @$weights[$child->getTotalWeight()]++;
}

foreach ($weights as $weight => $count) {
    if ($count > 1) {
        $normalWeight = $weight;
    }
}

foreach ($unbalancedNode->getChildren() as $child) {
    if ($child->getTotalWeight() <> $normalWeight) {
        $diff = $normalWeight - $child->getTotalWeight();
        $weight = $child->getWeight() + $diff;
        echo "{$child->getName()} weight should be {$weight}\n" ;
    }
}
