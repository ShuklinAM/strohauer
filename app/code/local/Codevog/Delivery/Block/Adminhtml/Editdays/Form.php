<?php

class Codevog_Delivery_Block_Adminhtml_Editdays_Form extends Mage_Adminhtml_Block_Widget_Form
{
     protected function _prepareForm()
    {
        $day = Mage::registry('current_days');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_days', array(
            'legend' => Mage::helper('codevog_delivery')->__('Set weekends of delivery')
        ));

        if ($day->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'required'  => true,
              
            ));
        }
         if ($day->getId()) {
            $fieldset->addField('name', 'text', array(
                'name'      => 'name',
                'label'     => Mage::helper('codevog_delivery')->__('Day'),
                'required'  => true,
                'readonly' => true
              
            ));
        }
 
        $fieldset->addField('disable', 'select', array(
            'name'      => 'disable',
            'label'     => Mage::helper('codevog_delivery')->__('Is weekend'),
            'required'  => true,
            'values' => array(
                                '-1'=>'Please Select..',
                                '0' => array('value'=>'0' , 'label' => 'No'),
                                '1' => array('value'=>'1' , 'label' => 'Yes'),
                                                
                                                                                  
                                  
                           ),
        ));
        
    
 
        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/savedays'));
        $form->setValues($day->getData());
 
        $this->setForm($form);
        
        
    }
}
?>
