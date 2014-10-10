<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editsize_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $size = Mage::registry('current_size');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('codevog_htmlcanvas')->__('Set Size')
        ));

        if($size->getId())
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
        $fieldset->addField('price_rule', 'text', array(
            'name'      => 'price_rule',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Price ('.Mage::helper('codevog_htmlcanvas')->getCurrencySymbol().')'),
            'required'  => true

        ));
        $fieldset->addField('shape', 'select', array(
            'name'      => 'shape',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Shape'),
            'required'  => true,
            'values'    => array
                            (
                                0 => array('value' => 'rectangle','label' => Mage::helper('codevog_htmlcanvas')->__('Rectangle')),
                                1 => array('value' => 'oval','label' => Mage::helper('codevog_htmlcanvas')->__('Oval'))
                            )

        ));
        $fieldset->addField('width', 'text', array(
            'name'      => 'width',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Width (cm)'),
            'required'  => true

        ));
        $fieldset->addField('height', 'text', array(
            'name'      => 'height',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Height (cm)'),
            'required'  => true

        ));
        $fieldset->addField('workspace_width', 'text', array(
            'name'      => 'workspace_width',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Workspace Width (cm)'),
            'required'  => true

        ));
        $fieldset->addField('workspace_height', 'text', array(
            'name'      => 'workspace_height',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Workspace Height (cm)'),
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
        $form->setAction($this->getUrl('*/*/savesize'));
        $form->setValues($size->getData());

        $this->setForm($form);


    }
}
?>