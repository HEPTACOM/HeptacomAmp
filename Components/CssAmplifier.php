<?php

namespace HeptacomAmp\Components;

use HeptacomAmp\Components\CssAmplifier\Filter;
use Sabberworm\CSS\CSSList\KeyFrame;
use Sabberworm\CSS\Parser;
use Sabberworm\CSS\OutputFormat;
use Sabberworm\CSS\CSSList\Document;
use Sabberworm\CSS\CSSList\CSSList;
use Sabberworm\CSS\Property\Selector;
use Sabberworm\CSS\Rule\Rule;
use Sabberworm\CSS\RuleSet\AtRuleSet;
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
     * @var Filter
     */
    protected $filter;

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param $css
     * @return string
     */
    public function processCss($css)
    {
        $this->css = $css;
        $parser = new Parser($this->css);
        $this->parser = $parser->parse();

        $this->filter
            ->setKeyframe(true)
            ->setMedia(true)
            ->setPaths(true)
            ->setImportant(true);

        $this->applyFilters();

        return $this->parser->render(OutputFormat::createCompact());
    }

    public function applyFilters()
    {
        /** @var CSSList[] $contents */
        $contents = $this->parser->getContents();
        foreach ($contents as $list) {
            switch (true) {
                case ($list instanceof KeyFrame && $this->filter->isKeyframe()):
                    /** @var KeyFrame $list */
                    $this->parser->remove($list);
                    break;
                case ($list instanceof AtRuleBlockList && $this->filter->isMedia()):
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

        /** @var RuleSet[] $ruleSets */
        $ruleSets = $this->parser->getAllRuleSets();
        foreach ($ruleSets as $ruleSet) {
            switch (true) {
                case ($ruleSet instanceof DeclarationBlock):
                    /** @var DeclarationBlock $ruleSet */
                    /** @var Rule[] $rules */
                    $rules = $ruleSet->getRules();
                    foreach ($rules as $rule) {
                        if ($this->filter->isImportant()) {
                            $rule->setIsImportant(false);
                        }
                    }

                    $ruleSet->removeRule('-webkit-');
                    $ruleSet->removeRule('-moz-');
                    $ruleSet->removeRule('-ms-');
                    break;
                case ($ruleSet instanceof AtRuleSet):
                    /** @var AtRuleSet $ruleSet */
                    if ($ruleSet->atRuleName() == 'font-face') {
                        $rule = array_shift($ruleSet->getRules('font-family'));
                        $fontName = $rule->getValue();
                        if ($fontName != 'shopware') {
                            // this removes too much
                                // $this->parser->remove($ruleSet);
                        }
                    }
                    break;
            }
        }

        /** @var Value[] $values */
        $values = $this->parser->getAllValues();
        foreach ($values as $value) {
            switch (true) {
                case ($value instanceof URL && $this->filter->isPaths()):
                    /** @var URL $value */
                    $origPath = trim($value->getURL(), '\"');
                    $exploded = explode('?', $origPath);
                    $origPath = array_shift($exploded);
                    $params = empty($exploded) ? '' : '?' . array_shift($exploded);

                    $path = realpath(implode(DIRECTORY_SEPARATOR, [Shopware()->DocPath(), 'web', 'cache', $origPath]));
                    $path = implode(DIRECTORY_SEPARATOR, [
                        Shopware()->Front()->Request()->getBaseUrl(),
                        substr($path, strlen(Shopware()->DocPath()))
                    ]);
                    if (strpos($path, implode(DIRECTORY_SEPARATOR, ['frontend', '_public', 'src', 'fonts', 'shopware'])) !== false) {
                        $value->setURL(new CSSString($path . $params));
                    }
                    break;
            }
        }
    }
}
