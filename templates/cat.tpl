<!Doctype HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>{$cat} - Regards sur Strasbourg</title>
{include file='head.tpl'}
</head>
<body data-role="page">
<header data-role="header" class="small_header">
<a data-corners="false" data-direction="reverse" href="index.php" data-transition="slide" rel="back" class="back"><img src="img/back.png" alt="Retour" /></a>
<h1 class="small_title"><a href="index.php"><img src="img/logo_small.png" alt="Regards sur Strasbourg" /></a></h1>
    </header>
    <h2>{$cat}</h2>
    <div data-role="content">
    <ul class="catlist" data-role="listview">
    {foreach from=$datalist item=dataset}
    <li><a data-transition="slide" href="dataset.php?data={$dataset.table}" class="{$dataset.cat}">{$dataset.title}<div class="triangle_right_wrapper"><div class="triangle_right"></div></div></a></li>
    {/foreach}
    </ul>
    </div>
</body>
</html>
