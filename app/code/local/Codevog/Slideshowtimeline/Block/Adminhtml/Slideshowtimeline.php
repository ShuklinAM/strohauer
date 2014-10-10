<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Slideshowtimeline_Block_Adminhtml_Slideshowtimeline extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_slideshowtimeline';
		$this->_blockGroup = 'slideshowtimeline';
		$this->_headerText = Mage::helper('slideshowtimeline')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('slideshowtimeline')->__('Add Item');
		parent::__construct();
	}
}