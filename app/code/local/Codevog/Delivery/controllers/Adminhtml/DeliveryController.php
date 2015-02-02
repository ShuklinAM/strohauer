<?php
class Codevog_Delivery_Adminhtml_DeliveryController extends Mage_Adminhtml_Controller_Action
{
    public function daysAction()
    {
       $this->_title($this->__('Weekends'));
      
        $this->loadLayout();
        $this->_setActiveMenu('codevog_delivery');
        $this->_addBreadcrumb(Mage::helper('codevog_delivery')->__('Weekends'), Mage::helper('codevog_delivery')->__('Weekends'));
        $this->renderLayout();
    }
    
    
    public function datesAction()
    {
        $this->_title($this->__('Holidays'));
    
        $this->loadLayout();
        $this->_setActiveMenu('codevog_delivery');
        $this->_addBreadcrumb(Mage::helper('codevog_delivery')->__('Holidays'), Mage::helper('codevog_delivery')->__('Holidays'));
        $this->renderLayout();
    }
    
    
    public function minimumdaysAction()
    {
         $this->_title($this->__('Minimum days num of delivery'));
      
        $this->loadLayout();
        $this->_setActiveMenu('codevog_delivery');
        $this->_addBreadcrumb(Mage::helper('codevog_delivery')->__('Minimum days num of delivery'), Mage::helper('codevog_delivery')->__('Minimum days num of delivery'));
        $this->renderLayout();
    }
    
    public function editminimumdaysAction()
    {
        $this->_title($this->__('Edit minimum days of delivery'));

        $this->loadLayout();
        $this->_setActiveMenu('codevog_delivery');
        $this->_addBreadcrumb(Mage::helper('codevog_delivery')->__('Edit minimum dyas of delivery'), Mage::helper('codevog_delivery')->__('Edit minimum dyas of delivery'));
        $this->renderLayout();
    }
    public function editdaysAction()
    {
        $this->_title($this->__('Edit weekends of delivery'));

        $this->loadLayout();
        $this->_setActiveMenu('codevog_delivery');
        $this->_addBreadcrumb(Mage::helper('codevog_delivery')->__('Edit weekends of delivery'), Mage::helper('codevog_delivery')->__('Edit weekends of delivery'));
        $this->renderLayout();
    }
    
    public function saveminimumdaysAction()
    {
        $data = $this->getRequest()->getPost();
        
        if (!empty($data)) {
            try {
                Mage::getModel('delivery/minimumdays')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_delivery')->__('Minimum days of delivery successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/minimumdays');
    }
    public function savedaysAction()
    {
        $data = $this->getRequest()->getPost();
       
        if (!empty($data)) {
            try {
                Mage::getModel('delivery/days')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_delivery')->__('Changing weekends of delivery successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/days');
    }
    public function savedatesAction()
    {
        
       $dates =$this->getRequest()->getParam('calendar');
       $dates = json_decode($dates);
      
       $holiday_model = Mage::getModel('delivery/dates');
       $holiday_collection = $holiday_model->getCollection();
       foreach($holiday_collection as $holiday)
       {
           $holiday->delete();
       }
       
       
       foreach($dates[0] as $date)
       {
           $holiday_model = Mage::getModel('delivery/dates');
           $holiday_model->setDate($date)->save();
          
       }
       
    }
    public function deletedateAction()
    {
         $date_id =$this->getRequest()->getParam('date_id');
         $holiday_model = Mage::getModel('delivery/dates');
         $holiday_model->setId($date_id)->delete();
         
         
         $className = Mage::getConfig()->getBlockClassName('codevog_delivery/adminhtml_dates');
        $date_block = new $className();               
        $holidays= $date_block->get_holidays();
         
         
         
        
         $output = '';
          foreach($holidays as $holiday) {
             
                $output .= '<div class="date_elem">'.$holiday->getDate().'</div>
                <div class="date_delete"><input type="button" value="delete" onclick="delete_date('.$holiday->getId().',\''.$date_block->getUrl('/delivery/deletedate').'\');get_dates_without('.$holiday->getId().',\''.$date_block->getUrl('/delivery/getdateswithout').'\');"></div>';
      }
      echo $output;
    }
    public function getdateswithoutAction()
    {
        $date_id = $this->getRequest()->getParam('id');
        $className = Mage::getConfig()->getBlockClassName('codevog_delivery/adminhtml_dates');
        $date_block = new $className();               
        $holidays= $date_block->get_holidays();
        $output = '';
        foreach($holidays as $holiday)
        {
               if($holiday->getId() != $date_id)
                    $output .= 'new Date('.$holiday->getDate().'),';
        }
        $output = str_replace('-','/',$output);
        $output = substr($output,0, strlen($output) - 1);
        echo $output;
    }
   
}
