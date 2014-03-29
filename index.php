<?php
require_once __DIR__.'/init.php';

$cats = $sql->getCats();
$grid = array('ui-block-a', 'ui-block-b', 'ui-block-c');
$i = 0;
foreach ($cats as &$cat) {
    $cat['grid'] = $grid[$i];
    $i++;
    if ($i >= 3) {
        $i = 0;
    }
}
$smarty->assign('cats', $cats);
$smarty->display('index.tpl');

?>

