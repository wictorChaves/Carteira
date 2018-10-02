<?php

use core\StatusVO;
use core\StringHelper;
use model\FuncionarioModel;
use core\StatusPeriodoTrabalho;
$funcionarioModel = new FuncionarioModel();
?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Lista de Empregos</div>
    <div id="_tituloMenuPrincipal">Empregos</div>
    <div id="_tituloView">Lista</div>
    <div id="_icon">fa-wrench</div>
</div>
<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Empregos</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="tabela_com_busca table no-margin">
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Período de Trabalho</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_pagina['model'])) : ?>
                        <?php foreach ($_pagina['model'] as $item): ?>
                            <tr>
                                <td><a href="../../empemprego/detalhes/?id=<?php echo $item->getId(); ?>"><?php echo $item->getCargo(); ?></a></td>
                                <td><a href="../../contratar/index/?cpf=<?php echo $funcionarioModel->getDadoById($item->getIdFuncionario())->getCpf(); ?>"><?php echo $funcionarioModel->getDadoById($item->getIdFuncionario())->getNome(); ?></a></td>
                                <td>
                                    <span class="label <?php echo StatusVO::getLabel(StatusVO::getStatus($item)); ?>">
                                        <?php echo StatusVO::getValor(StatusVO::getStatus($item)); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo StatusPeriodoTrabalho::getPeriodo($item); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php
                    else : echo "Não há dados!";
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
    </div>
    <!-- /.box-footer -->
</div>