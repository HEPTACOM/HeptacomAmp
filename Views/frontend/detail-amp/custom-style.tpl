<style amp-custom>
	{include file="frontend/detail-amp/custom-style-icons.tpl"}
	{literal}
		@font-face
		{
			font-family: 'Open Sans';
			{/literal}
			src: url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Light/OpenSans-Light.woff"}) format('woff'),
			     url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Light/OpenSans-Light.ttf"}) format('truetype');
			{literal}
			font-weight: 300;
			font-style: normal
		}

		@font-face
		{
			font-family: 'Open Sans';
			{/literal}
			src: url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Regular/OpenSans-Regular.woff"}) format('woff'),
			     url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Regular/OpenSans-Regular.ttf"}) format('truetype');
			{literal}
			font-weight: normal;
			font-style: normal
		}

		@font-face
		{
			font-family: 'Open Sans';
			{/literal}
			src: url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Semibold/OpenSans-Semibold.woff"}) format('woff'),
			     url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Semibold/OpenSans-Semibold.ttf"}) format('truetype');
			{literal}
			font-weight: 600;
			font-style: normal
		}

		@font-face 
		{
			font-family: 'Open Sans';
			{/literal}
			src: url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Bold/OpenSans-Bold.woff"}) format('woff'),
			     url({link file="frontend/_public/vendors/fonts/open-sans-fontface/Bold/OpenSans-Bold.ttf"}) format('truetype');
			{literal}
			font-weight: bold;
			font-style: normal
		}

		@font-face
		{
			font-family: 'Open Sans';
			{/literal}
			src: url({link file="frontend/_public/vendors/fonts/open-sans-fontface/ExtraBold/OpenSans-ExtraBold.woff"}) format('woff'),
			     url({link file="frontend/_public/vendors/fonts/open-sans-fontface/ExtraBold/OpenSans-ExtraBold.ttf"}) format('truetype');
			{literal}
			font-weight: 800;
			font-style: normal
		}

		a
		{
			background-color: transparent;
			color: {/literal}{$theme["brand-primary"]}{literal};
			text-decoration: none;
		}

		a:hover,
		a:focus,
		a:active
		{
			outline: 0;
		}

		body
		{
			background: {/literal}{$theme["panel-bg"]}{literal};
			color: {/literal}{$theme["brand-secondary"]}{literal};
			font-size: {/literal}{$theme["font-size-base"]}{literal}px;
			font-size: {/literal}{intval($theme["font-size-base"])/16.0}{literal}rem;
			font-weight: 500;
			padding: 0px 10px 10px 10px;
			text-rendering: optimizeLegibility;
			-webkit-font-smoothing: antialiased;
		}

		body, button, input, p, div, span, li
		{
			font-family: {/literal}{$theme["font-base-stack"]}{literal};
		}

		h1
		{
			color: #3f4c58;
			font-size: 21px;
			font-size: 1.3125rem;
			font-weight: bold;
			line-height: 28px;
			line-height: 1.75rem;
			margin: 0;
			padding: 0;
		}

		p
		{
			font-size: {/literal}{$theme["label-font-size"]}{literal}px;
			font-size: {/literal}{intval($theme["label-font-size"])/16.0}{literal}rem;
			line-height: 24px;
			line-height: 1.5rem;
			margin: 0px 0px 20px 0px;
			margin: 0rem 0rem 1.25rem 0rem;
		}

		ul
		{
			margin: 0;
			padding: 0;
		}

		/*textarea, not supported*/
		input[type="text"],
		input[type="search"],
		/*input[type="password"], not supported*/
		input[type="number"],
		input[type="email"],
		input[type="tel"]
		{
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			background: #f8f8fa;
			background-clip: padding-box;
			border: 1px solid #dadae5;
			border-radius: 3px;
			border-top-color: #cbcbdb;
			box-shadow: inset 0 1px 1px #dadae5;
			box-sizing: border-box;
			color: #8798a9;
			font-size: {/literal}{$theme["input-font-size"]}{literal}px;
			font-size: {/literal}{intval($theme["input-font-size"])/16.0}{literal}rem;
			line-height: 19px;
			line-height: 1.1875rem;
			padding: 10px 10px 9px 10px;
			padding: .625rem .625rem .5625rem .625rem;
			text-align: left;
			width: 290px;
			width: 18.125rem;
		}

		.icon--shopware
		{
			background: #f0f;
			color: #009fe3;
			font-size: 28px;
			font-size: 1.75rem;
		}

		.slide
		{
			
		}

		.sw-article-name
		{
			
		}

		.amp-carousel.sw-article-images
		{
			margin: 0 -10px 20px;
		}

		.amp-carousel.sw-article-images .slide
		{
			margin-left: 10px;
			margin-right: 10px;
		}

		.sw-block-group
		{
			
		}

		.sw-btn
		{
			appearance: none;
			background-clip: padding-box;
			background-color: {/literal}{$theme["btn-default-top-bg"]}{literal};
			border: 1px solid #dadae5;
			border-radius: 3px;
			color: {/literal}{$theme["brand-secondary"]}{literal};
			cursor: pointer;
			display: inline-block;
			font-size: {/literal}{$theme["btn-font-size"]}{literal}px;
			font-size: {/literal}{intval($theme["btn-font-size"])/16.0}{literal}rem;
			font-weight: bold;
			line-height: 32px;
			line-height: 2rem;
			padding: 2px 10px;
			padding: .125rem .625rem;
			position: relative;
			text-decoration: none;
			text-align: left;
			-moz-appearance: none;
			-webkit-appearance: none;
			-webkit-font-smoothing: inherit;
		}

		.sw-btn [class^="icon--"]
		{
			font-size: {/literal}{$theme["btn-icon-size"]}{literal}px;
			font-size: {/literal}{intval($theme["btn-icon-size"])/16.0}{literal}rem
		}

		.sw-btn.is--large
		{
			font-size: 16px;
			font-size: 1rem
		}

		.sw-btn .is--icon-right
		{
			padding-right: 36px;
			padding-right: 2.25rem
		}

		.sw-btn.sw-is--icon-right [class^="icon--"]
		{
			display: block;
			font-weight: normal;
			height: 16px;
			height: 1rem;
			line-height: 32px;
			line-height: 2rem;
			margin: -16px 0px 0px 0px;
			margin: -1rem 0rem 0rem 0rem;
			position: absolute;
			right: 12px;
			right: .75rem;
			top: 50%
		}

		.sw-btn.sw-is--icon-left
		{
			padding-left: 36px;
			padding-left: 2.25rem
		}

		.sw-btn.sw-is--icon-left [class^="icon--"]
		{
			display: block;
			font-weight: normal;
			height: 16px;
			height: 1rem;
			left: 12px;
			left: .75rem;
			line-height: 32px;
			line-height: 2rem;
			margin: -16px 0px 0px 0px;
			margin: -1rem 0rem 0rem 0rem;
			position: absolute;
			top: 50%
		}

		.sw-btn:disabled,
		.sw-btn:disabled:hover,
		.sw-btn.sw-is--disabled,
		.sw-btn.sw-is--disabled:hover
		{
			border: 1px solid #dadae5;
		}

		.sw-btn:hover
		{
			background: {/literal}{$theme["btn-default-hover-bg"]}{literal};
			border-color: {/literal}{$theme["brand-primary"]}{literal};
			color: {/literal}{$theme["brand-primary"]}{literal};
		}

		.sw-btn:focus
		{
		    outline: none;
		}

		.sw-btn.is--full
		{
			display: block;
		}

		.sw-btn.sw-is--primary
		{
			background-color: {/literal}{$theme["brand-primary"]}{literal};
			border: 0 none;
			color: {/literal}{$theme["btn-primary-text-color"]}{literal};
			line-height: 34px;
			line-height: 2.125rem;
			padding: 2px 12px 2px 12px;
			padding: .125rem .75rem .125rem .75rem;
		}

		.sw-btn.is--primary:hover
		{
			background: #d9400b;
			color: {/literal}{$theme["btn-primary-text-color"]}{literal};
		}

		.sw-buybox--button,
		.sw-quantity--select
		{
			font-size: 16px;
			font-size: 1rem;
			height: 42px;
			height: 2.625rem;
			line-height: 38px;
			line-height: 2.375rem;
			white-space: nowrap;
		}

		.sw-buybox--button
		{
			width: 63%;
		}

		.sw-buybox--button-configure
		{
			box-sizing: border-box;
			height: auto;
			width: 100%;
		}

		.sw-buybox--quantity
		{
			display: inline-block;
			width: 33%;
		}

		.sw-buybox--button-container
		{
			
		}

		.sw-buybox--form
		{
			
		}

		.sw-categories--navigation
		{
			
		}

		.sw-content--default
		{
			
		}

		.sw-content--discount
		{
			display: inline-block;
			font-size: 14px;
			font-size: .875rem;
			padding: 4px 0px 4px 0px;
			padding: .25rem 0rem .25rem 0rem;
			white-space: nowrap;
		}

		.sw-content--starting-from
		{
			
		}

		.sw-cross-selling img
		{
			object-fit: contain;
		}

		.sw-cross-selling-header
		{
			border-bottom: 1px solid #dadae5;
			color: #3f4c58;
			display: block;
			font-size: 16px;
			font-size: 1rem;
			font-weight: bold;
			padding: 10px 0px;
			padding: .625rem 0rem;
		}

		.sw-discount
		{
			
		}

		.sw-footer
		{
			
		}

		.sw-footer--copyright
		{
			font-size: 13px;
			font-size: .8125rem;
			text-align: center;
		}

		.sw-footer--service-menu
		{
			list-style-type: none;
			margin: 0;
			padding: 0;
			text-align: center;
		}

		.sw-footer--service-menu li.service--entry
		{
			display: inline-block;
			font-size: 13px;
			font-size: .8125rem;
			padding: 0px 2px;
			padding: .5rem .125rem;
		}

		.sw-footer--service-menu li.service--entry:after
		{
			border-left: 1px solid #bcbcd0;
			content: '';
			display: inline-block;
			height: 10px;
			height: .625rem;
			margin: 0px 5px;
			margin: 0rem .3125rem;
			width: 1px;
			width: .0625rem;
		}

		.sw-footer--service-menu li.service--entry:last-child:after
		{
			display: none;
		}

		.sw-footer--vat-info,
		.sw-vat-info--text
		{
			font-size: 12px;
			font-size: .75rem;
			margin-bottom: 10px;
			margin-bottom: .625rem;
			text-align: center;
		}

		.sw-has--sub-categories
		{
			
		}

		.sw-header-main
		{
			border-bottom: 1px solid {/literal}{$theme["brand-primary"]}{literal};
			margin: 0px -10px;
			padding: 10px;
			padding: .625rem;
		}

		/* TODO this does not affect the menu buttons!? */
		.sw-header--navigation
		{
			display: table;
			font-size: 20px;
			font-size: 1.25rem;
		}

		.sw-header--navigation-item
		{
			box-sizing: border-box;
			display: table-cell;
			white-space: nowrap;
			width: 100%;
		}

		.sw-header--navigation-item.sw-header--navigation-item--btn
		{
			width: auto;
			padding-right: 10px;
		}

		.sw-is--active
		{
			
		}

		.sw-is--center
		{
			text-align: center;
		}

		.sw-is--disabled,
		.sw-is--disabled:hover
		{
			background-color: #fff;
			color: {/literal}{$theme["brand-secondary"]}{literal};
			cursor: not-allowed;
			opacity: .5;
		}

		.sw-is--hidden
		{
			opacity: 0;
			visibility: hidden;
		}

		.sw-is--level0
		{
			
		}

		.sw-label--purchase-unit
		{
			
		}

		.sw-logo-container
		{
			display: flex;
			height: 40px;
			width: 100%;
		}

		.sw-logo-container img
		{
			object-fit: contain;
			object-position: 0% 50%;
		}

		.sw-main-search-form
		{
			border-bottom: 0 none;
			padding: 0;
		}

		.sw-main-search-form input[type="search"]
		{
			height: 40px;
			height: 2.5rem;
			padding: 9px 38px 9px 9px;
			padding: .5625rem 2.375rem .5625rem .5625rem;
			position: relative;			
			vertical-align: middle;
			width: 100%;
		}

		#offcanvas-menu
		{
			border-right: 2px solid #dadae5;
			min-width: 260px;
			width: 260px;
		}

		.sw-navigation--entry.sw-entry--close-off-canvas
		{
			background-color: {/literal}{$theme["brand-secondary"]}{literal};
			border: none;
			border-radius: 0px;
			color: #f8f8fa;
			font-size: {/literal}{$theme["panel-header-font-size"]}{literal}px;
			font-size: {/literal}{intval($theme["panel-header-font-size"])/16.0}{literal}rem;
			font-weight: bold;
			padding: 2px 10px 2px 10px;
			padding: .125rem .625rem .125rem .625rem;
		}

		.sw-navigation--entry
		{
			border-bottom: 1px solid #dadae5;
			display: block;
			font-size: {/literal}{$theme["panel-header-font-size"]}{literal}px;
			font-size: {/literal}{intval($theme["panel-header-font-size"])/16.0}{literal}rem;
			font-weight: bold;	
			line-height: 38px;
			line-height: 2.375rem;
			position: relative;
		}

		.sw-navigation--link
		{
			color: {/literal}{$theme["brand-secondary"]}{literal};
			height: 100%;
			overflow: hidden;
			padding: 2px 10px 2px 10px;
			padding: .125rem .625rem .125rem .625rem;
			text-overflow: ellipsis;
			width: 100%;
		}

		.sw-navigation--list
		{
			background: {/literal}{$theme["panel-bg"]}{literal};
			border-top: 1px solid #dadae5;
		    box-sizing: border-box;
		}

		.sw-navigation--entry > .sw-navigation--list
		{
			border-left: 1px solid #dadae5;
			margin-left: 10px;
		}

		.sw-navigation--entry > .sw-navigation--list > .sw-navigation--entry:last-child
		{
			border-bottom: none;
		}

		.sw-price
		{
			
		}

		.sw-price--content
		{
			color: #3f4c58;
			display: inline-block;
			font-size: 28px;
			font-size: 1.75rem;
			font-weight: bold;
			line-height: 1;
			white-space: nowrap;
		}

		.sw-price--default
		{
			
		}

		.sw-price--discount .sw-price--content
		{
			color: #e74c3c;
		}

		.sw-price--discount-icon
		{
			background: #e74c3c;
			border-radius: 3px;
			border-radius: .1875rem;
			color: #fff;
			display: inline-block;
			font-size: 13px;
			font-size: .8125rem;
			font-weight: bold;
			margin: 0px 5px 0px 5px;
			margin: 0rem .3125rem 0rem .3125rem;
			padding: 6px 7px 6px 7px;
			padding: .375rem .4375rem .375rem .4375rem;
			position: relative;
			text-align: center;
			vertical-align: top;
		}

		.sw-price--discount-percentage
		{
			
		}

		.sw-price--label
		{
			
		}

		.sw-price--line-through
		{
			text-decoration: line-through;
		}

		.sw-price--unit
		{
			
		}

		.sw-product--buybox
		{
			
		}

		.sw-product--configurator-variant-group form
		{
			box-sizing: border-box;
			display: inline-block;
			margin-right: 2%;
			margin-bottom: 10px;
			margin-bottom: .625rem;
			overflow: hidden;
			width: 22%;
		}

		.sw-product--configurator-variant-group form input[type=submit]
		{
			width: 100%;
		}

		.sw-product--configurator-variant-name
		{
			clear: both;
			font-weight: bold;
			margin: 0px 0px 5px 0px;
			margin: 0rem 0rem .3125rem 0rem;
		}

		.product--delivery .delivery--status-icon
		{
			background-clip: padding-box;
			border-radius: .5625rem;
			display: inline-block;
			height: 9px;
			height: .5625rem;
			line-height: 10px;
			line-height: .625rem;
			margin: 0px 5px 0px 0px;
			margin: 0rem .3125rem 0rem 0rem;
			position: relative;
			width: 9px;
			width: .5625rem;
		}

		.product--delivery .delivery--status-shipping-free
		{
			background: {/literal}{$theme["highlight-info"]}{literal}
		}

		.product--delivery .delivery--text-shipping-free
		{
			color: {/literal}{$theme["highlight-info"]}{literal}
		}

		.product--delivery .delivery--status-available
		{
			background: {/literal}{$theme["highlight-success"]}{literal}
		}

		.product--delivery .delivery--text-available
		{
			color: {/literal}{$theme["highlight-success"]}{literal}
		}

		.product--delivery .delivery--status-more-is-coming
		{
			background: {/literal}{$theme["highlight-notice"]}{literal}
		}

		.product--delivery .delivery--text-more-is-coming
		{
			color: {/literal}{$theme["highlight-notice"]}{literal}
		}

		.product--delivery .delivery--status-not-available
		{
			background: {/literal}{$theme["highlight-error"]}{literal}
		}

		.product--delivery .delivery--text-not-available
		{
			color: {/literal}{$theme["highlight-error"]}{literal}
		}

		.sw-product--title
		{
			padding: 10px 0;
		}

		.sw-product--details
		{
			
		}

		.sw-product--price
		{
			float: left;
			margin: 0;			
			max-width: 50%;
			padding: 0;
			width: 50%;
		}

		.sw-product--supplier
		{
			float: right;
			margin: 0;			
			max-width: 50%;
			padding: 0;
			width: 50%;
		}
		
		.sw-product--supplier img
		{
			object-fit: contain;
			object-position: 100% 50%;
		}

		.sw-product--supplier:after
		{
			clear: both;
		}

		.sw-product--supplier-link
		{
			
		}

		.alert--icon,
		.alert--content
		{
			display: inline-block;
		}

		.sw-product--tax
		{
			font-size: 12px;
			font-size: .75rem;
			margin: 0;
		}

		.sw-sidebar--navigation
		{
			
		}

		.amp-carousel-button
		{
			color: {/literal}{$theme["brand-secondary"]}{literal};
			background: rgba(255,255,255,0.8);
			border: 1px solid #dadae5;
			font-family: 'shopware';
			font-size: 12px;
			font-size: .75rem;
			height: 60px;
			height: 3.75rem;
			line-height: 60px;
			line-height: 3.75rem;
			opacity: 1;
			text-align: center;
			visibility: visible;
			width: 30px;
			width: 1.875rem;
		}

		.amp-carousel-button.amp-carousel-button-next,
		.amp-carousel-button.amp-carousel-button-prev
		{
			-ms-animation: none;
			-moz-animation: none;
			-webkit-animation: none;
			-o-animation: none;
			animation: none;
			-ms-transition: none;
			-moz-transition: none;
			-webkit-transition: none;
			-o-transition: none;
			transition: none;
		}

		.amp-carousel-button:active,
		.amp-carousel-button:focus,
		.amp-carousel-button:hover
		{
			border: 1px solid {/literal}{$theme["brand-primary"]}{literal};
			color: {/literal}{$theme["brand-primary"]}{literal};
		}

		.amp-carousel-button-prev
		{
			border-radius: 0px;
			border-bottom-right-radius: 3px;
			border-top-right-radius: 3px;
			left: 0px;
		}

		.amp-carousel-button-prev:before
		{
			content: "\e611";
		}

		.amp-carousel-button-next
		{
			border-radius: 0px;
			border-bottom-left-radius: 3px;
			border-top-left-radius: 3px;
			right: 0px;
		}

		.amp-carousel-button-next:before
		{
			content: "\e60f";
		}
	{/literal}
</style>