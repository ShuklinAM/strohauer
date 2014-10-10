<?php
class Codevog_News_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if(Mage::helper('codevog_news')->isActive())
        {
            $template = Mage::getStoreConfig('templatesettings/templatesettings_news/news_template');

            $this->loadLayout()
                ->getLayout()
                ->getBlock('root')
                ->setTemplate('page/'.$template.'.phtml');
            $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
            $breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Home Page'), 'link'=>Mage::getBaseUrl()));
            $breadcrumbs->addCrumb('news', array('label'=>$this->__('News'), 'title'=>$this->__('News')));
            $this->renderLayout();
        }
        else
        {
            return $this->_redirect('error404');
        }
    }


}