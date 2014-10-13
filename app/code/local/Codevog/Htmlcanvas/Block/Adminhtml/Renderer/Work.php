<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Work extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        return '<img style="max-width:150px;max-height:150px;" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) .'media/htmlcanvas/builds/'. $value.'"/>';
    }
}
?>