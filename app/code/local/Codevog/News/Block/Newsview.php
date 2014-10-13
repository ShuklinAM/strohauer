<?php
class Codevog_News_Block_Newsview extends Mage_Core_Block_Template
{

    public function _construct()
    {
        parent::_construct();
    }

    public function getCurrentNews()
    {
        $news = Mage::registry('current_news');
        if($news->getId())
            return $news;
        $news_id = (int)$this->getRequest()->getParam('id');
        if($news_id)
        {
            $news = Mage::getModel('news/news')->load($news_id);
            return $news;
        }
    }

}