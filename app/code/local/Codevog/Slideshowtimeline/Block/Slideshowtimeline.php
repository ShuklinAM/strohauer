<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Slideshowtimeline_Block_Slideshowtimeline extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getSlideshowtimeline()
    {
        if (!$this->hasData('slideshowtimeline')) {
            $this->setData('slideshowtimeline', Mage::registry('slideshowtimeline'));
        }
        return $this->getData('slideshowtimeline');
        
    }

	public function getSlides()
    {
        $slides  = Mage::getModel('slideshowtimeline/slideshowtimeline')->getCollection()
            ->addStoreFilter(Mage::app()->getStore())
        	->addFieldToSelect('*')
        	->addFieldToFilter('status', 1)
            ->setOrder('sort_order', 'asc');
        return $slides;
    }

}