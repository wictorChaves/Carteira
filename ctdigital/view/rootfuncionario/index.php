<?php
    use core\StringHelper;
?>
<!-- /top tiles -->
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Lista de Trabalhadores</div>
    <div id="_tituloMenuPrincipal">Admin Trabalhadores</div>
    <div id="_tituloView">Lista</div>
    <div id="_icon">fa-group</div>
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
                        <th>Sexo</th>
                        <th>CPF</th>
                        <th>Data de Nascimento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_pagina['model'])) : ?>
                        <?php foreach ($_pagina['model'] as $item): ?>
                            <tr>
                                <td><a href="../../rootfuncionario/detalhes/?id=<?php echo $item->getCpf(); ?>"><?php echo $item->getNome(); ?></a></td>
                                <td><?php echo StringHelper::getSexo($item->getSexo()); ?></td>
                                <td><?php echo StringHelper::getCpf($item->getCpf()); ?></td>
                                <td><?php echo $item->getDataNascimento(); ?></td>
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