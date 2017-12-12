<?php

class Node {
    private $id;

    /** @var Node[] */
    private $contacts = [];

    private static $seenInCount = [];

    /**
     * Node constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function addContact(Node $contact)
    {
        if (!in_array($contact, $this->contacts)) {
            $this->contacts[] = $contact;
        }
    }

    public function countContacts($depth = 0)
    {
        $sum = 0;
        if (!in_array($this, self::$seenInCount)) {
            self::$seenInCount[] = $this;
            $sum++;
            foreach ($this->contacts as $contact) {
                $sum += $contact->countContacts($depth + 1);
            }
        }

        if ($depth == 0) {
            self::$seenInCount = [];
        }

        return $sum;
    }

    /**
     * @return Node[]
     */
    public function getGroup() {
        $this->countContacts(1);
        $group = self::$seenInCount;
        self::$seenInCount = [];
        return $group;
    }
}

$input = file_get_contents('input12');
$connections = explode("\n", trim($input));

/** @var Node[] $nodes */
$nodes = [];

foreach ($connections as $connection) {
    $node = new Node(substr($connection, 0, strpos($connection, ' <->')));
    $nodes[$node->getId()] = $node;
}


foreach ($connections as $connection) {
    list($nodeId, $contacts) = explode(' <-> ', $connection);
    $node = $nodes[(int)$nodeId];
    foreach (explode(', ', $contacts) as $contactId) {
        $contact = $nodes[$contactId];
        $node->addContact($contact);
    }
}

$node = $nodes[0];
echo $node->countContacts() . "\n";

$groups = [];
foreach ($nodes as $node) {
    foreach ($groups as $group) {
        if (in_array($node, $group)) {
            continue 2;
        }
    }

    $groups[] = $node->getGroup();
}

echo count($groups) . "\n";
