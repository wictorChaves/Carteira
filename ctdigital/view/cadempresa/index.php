<?php

use core\StringHelper;
?>
<!-- /top tiles -->
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Lista das Empresas</div>
    <div id="_tituloMenuPrincipal">Empresas</div>
    <div id="_tituloView">Lista</div>
    <div id="_icon">fa-industry</div>
</div>
<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Funcionários</h3>

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
                        <th>Nome</th>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                        <th>Cidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_pagina['model'])) : ?>
                        <?php foreach ($_pagina['model'] as $item): ?>
                            <tr>
                                <td><a href="../../cadempresa/detalhes/?id=<?php echo $item->getCnpj(); ?>"><?php echo $item->getNomeFantasia(); ?></a></td>
                                <td><?php echo $item->getRazaoSocial(); ?></td>
                                <td><?php echo StringHelper::getCnpj($item->getCnpj()); ?></td>
                                <td><?php echo $item->getCidade(); ?></td>
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