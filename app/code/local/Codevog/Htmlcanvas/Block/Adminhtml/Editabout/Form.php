<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editabout_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $about = Mage::registry('current_about');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('codevog_htmlcanvas')->__('Set Message')
        ));

        if($about->getId())
        {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'required'  => true,
            ));
        }
        $config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField('text', 'editor', array(
            'name'      => 'text',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Message'),
            'required'  => false,
            'wysiwyg' => true,
            'config' => $config
        ));

        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/saveabout'));
        $form->setValues($about->getData());

        $this->setForm($form);


    }
}
?>