<?php

namespace HeptacomAmp\Components\DOMAmplifier\Helper;

use ArrayIterator;
use DOMNodeList;
use RecursiveIterator;
use RecursiveIteratorIterator;

/**
 * Class DOMNodeRecursiveIterator
 * @package HeptacomAmp\Components\DOMAmplifier\Helper
 */
class DOMNodeRecursiveIterator extends ArrayIterator implements RecursiveIterator
{
    /**
     * DOMNodeRecursiveIterator constructor.
     * @param DOMNodeList $node_list The nodelist to iterate over.
     */
    public function __construct(DOMNodeList $node_list)
    {
        $nodes = array();

        foreach ($node_list as $node) {
            $nodes[] = $node;
        }

        parent::__construct($nodes);
    }

    /**
     * Returns if an iterator can be created for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.haschildren.php
     * @return bool true if the current entry can be iterated over, otherwise returns false.
     * @since 5.1.0
     */
    public function hasChildren()
    {
        return $this->current()->hasChildNodes();
    }

    /**
     * Returns an iterator for the current entry.
     * @link http://php.net/manual/en/recursiveiterator.getchildren.php
     * @return RecursiveIterator An iterator for the current entry.
     * @since 5.1.0
     */
    public function getChildren()
    {
        return new self($this->current()->childNodes);
    }

    /**
     * Returns an iterator for this iterator.
     * @return RecursiveIteratorIterator An iterator for this iterator.
     */
    public function getRecursiveIterator()
    {
        return new RecursiveIteratorIterator($this, RecursiveIteratorIterator::SELF_FIRST);
    }
}
