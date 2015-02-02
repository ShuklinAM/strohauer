<?php
$installer = $this;

$installer->startSetup();

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('delivery_days')};
CREATE TABLE {$this->getTable('delivery_days')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(50) NOT NULL,
 `disable` int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

$installer->run("INSERT INTO {$this->getTable('delivery_days')} (`name`,`disable`) VALUES
('Sunday',0),
('Monday',0),
('Tuesday',0),
('Wednesdey',0),
('Thursday',0),
('Friday',0),
('Saturday',0);");

$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('delivery_dates')};
CREATE TABLE {$this->getTable('delivery_dates')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `date` DATE NOT NULL,
 `disable` varchar(150) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");


$installer->run("ALTER TABLE {$this->getTable('delivery_dates')} ADD UNIQUE (
`date`
)");




$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('delivery_minimumdays')};
CREATE TABLE {$this->getTable('delivery_minimumdays')} (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `num`  int(10) unsigned NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ");

$installer->run("INSERT INTO {$this->getTable('delivery_minimumdays')} (`num`) VALUES(0)");





/*$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('order', 'deliverycomment', array(
    'position'      => 1,
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Delivery comment',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'global'        => 1,
    'visible_on_front'  => 1,
));*/



$installer->endSetup();
?>
