<?php

class Codevog_Templatesettings_Block_Category_List extends Mage_Core_Block_Template
{
    protected $columnCount = 3;

    public function _construct()
    {
        $this->setTemplate('catalog/category/list.phtml');
        return parent::_construct();
    }

    public function getCategories($categoryId = false)
    {
        if(!$categoryId)
            $categoryId = $this->getCurrentCategoryId();
        if($categoryId)
            return Mage::getModel('catalog/category')->getCategories($categoryId);

        return false;
    }

    public function getCurrentCategoryId()
    {
        return (Mage::registry('current_category') && ($categoryId = Mage::registry('current_category')->getId())) ? $categoryId : false;
    }

    public function getCategoryImageUrl($category)
    {
        return Mage::helper('templatesettings')->getCategoryImageUrl($category);
    }

    public function getColumnCount()
    {
        return $this->columnCount;
    }

    public function isCategoryActive($category)
    {
        if ($this->getCurrentCategory())
            return in_array($category->getId(), $this->getCurrentCategory()->getPathIds());

        return false;
    }

    public function getCurrentCategory()
    {
        if (Mage::getSingleton('catalog/layer'))
            return Mage::getSingleton('catalog/layer')->getCurrentCategory();

        return false;
    }

    public function  getCategoryBranch($categories, $deep = 0, $start = 0)
    {
        $html = '<ul class="menu_cat">';

        $saleMenu = '';

        foreach($categories as $category)
        {
            $category = Mage::getModel('catalog/category')->load($category->getId());

            $activeCategory = 'class="';
            if($this->isCategoryActive($category))
            {
                $activeCategory .= 'active_left_menu';
                if($deep == 1)
                    $activeCategory .= ' sub';
            }
            else
            {
                if($deep == 1)
                    $activeCategory .= ' sub';
            }

            if($category->hasChildren() && $deep > 0)
                $activeCategory .= ' has-children';

            $activeCategory .= '"';

            $html .= '<li '.$activeCategory.'>'.
                '<a  href="' . $category->getUrl(). '">' .
                $category->getName() . "</a>\n";

            ++$start;

            if($category->hasChildren() && $this->isCategoryActive($category))
            {
                $children = Mage::getModel('catalog/category')->getCategories($category->getId());
                $deep++;
                if($deep < 4)
                {
                    $html .=  $this->getCategoryBranch($children, $deep, $start);
                    $deep -= 1;
                }
            }

            $html .= '</li>';
        }

        $html .= $saleMenu;

        $html .= '</ul>';
        return  $html;
    }
}