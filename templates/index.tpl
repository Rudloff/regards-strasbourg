<!Doctype HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Regards sur Strasbourg</title>
{include file='head.tpl'}
</head>
<body data-role="page" class="index">
<header data-role="header">
    <h1 class="title"><img src="img/logo.png" alt="Regards sur Strasbourg" /></h1>
    </header>
    <h2>Choisissez une catégorie</h2>
    <nav>
    <ul class="cats ui-grid-b">
    {foreach from=$cats item=cat}
        <li class="{$cat.id} {$cat.grid}"><a href="cat.php?cat={$cat.id}"><div class="cat_icon"><!--<img src="img/cats/{$cat.id}.png" alt=""/>--></div><div class="triangle"></div><span class="title">{$cat.title}</span></a></li>
    {/foreach}
    <li class="environnement"><a href="environnement.php"><div class="cat_icon"></div><div class="triangle"></div><span class="title">Environnement</span></a></li>
    </ul>
    </nav>

</body>
</html>
