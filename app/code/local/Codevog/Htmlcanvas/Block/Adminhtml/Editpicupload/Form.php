<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editpicupload_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $pic = Mage::registry('current_pic');
        $form = new Varien_Data_Form(array('enctype' => 'multipart/form-data'));
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('codevog_htmlcanvas')->__('Set Pic Subcategory')
        ));

        if($pic->getId())
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

        $subcategories = Mage::getModel('htmlcanvas/picsubcategory')->getCollection();
        $subcategoryList = array();
        foreach($subcategories as $subcategory)
        {
            $subcategoryList[] = array
            (
                'value' => $subcategory->getId(),
                'label' => $subcategory->getName()
            );
        }

        $fieldset->addField('pic_subcategory_id', 'select', array(
            'name'      => 'pic_subcategory_id',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Subcategory'),
            'required'  => true,
            'values'    => $subcategoryList
        ));



        if($pic->getId())
        {
            $fieldset->addType('image_label','Codevog_Htmlcanvas_Block_Adminhtml_Editpicupload_View');

            $fieldset->addField('show_pic', 'image_label', array(
                'label'         => '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/htmlcanvas/clipart/'.$pic->getPic().'">',
                'name'          => 'show_pic',
                'required'      => false,
                'value'     => 'Current Pic',

            ));
        }

        $need_upload = true;
        if($pic->getId())
        {
            $need_upload = false;
        }


        $fieldset->addField('pic', 'file', array(
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Pic Upload'),
            'required'  => $need_upload,
            'name'      => 'pic',
        ));



        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Position'),
            'required'  => false
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/savepicupload'));
        $form->setValues($pic->getData());

        $this->setForm($form);


    }
}
?>