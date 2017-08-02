<?php

use HeptacomAmp\Components\PluginDependencies;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Models\Category\Category;
use Shopware\Models\Category\Repository;

/**
 * Class Shopware_Controllers_Backend_KskAmpBackend
 */
class Shopware_Controllers_Backend_KskAmpBackend extends Shopware_Controllers_Api_Rest implements CSRFWhitelistAware
{
    /**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return [
            'getDependencies',
            'getCategories',
        ];
    }

    /**
     * @return array
     */
    private function getDependencies()
    {
        return PluginDependencies::instance()->getDependencies();
    }

    /**
     * Callable via /backend/KskAmpBackend/getDependencies
     */
    public function getDependenciesAction()
    {
        $this->View()->assign([
            'success' => false,
            'data' => $this->getDependencies(),
        ]);
    }

    /**
     * @param Category $category
     * @return array
     */
    private function hydrateCategory(Category $category)
    {
        $result = [
            'id' => $category->getId(),
            'name' => $category->getName(),
        ];

        if (!$category->getChildren()->isEmpty()) {
            $result['categories'] = array_map([$this, 'hydrateCategory'], $category->getChildren()->toArray());
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getCategories()
    {
        /** @var Repository $categoryRepository */
        $categoryRepository = $this->getModelManager()->getRepository(Category::class);
        return array_map([$this, 'hydrateCategory'], $categoryRepository->findBy(['parent' => null]));
    }

    /**
     * Callable via /backend/KskAmpBackend/getCategories
     */
    public function getCategoriesAction()
    {
        $this->View()->assign([
            'success' => false,
            'data' => $this->getCategories(),
        ]);
    }
}