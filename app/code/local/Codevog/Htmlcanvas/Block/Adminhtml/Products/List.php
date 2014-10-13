<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Products_List extends Mage_Adminhtml_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('codevog/htmlcanvas/products.phtml');
    }

    public function getProductsCategory($category)
    {
        return $category->getProductCollection()->addAttributeToSelect('name');
    }

    public function getCategories()
    {
        return Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active')
            ->addFieldToFilter('parent_id', array("gt" => 1))
            ->addAttributeToFilter('is_active', true);
    }

    public function getCheckedProductsIds()
    {
        $joins = array();
        $products = Mage::getModel('htmlcanvas/products')->getCollection();

        foreach($products as $product)
        {
            $joins[] = $product->getProductId();
        }
        return $joins;
    }
}