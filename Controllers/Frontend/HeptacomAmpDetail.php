<?php

class Shopware_Controllers_Frontend_HeptacomAmpDetail extends Shopware_Controllers_Frontend_Detail
{
    public function preDispatch()
    {
        if ($this->Request()->getParam('heptacom_amp_redirect')) {
            if ($this->Request()->getActionName() == 'index') {
                $this->redirect([
                    'controller' => 'detail',
                    'action' => 'index',
                    'sArticle' => (int)$this->Request()->get('sArticle'),
                    'amp' => 1,
                ]);
            }
        }

        parent::preDispatch();
    }

    public function indexAction()
    {
        $this->View()->loadTemplate(implode(DIRECTORY_SEPARATOR, ['frontend', 'plugins', 'heptacom_amp', 'detail', 'index.tpl']));
        // $this->View()->assign('ampSchemaOrgProduct', static::sArticleToSchemaOrgProduct($this->getSArticle()));

        parent::indexAction();
    }

    /**
     * @return array
     */
    private function getSArticle()
    {
        $id = (int) $this->Request()->get('sArticle');
        $number = $this->Request()->getParam('number', null);
        $selection = $this->Request()->getParam('group', []);

        return Shopware()->Modules()->Articles()->sGetArticleById($id, null, $number, $selection);
    }

    /**
     * @param $sImage
     * @return array
     */
    private static function sImageToSchemaOrgImage($sImage)
    {
        $result = [
            '@context' => 'http://schema.org',
            '@type' => 'ImageObject'
        ];

        if (!empty($sImage)) {
            if (array_key_exists('source', $sImage)) {
                $result['url'] = $result['contentUrl'] = $sImage['source'];
            }

            if (array_key_exists('width', $sImage)) {
                $result['width'] = $sImage['width'];
            }

            if (array_key_exists('height', $sImage)) {
                $result['height'] = $sImage['height'];
            }

            if (array_key_exists('description', $sImage)) {
                $result['description'] = $sImage['description'];
            }

            if (array_key_exists('thumbnails', $sImage)
                && is_array($sImage['thumbnails'])
                && !empty($sImage['thumbnails'])) {

                $thumbnail = [
                    '@context' => 'http://schema.org',
                    '@type' => 'ImageObject'
                ];

                if (array_key_exists('source', $sImage['thumbnails'][0])) {
                    $thumbnail['url'] = $thumbnail['contentUrl'] = $sImage['thumbnails'][0]['source'];
                }

                if (array_key_exists('maxWidth', $sImage['thumbnails'][0])) {
                    $thumbnail['width'] = $sImage['thumbnails'][0]['maxWidth'];
                }

                if (array_key_exists('maxHeight', $sImage['thumbnails'][0])) {
                    $thumbnail['height'] = $sImage['thumbnails'][0]['maxHeight'];
                }

                if (count($thumbnail) > 2) {
                    $result['thumbnail'] = $thumbnail;
                }
            }
        }

        return count($result) == 2 ? [] : $result;
    }

    /**
     * @param $sArticle
     * @return array
     */
    private static function schemaOrgBrandFromSArticle($sArticle)
    {
        $result = [
            '@context' => 'http://schema.org',
            '@type' => 'Brand'
        ];

        if (array_key_exists('supplierName', $sArticle)) {
            $result['name'] = $sArticle['supplierName'];
        }

        if (array_key_exists('supplierImg', $sArticle)) {
            $result['image'] = $sArticle['supplierImg'];
        }

        if (array_key_exists('supplierDescription', $sArticle)) {
            $result['description'] = $sArticle['supplierDescription'];
        }

        return count($result) == 2 ? [] : $result;
    }

    /**
     * @param $sArticle
     * @return array
     */
    private static function schemaOrgOfferFromSArticle($sArticle)
    {
        $result = [
            '@context' => 'http://schema.org',
            '@type' => 'Offer'
        ];

        if (array_key_exists('price_numeric', $sArticle)) {
            $result['price'] = $sArticle['price_numeric'];
            $result['priceCurrency'] = Shopware()->Shop()->getCurrency()->getCurrency();
        }

        return count($result) == 2 ? [] : $result;
    }

    /**
     * @param $sArticle
     * @return array
     */
    private static function sArticleToSchemaOrgProduct($sArticle)
    {
        $result = [
            '@context' => 'http://schema.org',
            '@type' => 'Product'
        ];

        $result['productID'] = $sArticle['ordernumber'];
        $result['name'] = $sArticle['articleName'];

        $result['url'] = Shopware()->Front()->Router()->assemble([
            'controller' => 'heptacomAmpDetail',
            'action' => 'index',
            'sArticle' => $sArticle['articleID']
        ]);
        $result['sameAs'] = Shopware()->Front()->Router()->assemble([
            'controller' => 'detail',
            'action' => 'index',
            'sArticle' => $sArticle['articleID']
        ]);

        if (array_key_exists('description_long', $sArticle)) {
            $result['description'] = strip_tags($sArticle['description_long']);
        }

        if (array_key_exists('description', $sArticle)) {
            $result['disambiguatingDescription'] = $sArticle['description'];
        }

        if (array_key_exists('image', $sArticle)) {
            $image = static::sImageToSchemaOrgImage($sArticle['image']);

            if (!empty($image)) {
                $result['image'] = $image;
            }
        }

        $brand = static::schemaOrgBrandFromSArticle($sArticle);

        if (!empty($brand)) {
            $result['brand'] = $brand;
        }

        $offer = static::schemaOrgOfferFromSArticle($sArticle);

        if (!empty($offer)) {
            $result['offers'] = $offer;
        }

        return $result;
    }
}
