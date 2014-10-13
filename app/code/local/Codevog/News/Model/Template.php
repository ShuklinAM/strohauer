<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_News_Model_Template extends Mage_Core_Model_Abstract
{

    public function toOptionArray()
    {
        return array(
            array(
                'value'=>'1column',
                'label' => '1column'),
            array(
                'value'=>'2columns-left',
                'label' => Mage::helper('codevog_news')->__('2columns-left')),
            array(
                'value'=>'2columns-right',
                'label' => Mage::helper('codevog_news')->__('2columns-right')),
            array(
                'value'=>'3columns',
                'label' => Mage::helper('codevog_news')->__('3columns')),

        );
    }

}
