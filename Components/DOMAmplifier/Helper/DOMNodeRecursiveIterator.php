<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\Helper;

use ArrayIterator;
use DOMNodeList;
use RecursiveIterator;
use RecursiveIteratorIterator;

class DOMNodeRecursiveIterator extends ArrayIterator implements RecursiveIterator
{
    /**
     * @param DOMNodeList $node_list the nodelist to iterate over
     */
    public function __construct(DOMNodeList $node_list)
    {
        $nodes = [];

        foreach ($node_list as $node) {
            $nodes[] = $node;
        }

        parent::__construct($nodes);
    }

    /**
     * Returns if an iterator can be created for the current entry.
     *
     * @see http://php.net/manual/en/recursiveiterator.haschildren.php
     *
     * @return bool true if the current entry can be iterated over, otherwise returns false
     *
     * @since 5.1.0
     */
    public function hasChildren()
    {
        return $this->current()->hasChildNodes();
    }

    /**
     * Returns an iterator for the current entry.
     *
     * @see http://php.net/manual/en/recursiveiterator.getchildren.php
     *
     * @return RecursiveIterator an iterator for the current entry
     *
     * @since 5.1.0
     */
    public function getChildren()
    {
        return new self($this->current()->childNodes);
    }

    /**
     * Returns an iterator for this iterator.
     *
     * @return RecursiveIteratorIterator an iterator for this iterator
     */
    public function getRecursiveIterator()
    {
        return new RecursiveIteratorIterator($this, RecursiveIteratorIterator::SELF_FIRST);
    }
}
