<?php
class Data
{
    static private $_host = 'localhost';
    static private $_db = 'regards';
    static private $_user = '';
    static private $_pass = '';
    static private $_requests = array(
        'dettes'=>'SELECT Communes, REPLACE(`Dette par habitant`, ",", ".") FROM dettes ORDER BY Communes',
        'abo_biblio_ville'=>'SELECT COMMUNE, (`ABONNEMENTS RENOUVELES` + CREATIONS) FROM abo_biblio_ville ORDER BY COMMUNE ASC',
        'web_biblio'=>'SELECT * FROM web_biblio',
        'appels'=>'SELECT * FROM appels',
        'valeur_locative'=>'SELECT * FROM valeur_locative',
        'base_fiscale'=>'SELECT * FROM base_fiscale',
        'dotation'=>'SELECT * FROM dotation',
        'ordures'=>'SELECT * FROM ordures',
        'population'=>'SELECT * FROM population',
        'listes_electorales'=>'SELECT * FROM listes_electorales',
        'prenoms'=>'SELECT `Prénom`, Nombre FROM prenoms WHERE `Année` = 2012 ORDER BY Nombre DESC LIMIT 28',
        'etat_civil'=>'SELECT * FROM etat_civil',
        'courrier'=>'SELECT * FROM courrier',
        'dotations_ecoles'=>'SELECT * FROM dotations_ecoles',
        'cantine'=>'SELECT Type, (`Restauration / Ticket` + `Restauration / Abonnement` + Restauration + `Restauration / PAI` + `Restauration / Abonnement Panier Repas`) FROM cantine',
        'effectifs_scolaires'=>'SELECT "Effectifs", SUM(CP), SUM(CE1), SUM(CE2), SUM(CM1), SUM(CM2) FROM effectifs_scolaires',
        'periscolaire'=>'SELECT "Effectifs", SUM(`Tout-petits`), SUM(Petits), SUM(Moyens), SUM(Grands) FROM periscolaire',
        'emprunts'=>'SELECT CONCAT(Titre, " - ", Auteur), `Nombre de Prêts en 2O12` FROM emprunts ORDER BY `Nombre de Prêts en 2O12` DESC LIMIT 28'
    );
    
    static $_colors=array(
        '#ec2366',
        '#d31194',
        '#b60dc2',
        '#8c0cc1',
        '#7710b2',
        '#6010b2',
        '#1624db',
        '#1678db',
        '#1ebaed',
        '#44deff',
        '#35efff',
        '#19ecd1',
        '#19ec8b',
        '#33f541',
        '#5bff57',
        '#a9ff57',
        '#d2f74d',//
        '#e6f21f',
        '#f5e91c',
        '#fee11b',
        '#fed71e',
        '#fec81e',
        '#fe9820',
        '#fe6f20',
        '#fe3020',
        '#e31313',
        '#bb0a0a',
        '#990808'
    );
    
    function __construct ()
    {
        $this->pdo = new PDO(
            'mysql:host='.self::$_host.';dbname='.self::$_db,
            self::$_user, self::$_pass
        );
        $this->pdo->query("SET NAMES 'utf8';");
    }
    
