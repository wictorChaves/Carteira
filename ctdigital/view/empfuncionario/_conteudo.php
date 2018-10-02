<?php

use core\StringHelper;
use core\StatusVO;
use model\EstadosModel;
use core\FileHelper;
use model\PaisnacionalidadeidiomaModel;
use model\MunicipioModel;
use model\EstadoCivilModel;
use core\StatusPeriodoTrabalho;

$estados = new EstadosModel();

$funcionario = $_pagina['model']['funcionario'];
$empregos = $_pagina['model']['empregos'];
$paisnacionalidadeidioma = new PaisnacionalidadeidiomaModel();
$municipioModel = new MunicipioModel();
$estadoCivilModel = new EstadoCivilModel();
?>
<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo $funcionario->getImagem(); ?>" alt="User profile picture">

                    <h3 class="profile-username text-center"><?php echo $funcionario->getNome(); ?></h3>

                    <p class="text-muted text-center"><?php echo $funcionario->getDataNascimento(); ?></p>

                    <ul class="list-group list-group-unbordered">
                        <?php if (!StringHelper::isEmpty($funcionario->getNumeroCarteira())): ?>
                            <li class="list-group-item">
                                <b>N&deg; da Carteira</b> <a class="pull-right"><?php echo StringHelper::getNumeroCarteira($funcionario->getNumeroCarteira()); ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="list-group-item">
                            <b>CPF</b> <a class="pull-right"><?php echo StringHelper::getCpf($funcionario->getCpf()); ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>RG</b> <a class="pull-right"><?php echo $funcionario->getRg(); ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>PIS</b> <a class="pull-right"><?php echo $funcionario->getPis(); ?></a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 ">
            <div class="nav-tabs-custom box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informações</h3>
                </div>
                <div class="tab-content">
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Estado Civil</dt>
                            <dd><?php echo $estadoCivilModel->getDadoById($funcionario->getEstadoCivil())->getEstado(); ?></dd>
                            <dt>Sexo</dt>
                            <dd><?php echo StringHelper::getSexo($funcionario->getSexo()); ?></dd>
                            <dt>Mãe</dt>
                            <dd><?php echo $funcionario->getMae(); ?></dd>
                            <dt>Pai</dt>
                            <dd><?php echo $funcionario->getPai(); ?></dd>
                            <?php if (!StringHelper::isEmpty($funcionario->getCnh()) && $funcionario->getCnh() != 'NULL'): ?>
                                <dt>CNH</dt>
                                <dd><?php echo $funcionario->getCnh(); ?></dd>
                            <?php endif; ?>                            
                            <dd><br></dd>
                            <dt><i class="fa fa-file-text-o margin-r-5"></i> Observação</dt>
                            <dd><?php echo $funcionario->getObservacao(); ?></dd>
                            <dd><br></dd>
                            <dt>E-Mail</dt>
                            <dd><?php echo $funcionario->getEmail(); ?></dd>
                        </dl>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
            <div class="nav-tabs-custom box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Emprego Atual</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="tabela_com_busca table no-margin">
                            <thead>
                                <tr>
                                    <th>Cargo</th>
                                    <th>Empresa</th>
                                    <th>Período de Trabalho</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($empregos)) : ?>
                                    <?php foreach ($empregos as $item): ?>
                                        <?php if ($item['data_admissao'] != null && $item['data_saida'] == null) : ?>
                                            <tr>
                                                <td><a href="../../empemprego/detalhes/?id=<?php echo $item['id']; ?>"><?php echo $item['cargo']; ?></a></td>
                                                <td><?php echo $item['nome_fantasia']; ?></td>
                                                <?php
                                                $ativo = StatusVO::getValor(StatusVO::$INATIVO);
                                                if ($item['data_saida'] == null) : $ativo = StatusVO::getValor(StatusVO::$ATIVO);
                                                else : $ativo = StatusVO::getValor(StatusVO::$INATIVO);
                                                endif;
                                                ?>
                                                <td>
                                                    <?php echo StatusPeriodoTrabalho::getPeriodo($item); ?>
                                                </td>
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
                </div>
            </div>
            <div class="nav-tabs-custom box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Onde trabalhou</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="tabela_com_busca table no-margin">
                            <thead>
                                <tr>
                                    <th>Cargo</th>
                                    <th>Empresa</th>
                                    <th>Período de Trabalho</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($empregos)) : ?>
                                    <?php foreach ($empregos as $item): ?>
                                        <?php if ($item['data_admissao'] != null && $item['data_saida'] != null) : ?>
                                            <tr>
                                                <td><a href="../../empemprego/detalhes/?id=<?php echo $item['id']; ?>"><?php echo $item['cargo']; ?></a></td>
                                                <td><?php echo $item['nome_fantasia']; ?></td>
                                                <?php
                                                $ativo = StatusVO::getValor(StatusVO::$INATIVO);
                                                if ($item['data_saida'] == null) : $ativo = StatusVO::getValor(StatusVO::$ATIVO);
                                                else : $ativo = StatusVO::getValor(StatusVO::$INATIVO);
                                                endif;
                                                ?>
                                                <td>
                                                    <div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo StringHelper::dataEN2BR($item['data_admissao']); ?> - <?php
                                                        if ($item['data_saida'] == null) : echo "Atual";
                                                        else : echo StringHelper::dataEN2BR($item['data_saida']);
                                                        endif;
                                                        ?></div>
                                                </td>
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
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-3">

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Mais</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Título Eleitoral</strong>
                    <dd><?php echo $funcionario->getTituloEleitoral(); ?></dd>
                    <dt>Seção</dt>
                    <dd><?php echo $funcionario->getSecao(); ?></dd>
                    <dt>Zona</dt>
                    <dd><?php echo $funcionario->getZona(); ?></dd>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Local de Emissão (<?php echo StringHelper::dataEN2BR($funcionario->getDataEmissao()); ?>)</strong>
                    <dd><?php echo $municipioModel->getDadoById($funcionario->getLocalEmissao())->getMunicipio(); ?></dd>
                    <dt>Estado</dt>
                    <dd><?php echo $funcionario->getNEstado(); ?></dd>
                    <hr>
                    <dt><i class="fa fa-map-o margin-r-5"></i>Naturalidade</dt>
                    <dd><?php echo $municipioModel->getDadoById($funcionario->getNaturalidade())->getMunicipio(); ?></dd>
                    <hr>

                    <strong><i class="fa fa-pencil margin-r-5"></i> Nacionalidade</strong>
                    <dd><?php echo $paisnacionalidadeidioma->getDadoById($funcionario->getNacionalidade())->getNacionalidade(); ?></dd>
                    <?php if (!StringHelper::isEmpty($funcionario->getNChegada()) && $funcionario->getNChegada() != 'NULL'): ?>
                        <dt>Chegada</dt>
                        <dd><?php echo $funcionario->getNChegada(); ?></dd>
                    <?php endif; ?>
                    <?php if (!StringHelper::isEmpty($funcionario->getNExpedido())): ?>
                        <dt>Expedido</dt>
                        <dd><?php echo $funcionario->getNExpedido(); ?></dd>
                    <?php endif; ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->

</section>