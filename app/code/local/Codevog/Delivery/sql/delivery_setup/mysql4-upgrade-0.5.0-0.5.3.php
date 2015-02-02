<?php
$installer = $this;

$installer->startSetup();
$installer->run("alter table {$this->getTable('sales/order')} add customer_comments text;");

//$installer->run(" insert into eav_attribute(`entity_type_id`,`attribute_code`,`attribute_model`,`backend_model`,`backend_type`,`backend_table`,`frontend_model`,`frontend_input`,`frontend_input_renderer`,`frontend_label`,`frontend_class`,`source_model`,`is_required`) values(11, 'customercomments', null, '', 'text', '', '', 'text', '','',1);");



$setup = new Mage_Eav_Model_Entity_Setup('core_setup');


$setup->addAttribute('order', 'customer_comments', array(
    'position'      => 1,
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Choose delivery date',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'global'        => 1,
    'visible_on_front'  => 1,
));


$installer->endSetup();
?>
