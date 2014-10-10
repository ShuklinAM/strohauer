<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Subcategory extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        $subcategory = Mage::getModel('htmlcanvas/picsubcategory')->load($value);
        return $subcategory->getName();
    }
}
?>