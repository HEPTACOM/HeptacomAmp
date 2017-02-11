{if $facet->getLabel()}
    <h3 class="filter--set-title">{$facet->getLabel()|escape}</h3>
{/if}
{include file="frontend/plugins/heptacom_amp/listing/actions/action-filter-facets.tpl" facets=$facet->getFacetResults()}
