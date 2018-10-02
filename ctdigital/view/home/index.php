<?php
use core\SessionVO;
?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Página Inicial</div>
    <div id="_tituloMenuPrincipal">Home</div>
    <div id="_tituloView">Página Home</div>
    <div id="_icon">fa-home</div>
    <div id="_menuOff">Página Sem Menu</div>
</div>
<?php
if ($_SESSION[SessionVO::$TIPO] == 'cnpj') {
    include '\..\perfil\_conteudo_empresa.php';
} else {
    include '\..\perfil\_conteudo_funcionario.php';
}
?>
