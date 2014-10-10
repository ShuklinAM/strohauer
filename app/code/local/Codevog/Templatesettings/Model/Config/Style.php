<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Templatesettings_Model_Config_Style
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'dark',
	            'label' => Mage::helper('templatesettings')->__('dark')),
            array(
	            'value'=>'light',
	            'label' => Mage::helper('templatesettings')->__('light')),
        );
    }

}
