<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Property\Import;

/**
 * Class RemoveImports
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveImports implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(Document & $styleDocument)
    {
        $toRemove = [];

        foreach ($styleDocument->getContents() as $content) {
            if ($content instanceof Import) {
                $toRemove[] = $content;
            }
        }

        array_walk($toRemove, [$styleDocument, 'remove']);
    }
}
