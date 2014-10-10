<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Templatesettings_Helper_Data extends Mage_Core_Helper_Abstract
{

	protected function _loadProduct(Mage_Catalog_Model_Product $product)
	{
		$product->load($product->getId());
	}

	public function getLabel(Mage_Catalog_Model_Product $product)
	{
		$html = '';
		if (!Mage::getStoreConfig("templatesettings/templatesettings_labels/new_label") &&
			!Mage::getStoreConfig("templatesettings/templatesettings_labels/sale_label") ) {
			return $html;
		}

		$this->_loadProduct($product);

		if ( Mage::getStoreConfig("templatesettings/templatesettings_labels/new_label") && $this->_isNew($product) ) {
			$html .= '<div class="new-label new-'.Mage::getStoreConfig('templatesettings/templatesettings_labels/new_label_position').'"></div>';
		}
		if ( Mage::getStoreConfig("templatesettings/templatesettings_labels/sale_label") && $this->_isOnSale($product) ) {
			$html .= '<div class="sale-label sale-'.Mage::getStoreConfig('templatesettings/templatesettings_labels/sale_label_position').'"></div>';
		}

		return $html;
	}

	protected function _checkDate($from, $to)
	{
		$date = new Zend_Date();
		$today = strtotime($date->__toString());

		if ($from && $today < $from) {
			return false;
		}
		if ($to && $today > $to) {
			return false;
		}
		if (!$to && !$from) {
			return false;
		}
		return true;
	}

	protected function _isNew($product)
	{
		$from = strtotime($product->getData('news_from_date'));
		$to = strtotime($product->getData('news_to_date'));

		return $this->_checkDate($from, $to);
	}

	protected function _isOnSale($product)
	{
		$from = strtotime($product->getData('special_from_date'));
		$to = strtotime($product->getData('special_to_date'));

		return $this->_checkDate($from, $to);
	}

    function getPricePerKg($_product)
    {
        $product = Mage::getModel('catalog/product')->load($_product->getId());

        $kg = 1000;

        $netWeight = $product->getNetWeight();

        if(!$netWeight)
            return false;

        $productPrice = $product->getFinalPrice();

        $pricePerKg = ($kg * $productPrice) / $netWeight;
        $pricePerKg = Mage::helper('core')->currency($pricePerKg, true, false);

        return '<span class="price-perkg-details">('.$this->__('entspricht').' '.$pricePerKg.' / '.$this->__('1 Kilogramm (kg)').')</span>';
    }

    public function getPricePerLiter($_product)
    {
        $product = Mage::getModel('catalog/product')->load($_product->getId());

        $liter = 1;

        $liters = $product->getLiters();

        if(!$liters)
            return false;

        $productPrice = $product->getFinalPrice();

        $pricePerLiter = ($liter * $productPrice) / $liters;
        $pricePerLiter = Mage::helper('core')->currency($pricePerLiter, true, false);

        return '<span class="price-perkg-details">('.$this->__('entspricht').' '.$pricePerLiter.' / '.$this->__('1 Liter (l)').')</span>';
    }

    public function getCategoryImageUrl($category)
    {
        $imagePath = Mage::getBaseDir('media').'/catalog/category/';

        $image = ($category->getThumbnail()) ? $category->getThumbnail() : $category->getImage();
        if(!$image)
            return $this->getPlaceholder();
        else
            if(!file_exists($imagePath.$image))
                return $this->getPlaceholder();

        $imageUrl = Mage::getBaseUrl('media').'catalog/category/';

        return $imageUrl.$image;
    }

    public function getPlaceholder()
    {
        $placeholderUrl = Mage::getBaseUrl('media').'catalog/product/placeholder/';
        $placeholderName = Mage::getStoreConfig('catalog/placeholder/thumbnail_placeholder');

        return $placeholderUrl.$placeholderName;
    }

}