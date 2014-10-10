<?php
class Codevog_News_Block_Adminhtml_Editnews_Imageview extends Varien_Data_Form_Element_Abstract
{

/**
* renderer
*
* @param Varien_Data_Form_Element_Abstract $element
*/
   public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('label');
    }

    public function getElementHtml()
    {
         if (!is_null($this->getLabel())) {
            $html = '<label for="'.$this->getHtmlId() . $idSuffix . '" style="'.$this->getLabelStyle().'">'.$this->getLabel()
                . ( $this->getRequired() ? ' <span class="required">*</span>' : '' ).'</label>'."\n";
        }
        else {
            $html = '';
        }
        return $html;
    }

    public function getLabelHtml($idSuffix = ''){
        
       return Mage::helper('codevog_news')->__('Current Image');

    }
}