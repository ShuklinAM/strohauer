<?php

class Codevog_Htmlcanvas_Model_Products extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('htmlcanvas/products');
    }

    public function isActiveProduct($productId)
    {
        $product = $this->getCollection()
            ->addFieldToFilter('product_id', $productId)
            ->getFirstItem();
        if($product->getId())
            return true;
        return false;
    }
}