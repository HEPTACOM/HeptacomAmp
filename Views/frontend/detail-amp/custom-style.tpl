<style amp-custom>
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
			font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
			font-size: 14px;
			font-size: 0.875rem;
			font-weight: 500;
			padding: 0px 10px 10px 10px;
			text-rendering: optimizeLegibility;
			-webkit-font-smoothing: antialiased;
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

		/* TODO The paragraph style seems to override the footer style */
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

		.icon--arrow-right
		{
			background: #f0f;
			display: inline-block;
			height: 16px;
			width: 16px;
		}

		.icon--menu
		{
			background: #f0f;
			display: inline-block;
			height: 16px;
			width: 16px;
		}

		.icon--percent2
		{
			background: #f0f;
			display: inline-block;
			height: 16px;
			width: 16px;
		}

		.icon--search
		{
			background: #f0f;
			display: inline-block;
			height: 16px;
			width: 16px;
		}

		.icon--shopware
		{
			background: #f0f;
			color: #009fe3;
			display: inline-block;
			font-size: 28px;
			font-size: 1.75rem;
			height: 16px;
			width: 16px;
		}

		.sw-quantity--select
		{
			
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

		button,
		input[type=submit],
		input[type=button],
		select,
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

		.sw-buybox--button
		{
			
		}

		.sw-buybox--button-container
		{
			
		}

		.sw-buybox--form
		{
			
		}

		.sw-buybox--quantity
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

		.sw-footer--vat-info
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
			
		}

		.sw-is--disabled
		{
			
		}

		.sw-is--hidden
		{
			
		}

		.sw-is--icon-right
		{
			
		}

		.sw-is--large
		{
			
		}

		.sw-is--level0
		{
			
		}

		.sw-is--primary
		{
			
		}

		.sw-label--purchase-unit
		{
			
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

		.sw-vat-info--text
		{
			
		}
	{/literal}
</style>