<?php

use core\StatusVO;
use core\StringHelper;
use core\StatusPeriodoTrabalho;
?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Detalhes do Emprego</div>
    <div id="_tituloMenuPrincipal">Emprego</div>
    <div id="_tituloView">Detalhes</div>
    <div id="_icon">fa-wrench</div>
    <div id="_menuOff">Página Sem Menu</div>
</div>
<?php if (isset($_pagina['model'])) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-wrench"></i>
                    <h3 class="box-title"><?php echo $_pagina['model']['cargo']; ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <dl>
                        <dt>Empresa</dt>
                        <dd><a href="../../empresa/index/?id=<?php echo $_pagina['model']['id_empresa']; ?>"><?php echo $_pagina['model']['nome_fantasia']; ?></a></dd>
                        <dt>Remuneração</dt>
                        <dd>R$ <?php echo StringHelper::dinheiroEN2BR($_pagina['model']['remuneracao']); ?></dd>
                        <dt>Status</dt>
                        <td>
                            <span class="label <?php echo StatusVO::getLabel(StatusVO::getStatus($_pagina['model'])); ?>">
                                <?php echo StatusVO::getValor(StatusVO::getStatus($_pagina['model'])); ?>
                            </span>
                        </td>
                        <dt><br></dt>
                        <?php if (!($_pagina['model']['data_admissao'] == null && $_pagina['model']['data_saida'] == null)) : ?>
                            <dt>Período de Trabalho</dt>
                            <dd>
                                <?php echo StatusPeriodoTrabalho::getPeriodo($_pagina['model']); ?>
                            </dd>
                        <?php endif; ?>
                        <dt><br></dt>
                        <dt>
                            <div id="areaChave" class="form-group oculto">
                                <label>Entre com a chave</label>
                                <textarea id="chave" class="form-control" rows="1" placeholder="Entre com a chave para confirmar"></textarea>
                                <br>
                                <div class="callout callout-info">
                                    <h4>I am an info callout!</h4>

                                    <p>Follow the steps to continue to payment.</p>
                                </div>
                            </div>

                        </dt>
                        <?php if ($_pagina['model']['data_admissao'] != null && $_pagina['model']['data_saida'] == null) : ?>
                            <dt>
                                <button id="btnToken" name="btnToken" type="submit" value="geraToken" class="btn btn-warning btnCopy btnToken">Demitir</button>
                            </dt>
                        <?php endif; ?>
                        <dt class="transparente">
                            <div class="form-group">
                                <label>Token Encriptado</label>
                                <textarea id="tokenEncrypt" class="form-control " rows="3"></textarea>
                            </div>
                        </dt>
                    </dl>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
<?php endif; ?>