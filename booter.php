<?php 

require 'Auto_Loader.php';
$auto_loader = new Auto_Loader();

$auto_loader->set_dir( 'core' );
$auto_loader->set_dir( 'models' );
$auto_loader->autoLoad();