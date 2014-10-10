<?php

class Codevog_News_Block_Adminhtml_Editnews_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $news = Mage::registry('current_news');
        $form = new Varien_Data_Form(array('enctype' => 'multipart/form-data'));
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => Mage::helper('codevog_news')->__('Write news')
        ));

        if($news->getId())
        {
            $fieldset->addField('id', 'hidden', array(
                'name'      => 'id',
                'required'  => true,

            ));
        }
        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('codevog_news')->__('Name'),
            'required'  => true

        ));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('codevog_news')->__('Header'),
            'required'  => true

        ));


        if($news->getId())
        {
            $fieldset->addType('image_label','Codevog_News_Block_Adminhtml_Editnews_Imageview');

            $fieldset->addField('show_image', 'image_label', array(
                'label'         => '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media' .DS.'codevog' .DS.'news'. DS.$news->getImage().'">',
                'name'          => 'show_image',
                'required'      => false,
                'value'     => 'Current Image',

            ));
            $fieldset->addField('image', 'text', array(
                'name'      => 'image_name',
                'label'     => Mage::helper('codevog_news')->__('Image name'),
                'required'  => true,
                'readonly'  => true

            ));
        }

        $needUpload = true;
        if($news->getId())
        {
            $needUpload = false;
        }

        $fieldset->addField('news_image', 'file', array(
            'label'     => Mage::helper('codevog_news')->__('Image'),
            'required'  => $needUpload,
            'name'      => 'news_image',
        ));

        $config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();


        $fieldset->addField('short_description', 'editor', array(
            'name'      => 'short_description',
            'label'     => Mage::helper('codevog_news')->__('Short description'),
            'required'  => true,
            'wysiwyg' => true,
            'config' => $config
        ));



        $fieldset->addField('description', 'editor', array(
            'name'      => 'description',
            'label'     => Mage::helper('codevog_news')->__('Description'),
            'required'  => true,
            'wysiwyg' => true,
            'config' => $config
        ));

        $dateStrFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $fieldset->addField('start_date', 'date', array(
            'name'      => 'start_date',
            'label'     => Mage::helper('codevog_news')->__('Start date'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => $dateStrFormat,
            'no_span'   => true,
            'required'  => false,
            'time' => true
        ));
        $fieldset->addField('finish_date', 'date', array(
            'name'      => 'finish_date',
            'label'     => Mage::helper('codevog_news')->__('Finish date'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => $dateStrFormat,
            'no_span'   => true,
            'required'  => false,
            'time' => true
        ));

       // $fieldset->setValue($configValue, $dateStrFormat);

        $fieldset->addField('enabled', 'select', array(
            'name'      => 'enabled',
            'label'     => Mage::helper('codevog_news')->__('Enable news'),
            'required'  => true,
            'values' => array(
                '1' => array('value'=>'1' , 'label' => 'Yes'),
                '0' => array('value'=>'0' , 'label' => 'No'),
            ),
        ));



        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/savenews'));
        $form->setValues($news->getData());

        $this->setForm($form);


    }
}
?>