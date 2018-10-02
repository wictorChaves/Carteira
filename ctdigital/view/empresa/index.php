<?php

use core\StringHelper;
use model\EstadosModel;

$estados = new EstadosModel();
$empresa = $_pagina['model'];
?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Perfil da empresa</div>
    <div id="_tituloMenuPrincipal">Perfil</div>
    <div id="_tituloView">Perfil empresa</div>
    <div id="_icon">fa-home</div>
    <div id="_menuOff">Página Sem Menu</div>
</div>
<?php
include '\..\perfil\_conteudo_empresa.php';

