<?php

/**
 * Generated with:
 * find vendor -name '*.php' |
 * grep -v ^vendor/composer |
 * grep -v /tests/ |
 * grep -v /test-cases/ |
 * grep -v example\.php |
 * grep -v autoload |
 * grep -v /unit-tests/ |
 * grep -v demo\.php |
 * grep -v /plugins/
 * grep -v Server/
 *
 * Adjusted order by class not found exceptionds
 */

require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Renderable.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Comment/Comment.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Comment/Commentable.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/CSSList/CSSList.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/CSSList/CSSBlockList.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Property/AtRule.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Property/Charset.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Property/Selector.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Property/Import.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Property/CSSNamespace.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/CSSList/KeyFrame.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/CSSList/Document.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/CSSList/AtRuleBlockList.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Rule/Rule.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/Value.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/PrimitiveValue.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/CSSString.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/ValueList.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/RuleValueList.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/CSSFunction.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/Color.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/URL.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Value/Size.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/OutputFormat.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Parser.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Settings.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/RuleSet/RuleSet.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/RuleSet/DeclarationBlock.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/RuleSet/AtRuleSet.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Parsing/SourceException.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Parsing/UnexpectedTokenException.php");
require_once(__DIR__ . "/vendor/sabberworm/php-css-parser/lib/Sabberworm/CSS/Parsing/OutputException.php");

if (!class_exists('Symfony\Component\CssSelector\CssSelectorConverter')) {
    require_once(__DIR__ . "/vendor/symfony/css-selector/Exception/ExceptionInterface.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Exception/ParseException.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Exception/ExpressionErrorException.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Exception/InternalErrorException.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Exception/SyntaxErrorException.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/NodeInterface.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/AbstractNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/PseudoNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/SelectorNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/CombinedSelectorNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/HashNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/AttributeNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/Specificity.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/ClassNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/FunctionNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/ElementNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Node/NegationNode.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Token.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/ParserInterface.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Parser.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Shortcut/HashParser.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Shortcut/ClassParser.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Shortcut/EmptyStringParser.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Shortcut/ElementParser.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Handler/HandlerInterface.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Handler/IdentifierHandler.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Handler/CommentHandler.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Handler/StringHandler.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Handler/NumberHandler.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Handler/HashHandler.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Handler/WhitespaceHandler.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Tokenizer/TokenizerPatterns.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Tokenizer/TokenizerEscaping.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Tokenizer/Tokenizer.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/TokenStream.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/Parser/Reader.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/CssSelectorConverter.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/ExtensionInterface.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/AbstractExtension.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/HtmlExtension.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/FunctionExtension.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/AttributeMatchingExtension.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/PseudoClassExtension.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/NodeExtension.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Extension/CombinationExtension.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/XPathExpr.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/TranslatorInterface.php");
    require_once(__DIR__ . "/vendor/symfony/css-selector/XPath/Translator.php");
}