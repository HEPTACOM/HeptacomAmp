<style amp-custom>
	{include file="frontend/detail-amp/custom-style-icons.tpl"}
	{literal}
		@font-face
		{
			font-family: 'Open Sans';
			/* TODO determine right base URL */
			src: url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Light/OpenSans-Light.woff?___REVISION___') format('woff'),
			     url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Light/OpenSans-Light.ttf?___REVISION___') format('truetype');
			font-weight: 300;
			font-style: normal
		}

		@font-face
		{
			font-family: 'Open Sans';
			/* TODO determine right base URL */
			src: url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Regular/OpenSans-Regular.woff?___REVISION___') format('woff'),
			     url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Regular/OpenSans-Regular.ttf?___REVISION___') format('truetype');
			font-weight: normal;
			font-style: normal
		}

		@font-face
		{
			font-family: 'Open Sans';
			/* TODO determine right base URL */
			src: url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Semibold/OpenSans-Semibold.woff?___REVISION___') format('woff'),
			     url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Semibold/OpenSans-Semibold.ttf?___REVISION___') format('truetype');
			font-weight: 600;
			font-style: normal
		}

		@font-face 
		{
			font-family: 'Open Sans';
			/* TODO determine right base URL */
			src: url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Bold/OpenSans-Bold.woff?___REVISION___') format('woff'),
			     url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/Bold/OpenSans-Bold.ttf?___REVISION___') format('truetype');
			font-weight: bold;
			font-style: normal
		}

		@font-face
		{
			font-family: 'Open Sans';
			/* TODO determine right base URL */
			src: url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/ExtraBold/OpenSans-ExtraBold.woff?___REVISION___') format('woff'),
			     url('/shopware/themes/Frontend/Responsive/frontend/_public/vendors/fonts/open-sans-fontface/ExtraBold/OpenSans-ExtraBold.ttf?___REVISION___') format('truetype');
			font-weight: 800;
			font-style: normal
		}

		a
		{
			background-color: transparent;
			color: #d9400b;
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
			background: #fff;
			color: #5f7285;
			font-size: 14px;
			font-size: 0.875rem;
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
			font-size: 14px;
			font-size: .875rem;
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
			font-size: 14px;
			font-size: .875rem;
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

		.sw-block-group
		{
			
		}

		.sw-btn
		{
			appearance: none;
			background-clip: padding-box;
			background-color: #fff;
			background-image: -ms-linear-gradient(top, #fff, #f8f8fa);
			background-image: linear-gradient(to bottom, #fff 0%, #f8f8fa 100%);
			border: 1px solid #dadae5;
			border-radius: 3px;
			color: #5f7285;
			cursor: pointer;
			display: inline-block;
			font-size: 14px;
			font-size: .875rem;
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
			font-size: 10px;
			font-size: .625rem
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
			background-image: -ms-linear-gradient(top, #fff, #f8f8fa);
			background-image: linear-gradient(to bottom, #fff 0%, #f8f8fa 100%);
			border: 1px solid #dadae5;
		}

		.sw-btn:hover
		{
			background: #fff;
			border-color: #d9400b;
			color: #d9400b;
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
			background-color: #fa5d27;
			background-image: -ms-linear-gradient(top, #fa5d27, #d9400b);
			background-image: linear-gradient(to bottom, #fa5d27 0%, #d9400b 100%);
			border: 0 none;
			color: #fff;
			line-height: 34px;
			line-height: 2.125rem;
			padding: 2px 12px 2px 12px;
			padding: .125rem .75rem .125rem .75rem;
		}

		.sw-btn.is--primary:hover
		{
			background: #d9400b;
			color: #fff;
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
			
		}

		.sw-content--starting-from
		{
			
		}

		.sw-cross-selling
		{
			
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
			border-bottom: 1px solid #d9400b;
			margin: 0px -10px;
			padding: 10px;
			padding: .625rem;
		}

		.sw-header--navigation
		{
			
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
			color: #5f7285;
			cursor: not-allowed;
			opacity: .5;
		}

		.sw-is--hidden
		{
			
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

		.sw-navigation--entry
		{
			
		}

		.sw-navigation--link
		{
			
		}

		.sw-navigation--list
		{
			
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

		.sw-price--discount
		{
			
		}

		.sw-price--discount-icon
		{
			
		}

		.sw-price--discount-percentage
		{
			
		}

		.sw-price--label
		{
			
		}

		.sw-price--line-through
		{
			
		}

		.sw-price--unit
		{
			
		}

		.sw-product--buybox
		{
			
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
			background: #4aa3df
		}

		.product--delivery .delivery--text-shipping-free
		{
			color: #4aa3df
		}

		.product--delivery .delivery--status-available
		{
			background: #2ecc71
		}

		.product--delivery .delivery--text-available
		{
			color: #2ecc71
		}

		.product--delivery .delivery--status-more-is-coming
		{
			background: #f1c40f
		}

		.product--delivery .delivery--text-more-is-coming
		{
			color: #f1c40f
		}

		.product--delivery .delivery--status-not-available
		{
			background: #e74c3c
		}

		.product--delivery .delivery--text-not-available
		{
			color: #e74c3c
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
			color: #5f7285;
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

		.amp-carousel-button:active,
		.amp-carousel-button:focus,
		.amp-carousel-button:hover
		{
			border: 1px solid #d9400b;
			color: #d9400b;
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