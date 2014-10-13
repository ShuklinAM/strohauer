<?php
class Codevog_News_ViewController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if(Mage::helper('codevog_news')->isActive())
        {
            $news_id = (int)$this->getRequest()->getParam('id');
            if($news_id)
            {
                $news = Mage::getModel('news/news')->load($news_id);
                if(!$news->getId() || !$news->getEnabled() || $news->getStartDate() > date("Y-m-d H:i:s") || $news->getFinishDate() < date("Y-m-d H:i:s"))
                    return $this->_redirect('error404');
                else
                {
                    Mage::register('current_news',$news);
                    $template = Mage::getStoreConfig('templatesettings/templatesettings_news/news_templateview');
                    $this->loadLayout()
                        ->getLayout()
                        ->getBlock('root')
                        ->setTemplate('page/'.$template.'.phtml');
                    $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
                    $breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Home Page'), 'link'=>Mage::getBaseUrl()));
                    $breadcrumbs->addCrumb('news', array('label'=>$this->__('News'), 'title'=>$this->__('News'), 'link' => Mage::getBaseUrl() . 'news'));
                    $breadcrumbs->addCrumb('news_view', array('label'=>$this->__($news->getTitle()), 'title'=>$this->__($news->getTitle())));
                    $this->renderLayout();
                }

            }
            else
                return $this->_redirect('error404');

        }
        else
        {
            return $this->_redirect('error404');
        }

    }

}