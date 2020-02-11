<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use DOMNode;
use Sabberworm\CSS\CSSList\Document;

interface IAmplifyDOMStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param DOMNode  $domNode       the node to ⚡lify
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(DOMNode &$domNode, Document &$styleDocument);
}
