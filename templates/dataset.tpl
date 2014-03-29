<!Doctype HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>{$graph.dataset.title} - Regards sur Strasbourg</title>
{include file='head.tpl'}
</head>
<body data-role="page">
<header data-role="header" class="small_header">
<a data-corners="false" data-direction="reverse" href="cat.php?cat={$graph.dataset.cat}" rel="back" data-transition="slide" class="back"><img src="img/back.png" alt="Retour" /></a>
<h1 class="small_title"><a href="index.php"><img src="img/logo_small.png" alt="Regards sur Strasbourg" /></a></h1>
    </header>
    <h2>{$graph.dataset.title}</h2>
<div data-role="content">
<canvas class="graph" id="{$graph.dataset.table}" data-data="{$graph.data}" data-type="{$graph.dataset.type}" width="600" height="300">

</canvas>
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
