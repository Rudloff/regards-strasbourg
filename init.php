<?php
require_once __DIR__.'/Data.php';
require_once __DIR__.'/smarty/libs/Smarty.class.php';
require_once __DIR__.'/init.php';

$sql = new Data();
$smarty = new Smarty();
$smarty->template_dir =__DIR__.'/templates/';
?>
