<?php
class Codevog_News_Adminhtml_NewsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        return $this->_redirect('*/*/view');
    }
    public function viewAction()
    {
        $this->_title($this->__('News'));
        $this->loadLayout();

        $this->_setActiveMenu('codevog_news');

        $this->renderLayout();

    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function addnewsAction()
    {
        $this->_title($this->__('Add News'));
        $this->loadLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->_setActiveMenu('codevog_news');
        $this->_addBreadcrumb(Mage::helper('codevog_news')->__('News'), Mage::helper('codevog_news')->__('Add News'));
        $this->renderLayout();
    }
    public function editnewsAction()
    {

        $this->_title($this->__('Edit News'));
        $this->loadLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')
                ->setCanLoadExtJs(true)
                ->setCanLoadTinyMce(true)
                ->addItem('js','tiny_mce/tiny_mce.js')
                ->addItem('js','mage/adminhtml/wysiwyg/tiny_mce/setup.js')
                ->addJs('mage/adminhtml/browser.js')
                ->addJs('prototype/window.js')
                ->addJs('lib/flex.js')
                ->addJs('mage/adminhtml/flexuploader.js')
                ->addItem('js_css','prototype/windows/themes/default.css')
                ->addItem('js_css','prototype/windows/themes/magento.css');
        }
        $this->_setActiveMenu('codevog_news');
        $this->_addBreadcrumb(Mage::helper('codevog_news')->__('News'), Mage::helper('codevog_news')->__('Edit News'));
        $this->renderLayout();
    }
    public function deletenewsAction()
    {
        $news_id = (int)$this->getRequest()->getParam('id');
        $news = Mage::getModel('news/news')->load($news_id);
        $media_path  = Mage::getBaseDir('media'). DS.'codevog'. DS .'news'. DS;
        unlink($media_path.$news->getImage());
        $news_model = Mage::getModel('news/news')->setId($news_id);
        $news_model->delete();

        return $this->_redirect('*/*/view');
    }
    public function savenewsAction()
    {
        $data = $this->getRequest()->getPost();

        if (!empty($data)) {



            if(isset($_FILES['news_image']['name']) && $_FILES['news_image']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('news_image');

                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    //$uploader->setAllowCreateFolders(true);
                    // Set media as the upload dir
                    $media_path  = Mage::getBaseDir('media'). DS.'codevog'. DS . 'news';

                    // Upload the image
                    $new_name = $uploader->save($media_path, $_FILES['news_image']['name']);

                    $data['image'] = $new_name['file'];

                }
                catch (Exception $e) {
                    print_r($e);
                    die;
                }
            }

        if(!$data['start_date'])
               $data['start_date'] = date('Y-m-d H:i:s');
        if(!$data['finish_date'])
        {
            $timestamp = strtotime('+1 year');
            $data['finish_date'] = date('Y-m-d H:i:s',$timestamp);
        }
            try {
                Mage::getModel('news/news')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_news')->__('News successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/view');
    }

}
?>