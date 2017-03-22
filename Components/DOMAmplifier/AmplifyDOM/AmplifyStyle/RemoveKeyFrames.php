<?php

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\CSSList\KeyFrame;

/**
 * Class RemoveKeyFrames
 * @package HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle
 */
class RemoveKeyFrames implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     * @param Document $styleDocument The style to ⚡lify.
     */
    function amplify(Document& $styleDocument)
    {
        foreach ($styleDocument->getContents() as $list) {
            if ($list instanceof KeyFrame) {
                $styleDocument->remove($list);
            }
        }
    }
}
