<?php

class Codevog_News_Block_Adminhtml_Editnews extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_news';
        $this->_mode = 'editnews';
        $this->_controller = 'adminhtml';

        $news_id = (int)$this->getRequest()->getParam('id');


        if($news_id)
        {
            $this->_addButton('deletenews', array(
                'label'     => Mage::helper('codevog_news')->__('Delete news'),
                'onclick'   => "
                   if(confirm('".Mage::helper('codevog_news')->__('Delete current news?')."'))
                    {
                        setLocation('".$this->getUrl('*/*/deletenews/id/'.$news_id)."')
                     }
                       ", ));



            $this->_removeButton('delete');
        }


        $news = Mage::getModel('news/news')->load($news_id);

        Mage::register('current_news', $news);

    }

    public function getHeaderText()
    {
        $news = Mage::registry('current_news');
        if ($news->getId()) {
            return Mage::helper('codevog_news')->__("Edit news");
        } else {
            return Mage::helper('codevog_news')->__("Add news");
        }
    }
}
?>