<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Pic extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        return '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) .'media/htmlcanvas/clipart/'. $value.'"/>';
    }
}
?>