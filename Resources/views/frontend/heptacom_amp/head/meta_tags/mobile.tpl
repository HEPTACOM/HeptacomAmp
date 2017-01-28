{block name='frontend_heptacom_amp_head_meta_tags_mobile'}
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="{if $theme.appleWebAppTitle != ''}{$theme.appleWebAppTitle|escapeHtml}{else}{{config name=sShopname}|escapeHtml}{/if}">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
{/block}
