<!Doctype HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Qualité de l'air ({$day}) - Regards sur Strasbourg</title>
{include file='head.tpl'}
</head>
<body data-role="page">
<header data-role="header" class="small_header">
<a data-corners="false" data-direction="reverse" href="{$graph.dataset.cat}.php" rel="back" data-transition="slide" class="back"><img src="img/back.png" alt="Retour" /></a>
<h1 class="small_title"><a href="index.php"><img src="img/logo_small.png" alt="Regards sur Strasbourg" /></a></h1>
    </header>
    <h2>Qualité de l'air ({$day})</h2>
<div data-role="content">
<table class="results ui-responsive" data-role="table">
<thead>
<tr>
{foreach from=$graph.headers item=header}
<th>{$header}</th>
{/foreach}
</tr></thead>
<tbody>
{foreach from=$graph.legend item=item}
    <tr><th style="background-color: {$item.color};">{$item.name}</th>
    {foreach from=$item.values item=value}
        <td  style="background-color: {$item.color};">{$value}&nbsp;{$graph.dataset.unit}</td>
    {/foreach}
    </tr>
{/foreach}
</tbody>
</table>
</div>
</body>
</html>
