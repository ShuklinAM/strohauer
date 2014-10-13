<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Templatesettings_Model_Config_Slider
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'latest',
	            'label' => Mage::helper('templatesettings')->__('Latest Arrivals')),
            array(
	            'value'=>'latest_sale',
	            'label' => Mage::helper('templatesettings')->__('Latest Arrivals  &  On Sale')),
        );
    }

}
