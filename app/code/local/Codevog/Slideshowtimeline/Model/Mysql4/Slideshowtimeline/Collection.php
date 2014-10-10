<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Slideshowtimeline_Model_Mysql4_Slideshowtimeline_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('slideshowtimeline/slideshowtimeline');
    }

	/**
     * Add Filter by store
     *
     * @param Mage_Core_Model_Store $store
	 * @param bool $withAdmin
	 * @return Codevog_Slideshowtimeline_Model_Mysql4_Slideshowtimeline_Collection
	 */
	public function addStoreFilter($store, $withAdmin = true)
	{
		if ($store instanceof Mage_Core_Model_Store) {
			$store = array($store->getId());
		}

		$this->getSelect()->join(
			array('store_table' => $this->getTable('slideshowtimeline/slideshowtimeline_store')),
			'main_table.slide_id = store_table.slide_id',
			array()
		)
		->where('store_table.store_id in (?)', ($withAdmin ? array(0, $store) : $store));

		return $this;
	}
}