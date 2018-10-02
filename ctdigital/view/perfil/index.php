<?php
use core\SessionVO;
$perfil = '';
if ($_SESSION[SessionVO::$TIPO] == 'cnpj') {
    $perfil = 'Empresa';
} else {
    $perfil = 'Trabalhador';
}
?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Perfil <?php echo $perfil; ?></div>
    <div id="_tituloMenuPrincipal">Perfil</div>
    <div id="_tituloView">Informações</div>
    <div id="_icon">fa-user</div>
</div>
<?php
if ($_SESSION[SessionVO::$TIPO] == 'cnpj') {
    include '_conteudo_empresa.php';
} else {
    include '_conteudo_funcionario.php';
}
?>