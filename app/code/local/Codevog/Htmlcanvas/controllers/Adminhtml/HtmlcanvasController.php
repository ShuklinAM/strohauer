<?php
class Codevog_Htmlcanvas_Adminhtml_HtmlcanvasController extends Mage_Adminhtml_Controller_Action
{
    /* products */
    public function productsAction()
    {
        $this->_title($this->__('Choose Products'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }

    public function saveproductsAction()
    {
        $oldCollection = Mage::getModel('htmlcanvas/products')->getCollection();
        foreach($oldCollection as $item)
            $item->delete();

        $newProducts = $this->getRequest()->getPost();
        if(isset($newProducts['product']))
        {
            try
            {
                foreach($newProducts['product'] as $product)
                {
                    Mage::getModel('htmlcanvas/products')
                        ->setProductId((int)$product)
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_htmlcanvas')->__('Products Successfully Saved'));

            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }

        return $this->_redirect('*/*/products');
    }
    /* end products */

    /* user works */
    public function worksAction()
    {
        $this->_title($this->__('User Works'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function filterworksAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function editworkAction()
    {
        $this->_title($this->__('Edit Work'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }

    public function deleteworkAction()
    {
        $workId = (int)$this->getRequest()->getParam('id');
        $work = Mage::getModel('htmlcanvas/works')->load($workId);
        unlink(Mage::getBaseDir('media'). '/htmlcanvas/builds/'. $work->getImage());
        Mage::helper('codevog_htmlcanvas')->deleteImages($work->getJsonImages());
        $workModel = Mage::getModel('htmlcanvas/works')->setId($workId);
        $workModel->delete();

        return $this->_redirect('*/*/works');
    }
    public function saveworkAction()
    {
        $data = $this->getRequest()->getPost();

        if (!empty($data)) {
            try {
                Mage::getModel('htmlcanvas/works')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_htmlcanvas')->__('Work Successfully Updated'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/works');
    }

    /* end works */
    /* SIZES ACTIONS */
    public function sizesAction()
    {
        $this->_title($this->__('Sizes'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function filtersizesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function editsizeAction()
    {
        $this->_title($this->__('Edit Size'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function addsizeAction()
    {
        $this->_title($this->__('Add Size'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function deletesizeAction()
    {
        $size_id = (int)$this->getRequest()->getParam('id');
        $sizes_model = Mage::getModel('htmlcanvas/sizes')->setId($size_id);
        $sizes_model->delete();

        return $this->_redirect('*/*/sizes');
    }
    public function savesizeAction()
    {
        $data = $this->getRequest()->getPost();

        if (!empty($data)) {
            try {
                Mage::getModel('htmlcanvas/sizes')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_htmlcanvas')->__('Size successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/sizes');
    }
    /* end SIZES */

    /* pics categories */
    public function picscategoriesAction()
    {
        $this->_title($this->__('Pics Categories'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function filterpicscategoriesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function editpiccategoryAction()
    {
        $this->_title($this->__('Edit Pic Category'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function addpiccategoryAction()
    {
        $this->_title($this->__('Add Pic Category'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function deletepiccategoryAction()
    {
        $category_id = (int)$this->getRequest()->getParam('id');
        $category_model = Mage::getModel('htmlcanvas/piccategory')->setId($category_id);
        $category_model->delete();

        $subcategories = Mage::getModel('htmlcanvas/picsubcategory')->getCollection()->addFieldToFilter('pic_category_id', $category_id);
        foreach($subcategories as $subcategory)
        {
            $subcategory_id = $subcategory->getId();
            $subcategory_model = Mage::getModel('htmlcanvas/picsubcategory')->setId($subcategory_id);
            $subcategory_model->delete();

            $pics = Mage::getModel('htmlcanvas/pics')->getCollection()->addFieldToFilter('pic_subcategory_id', $subcategory_id);
            foreach($pics as $pic)
            {
                unlink(Mage::getBaseDir('media'). '/htmlcanvas/clipart/'. $pic->getPic());
                $pic_model = Mage::getModel('htmlcanvas/pics')->setId($pic->getId());
                $pic_model->delete();
            }
        }
        return $this->_redirect('*/*/picscategories');
    }
    public function savepiccategoryAction()
    {
        $data = $this->getRequest()->getPost();

        if (!empty($data)) {
            try {
                Mage::getModel('htmlcanvas/piccategory')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_htmlcanvas')->__('Pic Category successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/picscategories');
    }


    /* end pics categories */

    /* pics subcategories */
    public function picssubcategoriesAction()
    {
        $this->_title($this->__('Pics Subcategories'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function filterpicssubcategoriesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function editpicsubcategoryAction()
    {
        $this->_title($this->__('Edit Pic Subcategory'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function addpicsubcategoryAction()
    {
        $this->_title($this->__('Add Pic Subcategory'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function deletepicsubcategoryAction()
    {
        $subcategory_id = (int)$this->getRequest()->getParam('id');
        $subcategory_model = Mage::getModel('htmlcanvas/picsubcategory')->setId($subcategory_id);
        $subcategory_model->delete();

        $pics = Mage::getModel('htmlcanvas/pics')->getCollection()->addFieldToFilter('pic_subcategory_id', $subcategory_id);
        foreach($pics as $pic)
        {
            unlink(Mage::getBaseDir('media').'/htmlcanvas/clipart/'. $pic->getPic());
            $pic_model = Mage::getModel('htmlcanvas/pics')->setId($pic->getId());
            $pic_model->delete();
        }


        return $this->_redirect('*/*/picssubcategories');
    }
    public function savepicsubcategoryAction()
    {
        $data = $this->getRequest()->getPost();

        if (!empty($data)) {
            try {
                Mage::getModel('htmlcanvas/picsubcategory')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_htmlcanvas')->__('Pic Subcategory successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/picssubcategories');
    }


    /* end pics categories */

    /* pics upload */
    public function picsuploadAction()
    {
        $this->_title($this->__('Pics upload'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function filterpicsuploadAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function editpicuploadAction()
    {
        $this->_title($this->__('Edit Pic'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function addpicuploadAction()
    {
        $this->_title($this->__('Add Pic'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function deletepicuploadAction()
    {
        $pic_id = (int)$this->getRequest()->getParam('id');
        $pic = Mage::getModel('htmlcanvas/pics')->load($pic_id);
        unlink(Mage::getBaseDir('media'). '/htmlcanvas/clipart/'. $pic->getPic());
        $pic_model = Mage::getModel('htmlcanvas/pics')->setId($pic_id);
        $pic_model->delete();

        return $this->_redirect('*/*/picsupload');
    }
    public function savepicuploadAction()
    {
        $data = $this->getRequest()->getPost();

        if (!empty($data)) {



            if(isset($_FILES['pic']['name']) && $_FILES['pic']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('pic');

                    $uploader->setAllowedExtensions(array('gif','png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    //$uploader->setAllowCreateFolders(true);
                    $media_path  = Mage::getBaseDir('media').'/htmlcanvas/clipart';

                    // Upload the image
                    $new_name = $uploader->save($media_path, $_FILES['pic']['name']);

                    $data['pic'] = $new_name['file'];

                }
                catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('codevog_htmlcanvas')->__('Pic format must be *.png or *.gif'));
                }
            }

            try {
                Mage::getModel('htmlcanvas/pics')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_htmlcanvas')->__('Pic successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/picsupload');
    }


    /* end pics upload */
    /* user uploads */
    public function useruploadsAction()
    {
        $this->_title($this->__('User Uploads'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function filteruseruploadsAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function deleteUseruploadsAction()
    {
        $ids = $this->getRequest()->getParam('uploads');
        foreach($ids as $id)
        {
            $upload = Mage::getModel('htmlcanvas/useruploads')->load($id);
            unlink(Mage::getBaseDir('media'). '/htmlcanvas/uploads/'. $upload->getImage());
            $uploadModel = Mage::getModel('htmlcanvas/useruploads')->setId($id);
            $uploadModel->delete();
        }

        return $this->_redirect('*/*/useruploads');
    }
    /* user uploads end */
    /* about canvas text */
    public function aboutAction()
    {
        $this->_title($this->__('Messages'));
        $this->loadLayout();
        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function filteraboutAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function editaboutAction()
    {
        $this->_title($this->__('Edit Message'));
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

        $this->_setActiveMenu('codevog_htmlcanvas');
        $this->renderLayout();
    }
    public function saveaboutAction()
    {
        $data = $this->getRequest()->getPost();

        if (!empty($data)) {
            try {
                Mage::getModel('htmlcanvas/about')->setData($data)
                    ->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('codevog_htmlcanvas')->__('Message successfully saved'));
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
            }
        }
        return $this->_redirect('*/*/about');
    }

    /* about end */
}