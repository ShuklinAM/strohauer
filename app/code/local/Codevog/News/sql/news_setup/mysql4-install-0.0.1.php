<?php
$installer = $this;

$installer->startSetup();

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('news_list')};
CREATE TABLE {$this->getTable('news_list')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `image` varchar(150) NOT NULL,
 `short_description` text NOT NULL,
 `description` text NOT NULL,
 `start_date` datetime NOT NULL,
 `finish_date` datetime NOT NULL,
 `title` varchar(150) NOT NULL,
 `name` varchar(150) NOT NULL,
 `enabled` int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");


$installer->endSetup();


?>
