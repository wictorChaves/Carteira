<?php

use core\StringHelper;
use core\StatusVO;
?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Proposta de Empregos</div>
    <div id="_tituloMenuPrincipal">Emprego</div>
    <div id="_tituloView">Propostas</div>
    <div id="_icon">fa-home</div>
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
                        <th>Empresa</th>
                        <th>Status</th>
                        <th>Data da Proposta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_pagina['model'])) : ?>
                        <?php foreach ($_pagina['model'] as $item): ?>
                            <?php if ($item['data_admissao'] == null and $item['data_saida'] == null) : ?>
                                <tr>
                                    <td><a href="../../emprego/detalhes/?id=<?php echo $item['id']; ?>"><?php echo $item['cargo']; ?></a></td>
                                    <td><?php echo $item['nome_fantasia']; ?></td>
                                    <td>
                                        <span class="label <?php echo StatusVO::getLabel(StatusVO::getStatus($item)); ?>">
                                            <?php echo StatusVO::getValor(StatusVO::getStatus($item)); ?>
                                        </span>
                                    </td>
                                    <td><?php echo StringHelper::dataEN2BR($item['data_proposta']); ?></td>
                                </tr>
                            <?php endif; ?>
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