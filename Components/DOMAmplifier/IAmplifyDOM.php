<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier;

use DOMNode;

interface IAmplifyDOM
{
    /**
     * Process and ⚡lifies the given node.
     *
     * @param DOMNode $node the node to ⚡lify
     *
     * @return DOMNode the ⚡lified node
     */
    public function amplify(DOMNode $node);
}
