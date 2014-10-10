<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Templatesettings_Model_Config_Width
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value' => 'flexible',
	            'label' => Mage::helper('templatesettings')->__('flexible')),
            array(
	            'value' => 'fixed',
	            'label' => Mage::helper('templatesettings')->__('fixed')),
        );
    }

}
