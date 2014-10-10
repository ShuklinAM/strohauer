<?php
class Codevog_Htmlcanvas_Helper_Data extends Mage_Core_Helper_Abstract
{

    public $cmToPxCof = 37.795276;
    public $pxToCmCof = 0.02645833;
    public $cofSize = 364;

    public function isActive()
    {
        /*create Mage store config for template*/
        return $this->getConfig('enabled');
    }

    public function canShow()
    {
        $item = $this->getCurrentItem();
        if($this->isActive() && Mage::getModel('htmlcanvas/products')->isActiveProduct($item->getId()))
            return true;
        return false;
    }

    public function getCurrentIp()
    {
        return Mage::helper('core/http')->getRemoteAddr(false);
    }

    public function getCurrentItem()
    {
        $product = Mage::registry('current_product');

        if(!$product)
        {
            $id = Mage::app()->getRequest()->getParam('id');
            if(!$id)
                $id = Mage::app()->getRequest()->getPost('id');

            $product = Mage::getModel('catalog/product')->load($id);

        }

        return $product;
    }

    public function isLessIE9()
    {
        return preg_match('/(?i)msie [5-8]/',$_SERVER['HTTP_USER_AGENT']);
    }

    public function getCurrentOrder()
    {
        return Mage::getModel('sales/order')->load(Mage::app()->getRequest()->getParam('order_id'));
    }
    public function getBuildByIp($itemId = null)
    {
        if(!$itemId)
        {
            $item = $this->getCurrentItem();
            $itemId = $item->getId();
        }
        if($itemId)
        {
            $ip = $this->getCurrentIp();
            $buildModel = Mage::getModel('htmlcanvas/works');
            $build = $buildModel->getCollection()->addFieldToFilter('item_id', $itemId)->addFieldToFilter('ip',$ip)->addFieldToFilter('done',0)->getFirstItem();

            if($build->getId())
                return $build;
            return false;
        }
        return false;
    }
    public function getCanvasSizes()
    {
        return Mage::getModel('htmlcanvas/sizes')->getCollection()->setOrder('position','asc');
    }
    public function getFontFamilies()
    {
        return array
        (
            "'Kotta One', serif"                    => "'Kotta One', serif",
            "'Fenix', serif"                        => "'Fenix', serif",
            "'Domine', serif"                       => "'Domine', serif",
            "'Galindo', cursive"                    => "'Galindo', cursive",
            "'Habibi', serif"                       => "'Habibi', serif",
            "'ABeeZee', sans-serif"                 => "'ABeeZee', sans-serif",
            "'Gilda Display', serif"                => "'Gilda Display', serif",
            "'Acme', sans-serif"                    => "'Acme', sans-serif",
            "'Rufina', serif"                       => "'Rufina', serif",
            "'Oleo Script Swash Caps', cursive"     => "'Oleo Script Swash Caps', cursive",
            "'Petit Formal Script', cursive"        => "'Petit Formal Script', cursive",
            "'Molle', cursive"                      => "'Molle', cursive",
            "'Yesteryear', cursive"                 => "'Yesteryear', cursive",
            "'Bitter', serif"                       => "'Bitter', serif",
            "'Wendy One', sans-serif"               => "'Wendy One', sans-serif",
            "'Skranji', cursive"                    => "'Skranji', cursive",
            "'Elsie Swash Caps', cursive"           => "'Elsie Swash Caps', cursive",
            "'Marcellus', serif"                    => "'Marcellus', serif",
            "'Libre Baskerville', serif"            => "'Libre Baskerville', serif",
            "'Metal Mania', cursive"                => "'Metal Mania', cursive",
            "'Clicker Script', cursive"             => "'Clicker Script', cursive",
            "'Amethysta', serif"                    => "'Amethysta', serif",
            "'Purple Purse', cursive"               => "'Purple Purse', cursive",
            "'Jacques Francois Shadow', cursive"    => "'Jacques Francois Shadow', cursive",
            "'Pirata One', cursive"                 => "'Pirata One', cursive",
            "'Griffy', cursive"                     => "'Griffy', cursive",
            "'Roboto Condensed', sans-serif"        => "'Roboto Condensed', sans-serif",
            "'Ranchers', cursive"                   => "'Ranchers', cursive",
            "'Roboto', sans-serif"                  => "'Roboto', sans-serif",
            "'Merienda', cursive"                   => "'Merienda', cursive",
            "'Junge', serif"                        => "'Junge', serif",
            "'Julius Sans One', sans-serif"         => "'Julius Sans One', sans-serif",
            "'Happy Monkey', cursive"               => "'Happy Monkey', cursive",
            "'Lemon', cursive"                      => "'Lemon', cursive",
            "'Sacramento', cursive"                 => "'Sacramento', cursive",
            "'Lusitana', serif"                     => "'Lusitana', serif",
            "'Playfair Display SC', serif"          => "'Playfair Display SC', serif",
            "'Marko One', serif"                    => "'Marko One', serif",
            "'Seaweed Script', cursive"             => "'Seaweed Script', cursive",
            "'Herr Von Muellerhoff', cursive"       => "'Herr Von Muellerhoff', cursive"
        );

//        return array
//        (
//            "Arial" => "Arial",
//            "Georgia" => "Georgia",
//            "Times New Roman" => "Times New Roman",
//        );
    }


