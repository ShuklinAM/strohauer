<?php
$installer = $this;

$installer->startSetup();

/* options */
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_about')};
CREATE TABLE {$this->getTable('htmlcanvas_about')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(150) NOT NULL,
 `alias` varchar(150) NOT NULL,
 `text` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->run("INSERT INTO {$this->getTable('htmlcanvas_about')} (`alias`,`name`,`text`) VALUES
('about_message','About Htmlcanvas',''),
('browser_message','Not Support Browser Message','')
;");

$installer->endSetup();
?>