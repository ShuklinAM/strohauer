<?php

class Codevog_Htmlcanvas_Model_Works extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('htmlcanvas/works');
    }
}
?>