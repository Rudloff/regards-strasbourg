<?php
require_once __DIR__.'/init.php';

$datasets = $sql->getDataSets($_GET['cat']);
$cat = $sql->getCatName($_GET['cat']);
$smarty->assign('datalist', $datasets);
$smarty->assign('cat', $cat['title']);
$smarty->display('cat.tpl');
?>
