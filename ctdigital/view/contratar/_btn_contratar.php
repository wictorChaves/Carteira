<?php

use core\SessionVO;
?>
<div class="text-center font-light bg-danger">
    <?php if (isset($empregos)) : ?>
        <?php foreach ($empregos as $item): ?>  
            <?php
            if ($item['id_empresa'] == $_SESSION[SessionVO::$ID] && $item['data_admissao'] != null) {
                echo "Funcionario trabalha ou já trabalhou na empresa<br>";
                break;
            }
            ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="form-group"></div>
<form action="" method="post">
    <div id="areaChave" class="oculto">
        <div class="form-group">
            <label for="exampleInputEmail1">Cargo</label>
            <input id="cargo" type="text" class="form-control" placeholder="Entre com o cargo">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Salário</label>
            <input id="salario" type="text" class="form-control dinheiroMaks" placeholder="Entre com o salário">
        </div>
        <div class="form-group">
            <label>Chave</label>
            <textarea id="chave" class="form-control" rows="3" placeholder="Entre com a chave para confirmar"></textarea>
        </div>
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> Instruções</h4>
            <ul>
                <li>Utilize sua chave para liberar o token.</li>
                <li>Aperte ctrl + v para preencher o campo com a chave.</li>
            </ul>
        </div>
    </div>
    <a href="#" class="btn btn-primary btn-block btnTokenEmpresa" value="geraToken"><b>Contratar</b></a>
    <div class="form-group transparente fino">
        <label>Token Encriptado</label>
        <textarea id="tokenEncrypt" class="form-control " rows="3"></textarea>
        <input id="idfuncionario" type="text" class="form-control" value="<?php echo $funcionario->getId(); ?>">
        <input id="idempresa" type="text" class="form-control" value="<?php echo $_SESSION[SessionVO::$ID]; ?>">
    </div>
</form>