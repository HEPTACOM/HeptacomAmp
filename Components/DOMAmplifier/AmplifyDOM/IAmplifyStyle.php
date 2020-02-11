<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM;

use Sabberworm\CSS\CSSList\Document;

interface IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(Document &$styleDocument);
}
