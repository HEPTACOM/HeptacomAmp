<?php declare(strict_types=1);

namespace HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\AmplifyStyle;

use HeptacomAmp\Components\DOMAmplifier\AmplifyDOM\IAmplifyStyle;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\Value\Size;

class RemoveUnitsOnNullValues implements IAmplifyStyle
{
    /**
     * Process and ⚡lifies the given node and style.
     *
     * @param Document $styleDocument the style to ⚡lify
     */
    public function amplify(Document &$styleDocument)
    {
        foreach ($styleDocument->getAllValues() as $value) {
            if ($value instanceof Size) {
                /** @var Size $value */
                if (!$value->isColorComponent() && $value->getSize() == 0) {
                    $value->setUnit(null);
                }
            }
        }
    }
}
