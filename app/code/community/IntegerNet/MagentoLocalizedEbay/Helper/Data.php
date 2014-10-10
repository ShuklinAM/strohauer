<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_MagentoLocalizedEbay
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @author     Andreas von Studnitz <avs@integer-net.de>
 */
class IntegerNet_MagentoLocalizedEbay_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_htmlData = null;

    /**
     * @return array
     */
    public function getHtmlData()
    {
        if (is_null($this->_htmlData)) {
            $htmlData = $this->_getHtmlDataFromWeb();
            if (sizeof($htmlData)) {
                $this->_htmlData = $htmlData;
            } else {
                $this->_htmlData = $this->_getHtmlDataFromFile();
            }
        }

        return $this->_htmlData;
    }

    /**
     * @return string
     */
    protected function _getHtmlDataUrl()
    {
        return Mage::getStoreConfig('magento_localized/htmldata_url');
    }

    /**
     * @return array
     */
    protected function _getHtmlDataFromWeb()
    {
        $url = $this->_getHtmlDataUrl();

        try {
            $request = new Zend_Http_Client($url);
            $response = $request->request();
            return Zend_Json::decode($response->getBody());
        } catch (Exception $e) {
            Mage::logException($e);
            return array();
        }
    }

    /**
     * @return array
     */
    protected function _getHtmlDataFromFile()
    {
        $filename = Mage::getModuleDir('etc', 'IntegerNet_MagentoLocalizedEbay') . DS . 'htmldata.json';
        if (is_readable($filename)) {
            $fileContents = file_get_contents($filename);
            try {
                return Zend_Json::decode($fileContents);
            } catch (Exception $e) {
                Mage::logException($e);
                return array();
            }
        }
    }
}