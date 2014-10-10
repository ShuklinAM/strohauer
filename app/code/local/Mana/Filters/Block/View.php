<?php
/**
 * @category    Mana
 * @package     Mana_Filters
 * @copyright   Copyright (c) http://www.manadev.com
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * Block type for showing filters in category view pages.
 * @author Mana Team
 * Injected into layout instead of standard catalog/layer_view in layout XML file.
 * @method string getShowInFilter() returns position of layered navigation if positioning module is installed and null otherwise
 */
class Mana_Filters_Block_View extends Mage_Catalog_Block_Layer_View {


    public  $_minPrice;
    public  $_maxPrice;
    public  $_currentMinPrice;
    public  $_currentMaxPrice;

    protected function _construct()
    {
        $this->setPrices();
        parent::_construct();
        Mage::register('current_layer', $this->getLayer(), true);
    }

    /**
     * This method is called during page rendering to generate additional child blocks for this block.
     * @return Mana_Filters_Block_View
     * This method is overridden by copying (method body was pasted from parent class and modified as needed). All
     * changes are marked with comments.
     * @see app/code/core/Mage/Catalog/Block/Layer/Mage_Catalog_Block_Layer_View::_prepareLayout()
     */
    protected function _prepareLayout()
    {
        /* @var $layoutHelper Mana_Core_Helper_Layout */
        $layoutHelper = Mage::helper('mana_core/layout');
        $layoutHelper->delayPrepareLayout($this, 200);

        return $this;
    }

    public function delayedPrepareLayout() {
        /* @var $helper Mana_Filters_Helper_Data */
        $helper = Mage::helper(strtolower('Mana_Filters'));

        /* @var $layout Mage_Core_Model_Layout */
        $layout = $this->getLayout();

        /* @var $layer Mage_Catalog_Model_Layer */
        $layer = $this->getLayer();

        /* @var $query Mana_Filters_Model_Query */
        $query = Mage::getSingleton('mana_filters/query');
        $query
            ->setLayer($layer)
            ->init();

        $showState = 'all';
        if ($showInFilter = $this->getShowInFilter()) {
            if (($template = Mage::getStoreConfig('mana_filters/positioning/' . $showInFilter)) && !$this->getTakeTemplateFromXml()) {
                $this->setTemplate($template);
            }
            $showState = Mage::getStoreConfig('mana_filters/positioning/show_state_' . $showInFilter);
        }
        if ($showState) {
            /* @var $state Mana_Filters_Block_State */
            $stateBlock = $layout->createBlock('mana_filters/state', '', array(
                'layer' => $layer,
                'mode' => $showState,
            ));
            $this->setChild('layer_state', $stateBlock);
        }

        foreach ($helper->getFilterOptionsCollection() as $filterOptions) {
            /* @var $filterOptions Mana_Filters_Model_Filter2_Store */

            if ($helper->canShowFilterInBlock($this, $filterOptions)) {
                $displayOptions = $filterOptions->getDisplayOptions();

                $blockName = $helper->getFilterLayoutName($this, $filterOptions);
                /* @var $block Mana_Filters_Block_Filter */
                $block = $layout->createBlock((string)$displayOptions->block, $blockName, array(
                    'filter_options' => $filterOptions,
                    'display_options' => $displayOptions,
                    'show_in_filter' => $this->getShowInFilter(),
                    'query' => $query,
                    'layer' => $layer,
                    'attribute_model' => $filterOptions->getAttribute(),
                    'mode' => $this->getMode(),
                ));
                $block->init();
                $this->setChild($filterOptions->getCode() . '_filter', $block);
            }
        }

        $query->apply();
        $layer->apply();

        return $this;
    }

    public function getMode() {
        /* @var $helper Mana_Filters_Helper_Data */
        $helper = Mage::helper(strtolower('Mana_Filters'));

        if ($mode = $this->_getData('mode')) {
            return $mode;
        }
        else {
            return $helper->getMode();
        }
    }
    public function getFilters() {
        /* @var $helper Mana_Filters_Helper_Data */
        $helper = Mage::helper(strtolower('Mana_Filters'));

        $filters = array();
    	foreach ($helper->getFilterOptionsCollection() as $filterOptions) {
            /* @var $filterOptions Mana_Filters_Model_Filter2_Store */


            if ($helper->isFilterEnabled($filterOptions)) {
                if ($helper->canShowFilterInBlock($this, $filterOptions)) {
                    $filters[] = $this->getChild($filterOptions->getCode() . '_filter');
                }
    		}
        }
        return $filters;
    }
    public function getClearUrl() {
        /* @var $helper Mana_Filters_Helper_Data */
        $helper = Mage::helper(strtolower('Mana_Filters'));

        return $helper->getClearUrl();
    }

    /**
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer() {
        /* @var $helper Mana_Filters_Helper_Data */
        $helper = Mage::helper(strtolower('Mana_Filters'));