    function getCats ()
    {
        $sth = $this->pdo->prepare('SELECT * FROM `categories`;');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function getDataSets ($cat)
    {
        $sth = $this->pdo->prepare('SELECT * FROM `datasets` WHERE `cat` = :cat;');
        $sth->execute(array(':cat'=>$cat));
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function getDataSet ($table)
    {
        $sth = $this->pdo->prepare('SELECT * FROM `datasets` WHERE `table` = :table;');
        $sth->execute(array(':table'=>$table));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    
    function getLabels ($dataset, $min=0)
    {
        $sth = $this->pdo->prepare('DESCRIBE '.$dataset);
        $sth->execute();
        $fields =$sth->fetchAll(PDO::FETCH_COLUMN);
        foreach ($fields as $i=>$field) {
            if ($i >= $min) {
                $labels[] = $field;
            }
        }
        return $labels;
    }
    
    function getData ($dataset, $type='Pie')
    {
        $sth = $this->pdo->prepare(self::$_requests[$dataset]);
        $sth->execute();
        $legend = '';
        $headers = array();
        if ($type=='Pie' || $type=='Doughnut') {
            $data = $sth->fetchAll(PDO::FETCH_NUM);
            foreach ($data as $i=>$item) {
                $values[] = array('value'=>floatval(preg_replace('/[^0-9.]/', '', str_replace(',', '.', $item[1]))),
                'color'=>self::$_colors[$i]);
                $legend[] = array('values'=>array(floatval(preg_replace('/[^0-9.]/', '', str_replace(',', '.', $item[1])))), 'name'=>$item[0],
                'color'=>self::$_colors[$i]);
            }
        } else if ($type=='Line') {
            $data = $sth->fetchAll(PDO::FETCH_NUM);
           $headers = $values['labels']=$this->getLabels($dataset);
            foreach ($data as $j=>$line) {
                $set = $legends = array();
                foreach ($line as $i=>$item) {
                    if ($i > 0) {
                        $set[] = floatval(preg_replace('/[^0-9.]/', '', str_replace(',', '.', $item)));
                        if (empty($item)) {
                            $item = '-';
                        }
                        $legends[] = $item;
                    }
                }
                $values['datasets'][] = array('fillColor'=>'transparent',
                    'strokeColor'=>self::$_colors[$j],
                    'pointColor'=>self::$_colors[$j],
                    'pointStrokeColor'=>'#FFF', 'data'=>$set);
                $legend[] = array('values'=>$legends, 'name'=>$line[0],
                'color'=>self::$_colors[$j]);
            }
        } else if ($type=='Bar') {
            $data = $sth->fetchAll(PDO::FETCH_NUM);
            $headers = $this->getLabels($dataset);
            $values['labels']=$this->getLabels($dataset, 1);
            foreach ($data as $j=>$line) {
                $set = $legends = array();
                foreach ($line as $i=>$item) {
                    if ($i > 0) {
                        $set[] = floatval(preg_replace('/[^0-9.]/', '', str_replace(',', '.', $item)));
                        if (empty($item)) {
                            $item = '-';
                        }
                        $legends[] = floatval(preg_replace('/[^0-9.]/', '', str_replace(',', '.', $item)));
                    }
                }
                $values['datasets'][] = array(
                    'strokeColor'=>self::$_colors[$j],
                    'fillColor'=>self::$_colors[$j],
                    'data'=>$set);
                $legend[] = array('values'=>$legends, 'name'=>$line[0],
                'color'=>self::$_colors[$j]);
            }
        } else if ($type=='Line2') {
            $data = $sth->fetchAll(PDO::FETCH_NUM);
            $cols = $this->getLabels($dataset);
            foreach ($cols as $j=>$col) {
                $legend[$j] = array('values'=>'', 'name'=>$col,
                'color'=>self::$_colors[$j]);
            }
            foreach ($data as $j=>$line) {
                $set = array();
                foreach ($line as $i=>$item) {
                    if ($i > 0) {
                        $item = preg_replace('/[^0-9]/', '', $item);
                        if (empty($item)) {
                            $sets[$i][] = '';
                        } else {
                            $sets[$i][] = floatval($item);
                        }
                    } else {
                        $headers[] = $values['labels'][] = $item;
                    }
                }
                
            }
            foreach ($sets as $i=>$set) {
                $legend[$i-1]['values'] = $set;
                $values['datasets'][] = array(
                    'fillColor'=>'transparent',
                    'strokeColor'=>self::$_colors[$i],
                    'pointColor'=>self::$_colors[$i],
                    'pointStrokeColor'=>'#FFF', 'data'=>$set);
            }
        }
        
        return array('values'=>$values, 'legend'=>$legend, 'headers'=>$headers);
    }
    
    function getCatName ($cat)
    {
        $sth = $this->pdo->prepare('SELECT title FROM `categories` WHERE `id` = :cat;');
        $sth->execute(array(':cat'=>$cat));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
}
?>
