<?php

class Codevog_Delivery_Block_Adminhtml_Editminimumdays_Form extends Mage_Adminhtml_Block_Widget_Form
{
     protected function _prepareForm()
    {
        $num = Mage::registry('current_minimumdays');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_minimumdays', array(
            'legend' => Mage::helper('codevog_delivery')->__('Minimum days of delivery')
        ));

        if ($num->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'required'  => true,
              
            ));
        }
 
        $fieldset->addField('num', 'text', array(
            'name'      => 'num',
            'label'     => Mage::helper('codevog_delivery')->__('Num of days'),
            'maxlength' => '11',
            'required'  => true,
           
        ));
        
    
 
        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/saveminimumdays'));
        $form->setValues($num->getData());
 
        $this->setForm($form);
        
        
    }
}
?>
