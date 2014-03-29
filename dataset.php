<?php
require_once __DIR__.'/init.php';

$dataset = $sql->getDataSet($_GET['data']);
$data = $sql->getData($dataset['table'], $dataset['type']);
$graph = array('data'=>rawurlencode(json_encode($data['values'])), 'dataset'=>$dataset, 'legend'=>$data['legend'], 'headers'=>$data['headers']);

$smarty->assign('graph', $graph);
$smarty->display('dataset.tpl');
?>
