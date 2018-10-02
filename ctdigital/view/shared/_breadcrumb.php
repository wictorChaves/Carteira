<?php

namespace view\shared;

use core\UrlHelper;
use tela\InfoView;

$urlHelper = new UrlHelper();
$infoView = new InfoView("view" . DIRECTORY_SEPARATOR . $urlHelper->getController() . DIRECTORY_SEPARATOR . "index.php");

//Pega o icone
$icon = 'fa-circle-thin';
if (!is_null($infoView->getIconMenuPrincipal())) {
    $icon = $infoView->getIconMenuPrincipal();
}

//Pega o titulo do menu
$menuPrincipal = $urlHelper->getController();
if (!is_null($infoView->getTituloMenuPrincipal())) {
    $menuPrincipal = $infoView->getTituloMenuPrincipal();
}

$infoView->setCaminho("view" . DIRECTORY_SEPARATOR . $urlHelper->getController() . DIRECTORY_SEPARATOR . $urlHelper->getView() . ".php");

//Pega o titulo da view
$tituloView = $urlHelper->getView();
if (!is_null($infoView->getTituloView())) {
    $tituloView = $infoView->getTituloView();
}
?>

<section class="content-header">
    <h1>
        <?php echo ucfirst($menuPrincipal) ?>
        <small><?php echo ucfirst($tituloView) ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="../../<?php echo $urlHelper->getController() ?>/index"><i class="fa <?php echo $icon ?>"></i> <?php echo ucfirst($menuPrincipal) ?></a></li>
        <li class="active"><?php echo ucfirst($tituloView) ?></li>
    </ol>
</section>