        return $helper->getLayer($this->getMode());
    }

    public function canShowBlock() {
        /* @var $helper Mana_Filters_Helper_Data */
        $helper = Mage::helper(strtolower('Mana_Filters'));

        switch ($this->getMode()) {
            case 'category':
                return $this->_canShowBlockInCategory();
            case 'search':
                return $this->_canShowBlockInSearch();
            default:
                throw new Exception('Not implemented');
        }
    }
    public function _canShowBlockInCategory() {
        if ($this->canShowOptions()) {
            return true;
        } elseif ($state = $this->getChild('layer_state')) {
            $appliedFilters = $this->getChild('layer_state')->getActiveFilters();
            return !empty($appliedFilters);
        }
        else {
            return false;
        }
    }
    public function _canShowBlockInSearch() {
        $engine = Mage::helper('catalogsearch')->getEngine();
        $_isLNAllowedByEngine = $engine->isLeyeredNavigationAllowed();
        if (!$_isLNAllowedByEngine && method_exists($engine, 'isLayeredNavigationAllowed')) {
            $_isLNAllowedByEngine = $engine->isLayeredNavigationAllowed();
        }
        if (!$_isLNAllowedByEngine) {
            return false;
        }
        $availableResCount = (int) Mage::app()->getStore()
            ->getConfig(Mage_CatalogSearch_Model_Layer::XML_PATH_DISPLAY_LAYER_COUNT);

        if ($availableResCount && $availableResCount<$this->getLayer()->getProductCollection()->getSize()) {
            return false;
        }
        return $this->_canShowBlockInCategory();
    }

    public function setPrices()
    {
        $previousMinPrice = (Mage::getSingleton('core/session')->getMinPrice()) ? Mage::getSingleton('core/session')->getMinPrice() : 0;
        $previousMaxPrice = (Mage::getSingleton('core/session')->getMaxPrice()) ? Mage::getSingleton('core/session')->getMaxPrice() : 1;

        if(Mage::registry('current_category'))
        {
            $this->_minPrice = Mage::getSingleton('catalog/layer')
                ->setCurrentCategory(Mage::registry('current_category'))
                ->getProductCollection()
                ->getMinPrice();

            $this->_maxPrice = Mage::getSingleton('catalog/layer')
                ->setCurrentCategory(Mage::registry('current_category'))
                ->getProductCollection()
                ->getMaxPrice();
        }
        else
        {
            $this->_minPrice = Mage::getSingleton('catalogsearch/layer')
                ->getProductCollection()
                ->getMinPrice();

            $this->_maxPrice = Mage::getSingleton('catalogsearch/layer')
                ->getProductCollection()
                ->getMaxPrice();
        }

        if($this->_minPrice < $previousMinPrice || $previousMinPrice == 0)
            Mage::getSingleton('core/session')->setMinPrice($this->_minPrice);
        else
            $this->_minPrice = $previousMinPrice;

        if($this->_maxPrice > $previousMaxPrice && $this->_maxPrice > 0)
            Mage::getSingleton('core/session')->setMaxPrice($this->_maxPrice);
        else
            $this->_maxPrice = $previousMaxPrice;


        $requestMinPrice = $this->getRequest()->getParam('min');
        $requestMaxPrice = $this->getRequest()->getParam('max');

        $this->_currentMinPrice = ($requestMinPrice && $requestMinPrice > $this->_minPrice) ? $requestMinPrice : $this->_minPrice;
        $this->_currentMaxPrice = ($requestMaxPrice && $requestMaxPrice < $this->_maxPrice) ? $requestMaxPrice : $this->_maxPrice;
    }

    public function getPriceSlider()
    {
        $priceTemplate = $this->setTemplate('mana/filters/price_slider.phtml')->toHtml();
        $this->setTemplate('');
        return $priceTemplate;
    }

    public function getCleanPriceSliderUrl()
    {
        $currentUrl = Mage::helper('mana_filters/url')->getFilterUrl(Mage::helper("core/url")->getCurrentUrl());
        $previousMinPrice = Mage::app()->getRequest()->getParam('min');
        $previousMaxPrice = Mage::app()->getRequest()->getParam('max');

        if($previousMinPrice)
        {
            $currentUrl = str_replace("&min=".$previousMinPrice,"",$currentUrl);
            $currentUrl = str_replace("?min=".$previousMinPrice,"",$currentUrl);
        }

        if($previousMaxPrice)
        {
            $currentUrl = str_replace("&max=".$previousMaxPrice,"",$currentUrl);
            $currentUrl = str_replace("?max=".$previousMaxPrice,"",$currentUrl);
        }
        $isGetRequest = explode("?", $currentUrl);
        if(!isset($isGetRequest[1]))
            $currentUrl .= '?';
        else
            $currentUrl .= '&';
        return $currentUrl;
    }

}