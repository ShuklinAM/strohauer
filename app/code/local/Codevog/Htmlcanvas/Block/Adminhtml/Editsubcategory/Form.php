<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editsubcategory_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $subcategory = Mage::registry('current_picsubcategory');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('codevog_htmlcanvas')->__('Set Pic Subcategory')
        ));

        if($subcategory->getId())
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

        $categories = Mage::getModel('htmlcanvas/piccategory')->getCollection();
        $categoryList = array();
        foreach($categories as $category)
        {
            $categoryList[] = array
            (
                'value' => $category->getId(),
                'label' => $category->getName()
            );
        }

        $fieldset->addField('pic_category_id', 'select', array(
            'name'      => 'pic_category_id',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Category'),
            'required'  => true,
            'values'    => $categoryList
        ));

        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Position'),
            'required'  => false
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/savepicsubcategory'));
        $form->setValues($subcategory->getData());

        $this->setForm($form);


    }
}
?>