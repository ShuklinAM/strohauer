<?php
class Codevog_Delivery_Block_Adminhtml_Dates extends Mage_Adminhtml_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('codevog/delivery/adminhtml/delivery_dates.phtml');
    }
    public function get_holidays()
    {
        $holiday_model = Mage::getModel('delivery/dates');
        return $holiday_collection = $holiday_model->getCollection()->setOrder('date','DESC');

    }
} 