    public function getFontSizes()
    {
        $fontSizes = array();
        for($i = 10;$i <= 40;$i ++ )
        {
            $fontSizes[$i.'px'] = $i.'px';
        }
        return $fontSizes;
    }

    function saveStage($json,$imageArray,$picNum,$canvas,$itemId,$size)
    {
        $build = $this->getBuildByIp($itemId);
        if($build)
        {
            $build->setLastUpdate(date("Y-m-d"));
        }
        else
        {
            $build = Mage::getModel('htmlcanvas/works');
            $build->setCreateDate(date("Y-m-d"));
            $build->setLastUpdate(date("Y-m-d"));
            $build->setItemId($itemId);
            $build->setIp($this->getCurrentIp());
            $build->setOrderId(0);
            $build->setDone(0);
        }

            $build->setJsonOptions($json);
            $build->setPicNum($picNum);
            $build->setSizeId($size);

            $build->save();
            $build = $this->getBuildByIp($itemId);
            $insertedId = $build->getId();

           // $build = Mage::getModel('htmlcanvas/works')->load($insertedId);
            $imageArray = $this->createImages($insertedId,$imageArray);
            if($build->getJsonImages())
                $this->deleteImages($build->getJsonImages(),$imageArray);
            $imageJson = json_encode($imageArray);
            $build->setJsonImages($imageJson);

            $imagePath =  Mage::getBaseDir('media').'/htmlcanvas/builds/build_'.$insertedId.'.png';
            $uri =  substr($canvas,strpos($canvas,",")+1);
            file_put_contents($imagePath, base64_decode($uri));

        if (file_exists($imagePath)) :
            $src = imagecreatefrompng($imagePath);
            $imageSize = getimagesize($imagePath);

            $sizeInfo = Mage::getModel('htmlcanvas/sizes')->load($size);

            $dst = imagecreatetruecolor((int)$this->cmToPx($sizeInfo->getWidth()), (int)$this->cmToPx($sizeInfo->getHeight()));
            imagecopyresized($dst, $src, 0, 0, 0, 0, (int)$this->cmToPx($sizeInfo->getWidth()), (int)$this->cmToPx($sizeInfo->getHeight()), $imageSize[0],$imageSize[1]);
            imagepng($dst,$imagePath);
        endif;
            $build->setImage('build_'.$insertedId.'.png');
            $build->save();

    }

    function deleteImages($imageJson,$newImages = null)
    {
        $imagePath = Mage::getBaseDir('media').'htmlcanvas/imageparts/';
        $imageObjects = json_decode($imageJson);
        if($newImages)
        {
            foreach($imageObjects as $key => $image)
            {
                $isOld = 0;
                foreach($newImages as $newImage)
                {
                    if($newImage['image'] == $imageObjects[$key]->image)
                    {
                        $isOld = 1;
                        break;
                    }
                }
                if($isOld == 0)
                {
                    unlink($imagePath.$imageObjects[$key]->image);
                }
            }
        }
        else
        {
            foreach($imageObjects as $key => $image)
            {
                unlink($imagePath.$imageObjects[$key]->image);
            }
        }
    }

    function createImages($id,$imageArray)
    {
        foreach($imageArray as $key => $image)
        {
            $imagePath = Mage::getBaseDir('media').'/htmlcanvas/imageparts/pic_'.$id.'_'.$image['id'].'.png';
            file_put_contents($imagePath, file_get_contents($image['image']));
            $imageArray[$key]['image'] = 'pic_'.$id.'_'.$image['id'].'.png';
        }
        return $imageArray;
    }
    function cmToPx($cm)
    {
        return (int)(($cm * $this->cmToPxCof));
    }
        function pxToCm($px)
    {
        return (int)(($px * $this->pxToCmCof));
    }
    function convertCmPxCm($cm)
    {
        $cm = $this->cmToPx($cm);
        return $this->pxToCm($cm);
    }
    public function getBuildImageUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/htmlcanvas/builds/';
    }
    public function getCurrencySymbol(){
        return Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    }
    public function convertPrice($float)
    {
        return number_format(round($float,2),2,".",",");
    }
    public function getTexts($jsonOptions)
    {
        $elementsArray = json_decode($jsonOptions);
        $textArray = array();
        foreach($elementsArray->children[0]->children as $element)
        {
            if($element->shapeType == 'Text')
            {
                $textArray[] = $element->attrs->text;
            }
        }
        return $textArray;
    }

    public function getBuildByOrder($orderId,$itemId)
    {
            $buildModel = Mage::getModel('htmlcanvas/works');
            $build = $buildModel->getCollection()->addFieldToFilter('item_id', $itemId)->addFieldToFilter('order_id',$orderId)->addFieldToFilter('done',1)->getFirstItem();
            if($build->getId())
                return $build;
            return false;
    }

    public function getConfig($field)
    {
        return Mage::getStoreConfig("templatesettings/htmlcanvas_config/".$field);
    }
    public function getAbout($alias)
    {
        return Mage::getModel('htmlcanvas/about')->getCollection()->addFieldToFilter('alias',$alias)->getFirstItem()->getText();
    }
    public function getUserUploadsNum()
    {
        $ip = $this->getCurrentIp();
        return Mage::getModel('htmlcanvas/useruploads')->getCollection()->addFieldToFilter('ip',$ip)->getSize();
    }
}
?>