<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Size extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        $size = Mage::getModel('htmlcanvas/sizes')->load($value);
        return $size->getName();
    }
}
?>