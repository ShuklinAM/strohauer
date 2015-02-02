<?php

class Codevog_Delivery_Model_Mysql4_Minimumdays_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
       parent::_construct();
        $this->_init('delivery/minimumdays');
    }
   
}
?>