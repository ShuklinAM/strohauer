<?php
class Codevog_Delivery_Block_Calendar extends Mage_Core_Block_Template
{
    public function _construct()
    {
      
        if($this->isEnabled())
        {
            parent::_construct();
            $this->setTemplate('codevog/delivery/form.phtml');
        }
      
    }
     public function isEnabled() {

        return Mage::helper('codevog_delivery')->getConfig('enable_date');
    }
    public function get_minimal_date()
    {
        $minimum_days_model = Mage::getModel('delivery/minimumdays');
        $minimum_days =  $minimum_days_model->getCollection()->getFirstItem();
        
        
        $holidays_model = Mage::getModel('delivery/dates');
        $holidays = $holidays_model->getCollection();
        $weekends = $this->getWeekendDates();
        
        $counter = 0;
        for($i = 1;$i < 365;$i++)
        {
            $disable = 0;
            foreach($weekends as $weekend)
            {
                if(date("Y-m-d",strtotime('+ '.($i).' days')) == $weekend)
                {
                    $disable = 1;
                    break;
                }
            }
            if($disable == 0)
            {
                foreach($holidays as $holiday)
                {
                   if(date("Y-m-d",strtotime('+ '.($i).' days')) == $holiday->getDate())
                    {
                        $disable = 1;
                        break;
                    }
                }
            }
            if($disable == 0)
            {
                $counter++;
            }
            if($counter == $minimum_days->getNum())
            {
                $minimum_date = date("Y-m-d",strtotime('+ '.($i).' days'));
                break;
            }
        }
        $minimum_date = date("d.m.Y",  strtotime($minimum_date));
        return $minimum_date;
    }
    public function get_real_minimum()
    {
        $minimum_days_model = Mage::getModel('delivery/minimumdays');
        $minimum_days =  $minimum_days_model->getCollection()->getFirstItem();
        
        
        $holidays_model = Mage::getModel('delivery/dates');
        $holidays = $holidays_model->getCollection();
        $weekends = $this->getWeekendDates();
        $counter = 0;
        for($i = 1;$i < 365;$i++)
        {
            $disable = 0;
            foreach($weekends as $weekend)
            {
                if(date("Y-m-d",strtotime('+ '.($i).' days')) == $weekend)
                {
                    $disable = 1;
                    break;
                }
            }
            if($disable == 0)
            {
                foreach($holidays as $holiday)
                {
                   if(date("Y-m-d",strtotime('+ '.($i).' days')) == $holiday->getDate())
                    {
                        $disable = 1;
                        break;
                    }
                }
            }
            if($disable == 0)
            {
                $counter++;
            }
            if($counter == $minimum_days->getNum())
            {
                $minimum_num = $i;
                break;
            }
        }
        
        return $minimum_num;
    }
    public function get_disable_dates()
    {
        $holidays_model = Mage::getModel('delivery/dates');
        $holidays = $holidays_model->getCollection();
        $disable_dates = '';
        foreach($holidays as $disable)
        {
            $disable_dates .= 'new Date("'.$disable->getDate().'"),';
        }
        $weekends = $this->getWeekendDates();
        foreach($weekends as $weekend)
        {
            $disable_dates .= 'new Date("'.$weekend.'"),';
        }
       // $minimum_date = $this->get_minimal_date();
        for($i = 0;$i < $this->get_real_minimum();$i ++ )
        {
            $disable_dates .= 'new Date("'.date("Y-m-d",  strtotime("+ ".$i." days")).'"),';
        }
       
        
        $disable_dates = substr($disable_dates,0, strlen($disable_dates) - 1);
        $disable_dates = str_replace('-', '/', $disable_dates);
        
        return $disable_dates;
    }
     public function getFieldIdFormat()
    {
        if (!$this->hasData('field_id_format')) {
            $this->setData('field_id_format', '%s');
        }
        return $this->getData('field_id_format');
    }

    public function getFieldNameFormat()
    {
        if (!$this->hasData('field_name_format')) {
            $this->setData('field_name_format', '%s');
        }
        return $this->getData('field_name_format');
    }

    public function getFieldId($field)
    {
        return sprintf($this->getFieldIdFormat(), $field);
    }

    public function getFieldName($field)
    {
        return sprintf($this->getFieldNameFormat(), $field);
    }
    
    public function getWeekendDates()
    {
        $weekend_model = Mage::getModel('delivery/days');
        $weekends = $weekend_model->getCollection()->addFilter('disable', 1);
        $dates = array();
        for($i = 0;$i < 365;$i++)
        {
             foreach($weekends as $weekend)
             {
                 if(date("w",  strtotime("+ ".$i."days")) == ($weekend->getId() - 1))
                 {
                     $dates[] = date("Y-m-d",  strtotime("+ ".$i."days"));
                 }
             }
            
        }
        return $dates;
    }
} 
