<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Property\Import;

class RemoveImports implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(Document &$styleDocument)
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
