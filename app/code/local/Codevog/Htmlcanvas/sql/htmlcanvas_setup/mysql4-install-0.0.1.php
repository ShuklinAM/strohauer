<?php
$installer = $this;

$installer->startSetup();

/* categories for pics */

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_pic_category')};
CREATE TABLE {$this->getTable('htmlcanvas_pic_category')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(150) NOT NULL,
 `position` int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

/* subcategories for pics */
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_pic_subcategory')};
CREATE TABLE {$this->getTable('htmlcanvas_pic_subcategory')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `pic_category_id` int(10) unsigned NOT NULL,
 `name` varchar(150) NOT NULL,
 `position` int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

/* pics */
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_pics')};
CREATE TABLE {$this->getTable('htmlcanvas_pics')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `pic_subcategory_id` int(10) unsigned NOT NULL,
 `pic` varchar(255) NOT NULL,
 `name` varchar(150) NOT NULL,
 `position` int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

/* works */
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_works')};
CREATE TABLE {$this->getTable('htmlcanvas_works')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `ip` varchar(255) NOT NULL,
 `item_id` int(10) unsigned NOT NULL,
 `order_id` int(10) unsigned NOT NULL,
 `last_update` date NOT NULL,
 `create_date` date NOT NULL,
 `done` int(10) unsigned NOT NULL,
 `json_options` text NOT NULL,
 `json_images` text NOT NULL,
 `image` varchar(255) NOT NULL,
 `pic_num` int(10) unsigned NOT NULL,
 `size_id` int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

/* sizes */
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_sizes')};
CREATE TABLE {$this->getTable('htmlcanvas_sizes')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `width` float(10) unsigned NOT NULL,
 `height` float(10) unsigned NOT NULL,
 `workspace_width` float(10) unsigned NOT NULL,
 `workspace_height` float(10) unsigned NOT NULL,
 `position` int(10) unsigned NOT NULL,
 `shape` varchar(255) NOT NULL,
 `price_rule` float(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

/* user uploads */
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('htmlcanvas_user_uploads')};
CREATE TABLE {$this->getTable('htmlcanvas_user_uploads')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `ip` varchar(255) NOT NULL,
 `image` varchar(150) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup();
?>