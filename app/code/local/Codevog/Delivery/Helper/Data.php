<?php
class Codevog_Delivery_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getConfig($key, $store = null)
    {
        $websiteId = Mage::app()->getStore($store)->getWebsiteId();

        if (!isset($this->_config[$websiteId])) {
            $this->_config[$websiteId] = Mage::getStoreConfig('checkout/codevog_delivery', $store);
        }
        return isset($this->_config[$websiteId][$key]) ? (string)$this->_config[$websiteId][$key] : null;
    }
}
?>
