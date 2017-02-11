{extends file="parent:frontend/plugins/heptacom_amp/listing/filter/facet-range.tpl"}

{block name="frontend_listing_filter_facet_range_slider_config"}
        {$startMin = $facet->getActiveMin()}
        {$startMax = $facet->getActiveMax()}
        {$rangeMin = $facet->getMin()}
        {$rangeMax = $facet->getMax()}
        {$roundPretty = 'true'}
        {$format = "{'0'|currency}"}
        {$stepCount = 100}
        {$stepCurve = 'linear'}
{/block}
