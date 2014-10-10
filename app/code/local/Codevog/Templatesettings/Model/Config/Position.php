<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Templatesettings_Model_Config_Position
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'top-left',
	            'label' => Mage::helper('templatesettings')->__('Top Left')),
            array(
	            'value'=>'top-right',
	            'label' => Mage::helper('templatesettings')->__('Top Right')),
            array(
	            'value'=>'bottom-left',
	            'label' => Mage::helper('templatesettings')->__('Bottom Left')),
            array(
	            'value'=>'bottom-right',
	            'label' => Mage::helper('templatesettings')->__('Bottom Right')),

        );
    }

}
