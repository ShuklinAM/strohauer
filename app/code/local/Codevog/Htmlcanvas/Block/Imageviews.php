<?php
class Codevog_Htmlcanvas_Block_Imageviews extends Mage_Core_Block_Template
{
    public function _construct()
    {
        parent::_construct();
        $model = $this->getRequest()->getParam('model');

        if($model == 'useruploads')
            $this->setTemplate('codevog/htmlcanvas/useruploads.phtml');
        if($model == 'pics')
            $this->setTemplate('codevog/htmlcanvas/cliparts.phtml');
        if($model == 'works')
            $this->setTemplate('codevog/htmlcanvas/doneworks.phtml');
    }

    public function getUserUploads()
    {
        $ip = Mage::helper('codevog_htmlcanvas')->getCurrentIp();
        return Mage::getModel('htmlcanvas/useruploads')->getCollection()->addFieldToFilter('ip',$ip)->setOrder('id','desc');
    }
    public function getPics()
    {
        $subcatId = $this->getRequest()->getParam('sub_id');
        if(!$subcatId)
        {
            $catId = $this->getRequest()->getParam('id');
            $subcatId = Mage::getModel('htmlcanvas/picsubcategory')->getCollection()->setOrder('position','asc')->addFieldToFilter('pic_category_id',$catId)->getFirstItem()->getId();
        }
        return Mage::getModel('htmlcanvas/pics')->getCollection()->setOrder('position','asc')->addFieldToFilter('pic_subcategory_id',$subcatId);
    }
    public function getSubcategories()
    {
        $catId = $this->getRequest()->getParam('id');
        return Mage::getModel('htmlcanvas/picsubcategory')->getCollection()->setOrder('position','asc')->addFieldToFilter('pic_category_id',$catId);
    }
    public function getCurrentUrl()
    {
        return Mage::getBaseUrl().'imagecreate/show/loadimages?model=pics&id='.$this->getRequest()->getParam('id');
    }
    public function getCurrentSubcatId()
    {
        return $this->getRequest()->getParam('sub_id');
    }
    public function getWorks()
    {
       // $ip = Mage::helper('codevog_htmlcanvas')->getCurrentIp();
        return Mage::getModel('htmlcanvas/works')->getCollection()->setOrder('last_update','desc')->addFieldToFilter('show_template',1)->setPageSize(Mage::helper('codevog_htmlcanvas')->getConfig('max_templates'))->setCurPage(1);
    }
}
?>