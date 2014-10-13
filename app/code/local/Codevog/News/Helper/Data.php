<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_News_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isActive()
    {
       return Mage::getStoreConfig('templatesettings/templatesettings_news/news_active');
    }
    public function getConvertedDate($date)
    {
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $convertedDate = $dateTime->format('d.m.Y H:s');
        return $convertedDate;
    }
    public function getImageUrl($news)
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/codevog/news/' .$news->getImage();
    }
    public function getNewsUrl($news)
    {
        return Mage::getBaseUrl().'news/view?id='.$news->getId();
    }
    public function getNewsListUrl()
    {
        return Mage::getBaseUrl().'news';
    }
}
