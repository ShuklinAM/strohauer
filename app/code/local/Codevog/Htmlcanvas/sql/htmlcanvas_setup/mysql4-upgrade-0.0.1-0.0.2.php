<?php
$installer = $this;

$installer->startSetup();

$installer->run("alter table {$this->getTable('htmlcanvas_user_uploads')} add date  date;");

$installer->run("alter table {$this->getTable('htmlcanvas_works')} add show_template  int(10) not null;");

$installer->endSetup();
?>