<?php


require_once Mage::getModuleDir('controllers', 'Codevog_Brands').DS.'IndexController.php';

class Mana_Filters_BrandsController extends Codevog_Brands_IndexController
{
    public function rootAction()
    {
        if ($category = $this->_initCatagory()) {
            $design = Mage::getSingleton('catalog/design');
            $settings = $design->getDesignSettings($category);

            // apply custom design
            if ($settings->getCustomDesign()) {
                $design->applyCustomDesign($settings->getCustomDesign());
            }

            Mage::getSingleton('catalog/session')->setLastViewedCategoryId($category->getId());

            $update = $this->getLayout()->getUpdate();
            $update->addHandle('default');

            if (!$category->hasChildren()) {
                $update->addHandle('catalog_category_layered_nochildren');
            }

            $this->addActionLayoutHandles();
            $update->addHandle($category->getLayoutUpdateHandle());
            $update->addHandle('CATEGORY_' . $category->getId());
            $this->loadLayoutUpdates();

            // apply custom layout update once layout is loaded
            if ($layoutUpdates = $settings->getLayoutUpdates()) {
                if (is_array($layoutUpdates)) {
                    foreach($layoutUpdates as $layoutUpdate) {
                        $update->addUpdate($layoutUpdate);
                    }
                }
            }

            $this->generateLayoutXml()->generateLayoutBlocks();
            // apply custom layout (page) template once the blocks are generated
            if ($settings->getPageLayout()) {
                $this->getLayout()->helper('page/layout')->applyTemplate($settings->getPageLayout());
            }

            if ($root = $this->getLayout()->getBlock('root')) {
                $root->setTemplate('mana/filters/ajax_page/category_ajaxtemplate.phtml');
                $root->addBodyClass('categorypath-' . $category->getUrlPath())
                    ->addBodyClass('category-' . $category->getUrlKey());
            }

            $crumbs = $this->getLayout()->getBlock('breadcrumbs');
            $crumbs->addCrumb('home', array(
                'label' => $this->__('Home'),
                'title' => $this->__('Home'),
                'link' => Mage::getUrl('')
            ));
            $crumbs->addCrumb('brands', array(
                'label' => Mage::helper('codevog_brands')->getBrandTitle(),
                'title' => Mage::helper('codevog_brands')->getBrandTitle(),
            ));

            $this->_initLayoutMessages('catalog/session');
            $this->_initLayoutMessages('checkout/session');
            $this->renderLayout();
        }
        elseif (!$this->getResponse()->isRedirect()) {
            $this->_forward('noRoute');
        }
    }
}