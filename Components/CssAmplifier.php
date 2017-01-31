<?php

namespace HeptacomAmp\Components;

use Sabberworm\CSS\CSSList\KeyFrame;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\OutputFormat;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\CSSList\CSSList;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\DeclarationBlock;
use Sabberworm\CSS\RuleSet\RuleSet;
use Sabberworm\CSS\Value\CSSString;
use Sabberworm\CSS\Value\URL;
use Sabberworm\CSS\Value\Value;
use Sabberworm\CSS\CSSList\AtRuleBlockList;

class CssAmplifier
{
    /**
     * @var string
     */
    protected $css;

    /**
     * @var Document
     */
    protected $parser;

    /**
     * @param $css
     * @return string
     */
    public function processCss($css)
    {
        $this->css = $css;
        $parser = new Parser($this->css);
        $this->parser = $parser->parse();

        $this->removeMediaQueries();
        $this->rewritePaths();
        $this->removeDisallowedStyles();

        return $this->parser->render(OutputFormat::createCompact());
    }

    protected function removeMediaQueries()
    {
        /** @var CSSList[] $contents */
        $contents = $this->parser->getContents();

        foreach ($contents as $list) {
            switch (true) {
                case ($list instanceof KeyFrame):
                    /** @var KeyFrame $list */
                    $this->parser->remove($list);
                    break;
                case ($list instanceof AtRuleBlockList):
                    /** @var AtRuleBlockList $list */
                    if ($list->atRuleName() != 'media') {
                        continue;
                    }
                    if (strpos($list->atRuleArgs(), 'min-width') !== false) {
                        $this->parser->remove($list);
                    }
                    break;
            }
        }
    }

    protected function rewritePaths()
    {
        /** @var Value[] $values */
        $values = $this->parser->getAllValues();

        foreach ($values as $value) {
            if (!($value instanceof URL)) {
                continue;
            }
            /** @var URL $value */
            $origPath = trim($value->getURL(), '\"');
            $origPath = array_shift(explode('?', $origPath));

            $path = realpath(implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'web', 'cache', $origPath]));
            $path = implode(DIRECTORY_SEPARATOR, [
                Shopware()->Front()->Request()->getBaseUrl(),
                substr($path, strlen(Shopware()->DocPath()))
            ]);

            if (strpos($path, implode(DIRECTORY_SEPARATOR, ['frontend', '_public', 'src', 'fonts', 'shopware'])) !== false) {
                $value->setURL(new CSSString($path));
            }
        }
    }

    protected function removeDisallowedStyles()
    {
        /** @var RuleSet[] $ruleSets */
        $ruleSets = $this->parser->getAllRuleSets();
        foreach ($ruleSets as $ruleSet) {
            if (!($ruleSet instanceof DeclarationBlock)) {
                continue;
            }

            /** @var DeclarationBlock $ruleSet */
            /** @var Rule[] $rules */
            $rules = $ruleSet->getRules();
            foreach ($rules as $rule) {
                $rule->setIsImportant(false);

                /** @var Selector[] $selectors */
                /*
                $selectors = $ruleSet->getSelectors();
                $regex = '/(?=(\*)(?!=))/';
                foreach ($selectors as $selector) {
                    preg_match_all($regex, $selector->getSelector(), $matches);

                    if ($matches[1][0] == '*') {
                        $ruleSet->removeRule($rule);
                    }
                }
                */
            }
        }
    }
}
