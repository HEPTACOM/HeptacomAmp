# Changelog

## 2.3.2

- Bugfix: Fixed bugs related to changes from Shopware 5.3 to 5.4

## 2.3.1

- Improvement: Moved new field for custom css to a separate tab to support themes that do not include the default tabs

## 2.3.0

- Feature: Optional debug mode. Now there is a debug AMP view useful for inspection
- Feature: New field in the theme configuration for custom css. (overrides all other css on AMP pages)
- Bugfix: Script tags used to be consideres AMP valid by mistake
- Bugfix: Added missing structured data for prices

## 2.2.0

- Feature Multishopsupport. The plugin can be activated for each subshop separately
- Feature Multishopsupport. The used AMP theme can be set for each subshop separately
- Feature Embed YouTube videos are converted to AMP
- Bugfix Deprecated font-tag is now converted into valid styles
- Bugfix Inline styles were not cleansed and could become invalid AMP style
- Bugfix There is now a template for missing products
- Bugfix Backend listed products that were not available
- Bugfix Adjusted relative URIs in stylesheets
- Bugfix Convert custom fonts into AMP valid styles
- Bugfix Ignore store login while validating/cache warming the AMP pages

## 2.1.11

- Bugfix: Category and custom pages had no content or threw an exception

## 2.1.10

- Feature: Added support for core plugin "Notification"
- Bugfix: Added missing support for customized article detail templates
- Bugfix: Rate link scrolls down to rating section
- Bugfix: Fixed issue where it was not possible to select multiple configurators (Github Issue #1)
- Bugfix: Fixed issue about resetting configurator selection (Github Issue #2)

## 2.1.9

- Bugfix: Loading several categories in parallel led to a unexpected reload of the Shopware backend

## 2.1.8

- Bugfix: Fixed incorrect article urls in the listing

## 2.1.7

- Bugfix: SQL-condition for cache-warmer preparation

## 2.1.6

- Remove usage of obsolete smarty modifier `rewrite`
- Match 'Add to cart' buttons to the latest shopware 5.3 snippets

## 2.1.5

- Improve performance in the backend module

## 2.1.4

- Remove license check
- Remove IonCube encryption
- Github Release

## 2.1.3

- Fix bug on unopenable description and cross selling tabs
- Fix bug on unopenable offcanvas menu

## 2.1.2

- Improve render performance by caching stylesheet optimizations (up to 110% faster; 85% of the previous time)
- Improve loading of third party components

## 2.1.1

- Fix error on loading categories with orphaned products

## 2.1.0

- Improve analysis on detecting active products
- Separate analysis by shops
- Separate analysis by categories

## 2.0.4

- Ignore inactive products on cache warming

## 2.0.3

- Remove illegal import rules
- Remove illegal `@import` rules

## 2.0.2

- Fix error on manufacturer pages

## 2.0.1

- Fix loading error in third party components
- Add ratings on product pages

## 2.0.0

- Restructure plugin
- Change AMP default theme to match more the default theme
- Add AMP components to support interaction features
- Improve AMP compatibility
- Add compression to improve loading on mobile devices
- Add less error correction
- Add analysis tool for AMP validity

## 1.0.5

- Add templating by adding a theme called `HeptacomAmp` and the files contained in `frontend/heptacom_amp`

## 1.0.4

- Add structured data

## 1.0.3

- Change in template structure

## 1.0.2

- Add compatibility to other major plugins in terms of templating

## 1.0.1

- Add compatibility to other major plugins in terms of functionality

## 1.0.0

- First release
