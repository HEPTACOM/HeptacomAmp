<?php

namespace HeptacomAmp\Components\DOMAmplifier;

use DOMNode;

/**
 * Interface IAmplifyDOM
 * @package HeptacomAmp\Components\DOMAmplifier
 */
interface IAmplifyDOM
{
    /**
     * Process and ⚡lifies the given node.
     * @param DOMNode $node The node to ⚡lify.
     * @return DOMNode The ⚡lified node.
     */
    function amplify(DOMNode $node);
}
