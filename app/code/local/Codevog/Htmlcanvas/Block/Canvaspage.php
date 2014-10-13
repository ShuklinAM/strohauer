<?php
class Codevog_Htmlcanvas_Block_Canvaspage extends Mage_Core_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('codevog/htmlcanvas/canvaspage.phtml');
    }
    public function getPicCategories()
    {
        return Mage::getModel('htmlcanvas/piccategory')->getCollection()->setOrder('position','asc');
    }
}
?>