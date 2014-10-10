<?php

class Codevog_Htmlcanvas_Model_Mysql4_Products extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('htmlcanvas/products','id');
    }
}