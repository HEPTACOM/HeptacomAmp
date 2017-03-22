<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMNode;
use Sabberworm\CSS\CSSList\Document;

/**
 * Interface IAmplifyDOMStyle
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM
 */
interface IAmplifyDOMStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param DOMNode $domNode The node to ⚡lify.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(DOMNode& $domNode, Document& $styleDocument);
}
