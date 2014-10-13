<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editwork_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $work = Mage::registry('current_work');
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('codevog_htmlcanvas')->__('User Work Options')
        ));

        if($work->getId())
        {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'required'  => true,
            ));

            $fieldset->addType('image_label','Codevog_Htmlcanvas_Block_Adminhtml_Editwork_View');

            $fieldset->addField('show_image', 'image_label', array(
                'label'         => '
                        <a title="'.Mage::helper('codevog_htmlcanvas')->__('Preview Work').'" alt="'.Mage::helper('codevog_htmlcanvas')->__('Preview Work').'" href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/htmlcanvas/builds/'.$work->getImage().'" id="work_image">
                            <img style="max-width:300px;max-height:300px;" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/htmlcanvas/builds/'.$work->getImage().'">
                        </a>
                        <script>jQuery("#work_image").fancybox();</script>
                        ',
                'name'          => 'show_pic',
                'required'      => false
            ));
        }

        $fieldset->addField('show_template', 'select', array(
            'name'      => 'show_template',
            'label'     => Mage::helper('codevog_htmlcanvas')->__('Show In Template Uploads'),
            'required'  => true,
            'values'    => array
                        (
                            0 => array('value' => 0,'label' => Mage::helper('codevog_htmlcanvas')->__('No')),
                            1 => array('value' => 1,'label' => Mage::helper('codevog_htmlcanvas')->__('Yes'))
                        )
        ));





        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/savework'));
        $form->setValues($work->getData());

        $this->setForm($form);


    }
}
?>