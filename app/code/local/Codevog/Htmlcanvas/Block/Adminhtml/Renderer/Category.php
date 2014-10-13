<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        $category = Mage::getModel('htmlcanvas/piccategory')->load($value);
        return $category->getName();
    }
}
?>