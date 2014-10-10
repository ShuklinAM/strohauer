<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Templatesettings_Block_Adminhtml_System_Config_Form_Field_Showdescription extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Override method to output our custom image
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // Get the default HTML for this option
        $html = parent::_getElementHtml($element);

        $html .= '<div class="helper-image"><br/><img src="'.$this->getSkinUrl('images/codevog/template/navigation_description.jpg').'" alt="" /></div>';
        return $html;
    }
}