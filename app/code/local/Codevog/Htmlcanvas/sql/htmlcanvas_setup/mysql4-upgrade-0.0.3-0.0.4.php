<?php
$installer = $this;

$installer->startSetup();

/* options */
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_products')};
CREATE TABLE {$this->getTable('htmlcanvas_products')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `product_id` varchar(150) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup();
?>