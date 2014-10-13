<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

$installer = $this;
$installer->startSetup();
$installer->endSetup();

try {
//create pages and blocks programmatically

//Custom Tab
$staticBlock = array(
    'title' => 'Custom Tab',
    'identifier' => 'template_custom_tab',
    'content' => "<p><strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Custom Block
$staticBlock = array(
    'title' => 'Custom Block',
    'identifier' => 'template_navigation_block',
    'content' => "<p><strong>Lorem Ipsum</strong><span>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Empty Category
$staticBlock = array(
    'title' => 'Empty Category',
    'identifier' => 'template_empty_category',
    'content' => "<p>There are no products matching the selection.<br/> This is a static CMS block displayed if category is empty. You can put your own content here.</p>",
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Informational block under product tabs
$staticBlock = array(
    'title' => 'Informational block under product tabs',
    'identifier' => 'template_after_tabs',
    'content' => '<p class="dotted-border"> This is a static CMS block displayed after product tabs. You can put your own content here or disable block to hide it</p>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Template Bottom Support block
$staticBlock = array(
    'title' => 'Template Bottom Support block',
    'identifier' => 'template_bottom_support',
    'content' => '<div class="site-block bottom"><a href="http://codevog.com/products/magento/"><img src="{{media url="codevog/template/live_support.png"}}" alt="" /></a></div>',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();

//Template Store Logo
$staticBlock = array(
    'title' => 'Template Store Logo',
    'identifier' => 'template_logo',
    'content' => '<img src="{{media url="codevog/template/logo.png"}}" alt="Template Store" />',
    'is_active' => 1,
    'stores' => array(0)
);
Mage::getModel('cms/block')->setData($staticBlock)->save();


}
catch (Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while installing template theme pages and cms blocks.'));
}