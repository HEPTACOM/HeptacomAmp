<?php

/**
 * Frontend controller
 */
class Shopware_Controllers_Frontend_HeptacomAmpDetail extends Shopware_Controllers_Frontend_Detail
{
    public function indexAction()
    {
        parent::indexAction();

        $this->View()->Engine()->template_class = 'Shopware\\HeptacomAmp\\Template\\HeptacomAmp';

        $this->View()->setTemplateDir(
            array(
                Shopware()->DocPath() . '/themes/Frontend/Bare',
                Shopware()->DocPath() . '/themes/Frontend/Responsive',
                __DIR__ . '/../../Views'
            )
        );
        $this->View()->loadTemplate('frontend/heptacom_amp/index.tpl');
        // TODO Variablennamen verbesse
        $this->View()->assign('ampSchemaOrgProduct', self::_sArticleToSchemaOrgProduct($this->_getSArticle()));
    }

    private function _getSArticle()
    {
        $id = (int)$this->Request()->sArticle;
        $number = $this->Request()->getParam('number', null);
        $selection = $this->Request()->getParam('group', array());
        $categoryId = $this->Request()->get('sCategory');
        
        if (!self::_isValidCategory($categoryId))
        {
            $categoryId = 0;
        }

        try
        {
            return Shopware()->Modules()->Articles()->sGetArticleById($id, $categoryId, $number, $selection);
        }
        catch (RuntimeException $e)
        {
            return null;
        }
    }

    /**
     * Checks if the provided $categoryId is in the current shop's category tree
     *
     * @param int $categoryId
     * @return bool
     */
    private static function _isValidCategory($categoryId)
    {
        $defaultShopCategoryId = Shopware()->Shop()->getCategory()->getId();
        $repository = Shopware()->Models()->getRepository('Shopware\Models\Category\Category');
        $categoryPath = $repository->getPathById($categoryId);
        
        if (!$categoryPath)
        {
            return true;
        }
        
        if (!array_key_exists($defaultShopCategoryId, $categoryPath))
        {
            return false;
        }
        return true;
    }

    private static function _sImageToSchemaOrgImage($sImage)
    {
        $result = ['@context' => 'http://schema.org', '@type' => 'Image'];

        if (!empty($sImage))
        {
            if (!empty($sImage->source))
            {
                $result['url'] = $result['contentUrl'] = $sImage->source;
            }

            if (!empty($sImage->width))
            {
                $result['width'] = $sImage->width;
            }

            if (!empty($sImage->height))
            {
                $result['height'] = $sImage->height;
            }

            if (!empty($sImage->description))
            {
                $result['description'] = $sImage->description;
            }

            if (!empty($sImage->thumbnails))
            {
                $thumbnail = ['@context' => 'http://schema.org', '@type' => 'Image'];

                if (!empty($sImage->thumbnails[0]->source))
                {
                    $thumbnail['url'] = $thumbnail['contentUrl'] = $sImage->thumbnails[0]->source;
                }

                if (!empty($sImage->thumbnails[0]->maxWidth))
                {
                    $thumbnail['width'] = $sImage->thumbnails[0]->maxWidth;
                }

                if (!empty($sImage->thumbnails[0]->maxHeight))
                {
                    $thumbnail['height'] = $sImage->thumbnails[0]->maxHeight;
                }

                if (count($thumbnail) > 2)
                {
                    $result['thumbnail'] = $thumbnail;
                }
            }
        }

        return count($result) == 2 ? [] : $result;
    }

    private static function _schemaOrgBrandFromSArticle($sArticle)
    {
        $result = ['@context' => 'http://schema.org', '@type' => 'Brand'];

        if (!empty($sArticle->supplierName))
        {
            $result['name'] = $sArticle->supplierName;
        }

        if (!empty($sArticle->supplierImg))
        {
            $result['image'] = $sArticle->supplierImg;
        }

        if (!empty($sArticle->supplierDescription))
        {
            $result['description'] = $sArticle->supplierDescription;
        }

        return count($result) == 2 ? [] : $result;
    }

    private static function _sArticleToSchemaOrgProduct($sArticle)
    {
        $result = ['@context' => 'http://schema.org', '@type' => 'Product'];
        
        $result['productID'] = $sArticle->ordernumber;
        $result['name'] = $sArticle->articleName;
        $result['url'] = ''; // TODO AMP Controller URL zu diesem Artikel
        $result['sameAs'] = ''; // TODO Shopware Detail Controller URL zu diesem Artikel

        if (!empty($sArticle->description_long))
        {
            $result['description'] = $sArticle->description_long;
        }

        if (!empty($sArticle->description))
        {
            $result['disambiguatingDescription'] = $sArticle->description;
        }

        $image = self::_sImageToSchemaOrgImage($sArticle->image);

        if (!empty($image))
        {
            $result['image'] = $image;
        }

        $brand = self::_schemaOrgBrandFromSArticle($sArticle);

        if (!empty($brand))
        {
            $result['brand'] = $brand;
        }

        return $result;
/*
TODO
                    'offers' => ['type' => '@Offer'
                        'price' => $sArticle.price_nummeric,
                        'availability' => 'TODO CHECK IMPLEMENTATION'
                        'priceCurrency' => Shopware()->Shop()->getCurrency()->getCurrency()
                    ]
*/
    }
}
