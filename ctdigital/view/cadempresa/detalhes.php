<?php

use core\StringHelper;
use core\FileHelper;

$empresa = $_pagina['model']['empresa'];

?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Perfil do Trabalhador</div>
    <div id="_tituloMenuPrincipal">Perfil</div>
    <div id="_tituloView">Perfil</div>
    <div id="_icon">fa-user</div>
    <div id="_menuOff">Página Sem Menu</div>
</div>
<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-4">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo $empresa->getImagem(); ?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?php echo $empresa->getNomeFantasia(); ?></h3>
                    <p class="text-muted text-center"><?php echo StringHelper::getCnpj($empresa->getCnpj()); ?></p>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <b>Razão Social</b> <div class="pull-right"><?php echo $empresa->getRazaoSocial(); ?></div>
                        </li>
                        <li class="list-group-item">
                            <b>Inscrição Estadual</b> <div class="pull-right"><?php echo StringHelper::getInscricaoEstadual($empresa->getInscricaoEstadual()); ?></div>
                        </li>
                        <li class="list-group-item">
                            <b>E-Mail</b> <div class="pull-right"><?php echo $empresa->getEmail(); ?></div>
                        </li>
                        <a href="../../Certificados/<?php echo $empresa->getCnpj(); ?>.zip" class="btn btn-primary btn-block"><b>Baixar Certificado</b></a>
                    </ul>
                    <div class="box-header with-border">
                        <h3 class="box-title">Endereço</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Local (<?php echo StringHelper::getCep($empresa->getCep()); ?>)</strong>
                        <dd><?php echo $empresa->getEndereco(); ?>, <?php echo $empresa->getNumero(); ?></dd>
                        <dt>Bairro</dt>
                        <dd><?php echo $empresa->getBairro(); ?></dd>
                        <dt>Cidade</dt>
                        <dd><?php echo $empresa->getCidade(); ?>, <?php echo $empresa->getEstado(); ?></dd>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Mapa</h3>
                </div>
                <div class="box-body">
                    <iframe src="https://www.google.com.br/maps?q=<?php echo $empresa->getCep(); ?>,%20Brasil&output=embed" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->

</section>

