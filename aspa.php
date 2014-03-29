<?php
require_once __DIR__.'/init.php';

$api=json_decode(file_get_contents('http://carto.strasmap.eu/remote.amf.json/Atmo.status'));
$towns=json_decode(file_get_contents('http://carto.strasmap.eu/remote.amf.json/Atmo.geometry'));

foreach ($api->s as $i=>$mesure) {
    foreach ($towns->s as $town) {
        if ($town->id == $mesure->id) {
            if (isset($_GET['tomorrow'])) {
                $legend[] = array(
                    'name'=>$town->ln,
                    'values'=>array($mesure->lp),
                    'color'=>$mesure->cp
                );
            } else {
                $legend[] = array(
                    'name'=>$town->ln,
                    'values'=>array($mesure->lc),
                    'color'=>$mesure->cc
                );
            }
        }
    }
}
$graph = array('legend'=>$legend, 'headers'=>'', 'dataset'=>array('table'=>'aspa', 'type'=>'Bar', 'unit'=>null, 'cat'=>'environnement'));
$smarty->assign('graph', $graph);
if (isset($_GET['tomorrow'])) {
    $smarty->assign('day', 'demain');
} else {
    $smarty->assign('day', "aujourd'hui");
}
$smarty->display('aspa.tpl');
?>
