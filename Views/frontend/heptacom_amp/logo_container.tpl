{block name="frontend_heptacom_amp_logo_container"}
	<a href="{url controller='index'}" class="sw-logo-container">
		<amp-img
			layout="flex-item"
			src="{link file=$theme.mobileLogo}"
			srcset="{link file=$theme.desktopLogo} 1280w, {link file=$theme.tabletLandscapeLogo} 1024w, {link file=$theme.tabletLogo} 768w">
		</amp-img>
	</a>
{/block}
