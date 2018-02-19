<?php

namespace HeptacomAmp\Services\Smarty;

/**
 * BlockAnnotator annotates smarty block with HTML comments, so you can tell which content belongs to which block.
 *
 * @author Daniel Nögel <d.noegel@shopware.com>
 * @internal Taken from https://github.com/shyim/shopware-profiler/ and modified
 */
class BlockAnnotator
{
    /**
     * @var BlockSplitter
     */
    private $blockSplitter;

    /**
     * BlockAnnotator constructor.
     *
     * @param BlockSplitter $blockSplitter
     */
    public function __construct(BlockSplitter $blockSplitter)
    {
        $this->blockSplitter = $blockSplitter;
    }

    /**
     * Do not append block info to blacklisted blocks (e.g. JS, CSS).
     *
     * @var array
     */
    protected $blacklist = [
        'frontend_index_header_title',
        'frontend_robots_txt',
        'frontend_robots_txt_user_agent',
        'frontend_robots_txt_disallows',
        'frontend_robots_txt_allows',
        'frontend_robots_txt_sitemap',
        'frontend_robots_txt_sitemap_mobile',
        'frontend_index_body_attributes'
    ];

    /**
     * @param $source
     * @param $template
     * @return string
     */
    public function annotate($source, $template)
    {
        foreach ($this->blockSplitter->split($source) as $block) {
            if (in_array($block['name'], $this->blacklist) ||
                strpos($block['name'], '/attributes') !== false ||
                strpos($block['name'], 'classes') !== false ||
                strpos($block['name'], 'frontend_index_search_similar_results_') !== false) {
                continue;
            }

            $templateResources = explode('|', $template->template_resource);

            $currentFile = $template->_current_file;

            // smarty eval
            if (0 === strpos($templateResources[0], 'string:')) {
                $templateResources = [];
            }

            if (count($templateResources) > 1 && strpos($currentFile, $templateResources[0]) === false) {
                $currentFile = $templateResources[0];
            }

            $info = $block['name'];
            $start = "<!-- BLOCK BEGIN {$info}, File: {$currentFile} -->";
            $end = "<!-- BLOCK END {$info} -->";

            $source = str_replace($block['content'], $block['beginBlock'] . $start . $block['contentOnly'] . $end . $block['endBlock'], $source);
        }

        return $source;
    }
}
