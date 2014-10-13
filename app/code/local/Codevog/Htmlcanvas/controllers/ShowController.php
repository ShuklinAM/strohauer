<?php
class Codevog_Htmlcanvas_ShowController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $item = Mage::helper('codevog_htmlcanvas')->getCurrentItem();
        if($item->getId())
        {
            Mage::register('current_product',$item);
            $this->loadLayout();
            $this->renderLayout();
        }
        else
            $this->_redirect('error404');
    }
    public function loadimagesAction()
    {

        if($this->getRequest()->getParam('model'))
        {
            $this->loadLayout();
            $this->renderLayout();
        }
    }
    public function  useruploadAction()
    {

        if(isset($_FILES['files']['name']) && $_FILES['files']['name'] != '') {
            try {
                $uploader = new Varien_File_Uploader('files');

                $uploader->setAllowedExtensions(array('bmp','jpg','gif','png','jpeg'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                //$uploader->setAllowCreateFolders(true);
                // Set media as the upload dir
                $media_path  = Mage::getBaseDir('media').'/htmlcanvas/uploads';

                // Upload the image
                $new_name = $uploader->save($media_path, $_FILES['files']['name']);


                //$newWidth = 600;
                //$imageSize = getimagesize($media_path.$new_name['file']);

                //$cof = $newWidth/ $imageSize[0];
                //$newHeight = $cof *  $imageSize[1];

                //$src = imagecreatefromjpeg($media_path.$new_name['file']);
                //$dst = imagecreatetruecolor($newWidth, $newHeight);
                //imagecopyresized($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imageSize[0],$imageSize[1]);
                //imagejpeg($dst,$media_path.$new_name['file']);
                $data['image'] = $new_name['file'];
                $data['ip'] = Mage::helper('codevog_htmlcanvas')->getCurrentIp();
                $data['date'] = date("Y-m-d");
                Mage::getModel('htmlcanvas/useruploads')->setData($data)
                    ->save();
            }
            catch (Exception $e) {
                print_r($e);
                die;
            }
        }
    }

    public function savedesignAction()
    {
        $json = $this->getRequest()->getPost('stageJson');
        $imageArray = $this->getRequest()->getPost('images');
        $picNum = $this->getRequest()->getPost('lastPicId');
        $canvas = $this->getRequest()->getPost('canvas');
        $itemId = $this->getRequest()->getPost('itemId');
        $size = $this->getRequest()->getPost('size');

        Mage::helper('codevog_htmlcanvas')->saveStage($json,$imageArray,$picNum,$canvas,$itemId,$size);
    }
    public function removeAction()
    {
        $workId = (int)$this->getRequest()->getParam('id');
        $work = Mage::getModel('htmlcanvas/works')->load($workId);
        unlink(Mage::getBaseDir('media'). '/htmlcanvas/builds/'. $work->getImage());
        Mage::helper('codevog_htmlcanvas')->deleteImages($work->getJsonImages());
        $workModel = Mage::getModel('htmlcanvas/works')->setId($workId);
        $workModel->delete();

        $itemId = (int)$this->getRequest()->getParam('item_id');
        $item = Mage::getModel('catalog/product')->load($itemId);
        return $this->getResponse()->setRedirect($item->getProductUrl());
    }
}
?>