<?php

$code = 'zutaten';
$label = 'Zutaten';

$setup = Mage::getModel('catalog/resource_eav_attribute');

$attribute = array (
    'attribute_code' => $code,
    'backend_type'  => 'text',
    'frontend_input' => 'textarea',
    'frontend_label' => $label,
    'is_required' => '0',
    'is_user_defined' => '1',
    'is_unique' => '0',
    'is_global' => '1',
    'is_visible' => '1',
    'is_searchable' => '0',
    'is_filterable' => '0',
    'is_comparable' => '0',
    'is_visible_on_front' => '0',
    'used_in_product_listing' => '1',
    'is_html_allowed_on_front' => '1',
    'is_used_for_price_rules' => '1',
    'is_filterable_in_search' => '0',
    'is_configurable' => '0',
    'is_visible_in_advanced_search' => '0',
    'wysiwyg_enabled' => '1',
    'is_wysiwyg_enabled' => '1',
    'is_used_for_promo_rules' => '0',
);

$setup->setData($attribute);
$setup->setEntityTypeId(Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId());
$setup->save();