<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editcategory_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $category = Mage::registry('current_piccategory');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('codevog_htmlcanvas')->__('Set Pic Category')
        ));

        if($category->getId())
        {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'required'  => true,
            ));
        }
        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Name'),
            'required'  => true

        ));
        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Position'),
            'required'  => false
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/savepiccategory'));
        $form->setValues($category->getData());

        $this->setForm($form);


    }
}
?>