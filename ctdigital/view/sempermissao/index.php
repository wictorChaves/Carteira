<?php

namespace view\login;

use core\Config;
use core\SessionVO;
?>
<div id="infoView" hidden=""> 
    <div id="_menuOff">Página Sem Menu</div>
</div>
<?php $cssJs = "../../js/"; ?>
<?php $cssUrl = "../../css/"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo Config::getConfig()['head']['titulo'] . " | Login"; ?></title>
        <link rel="icon" href="../../favicon.png">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>layout/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>layout/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>layout/square/blue.css">
        <!-- Meu CSS -->
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>style.css">
        <style>
            .btn-primary{
                background-color: #605ca8;
                border-color: #605ca8;
            }            
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
            <div class="lockscreen-logo">
                <a href="../../../../carteira/"><b>Carteira de Trabalho Digital</b></a>
            </div>
            <!-- User name -->
            <div class="lockscreen-name ">Você não tem permissão para acessar esta página</div>

            <!-- /.lockscreen-item -->
            <div class="help-block text-center">
                Talvez você esta tentando acessar uma área que não é a sua, você pode tentar:
            </div>
            <div class="text-center">
                <a href="../../../../carteira/">Voltar para o menu principal</a>
                <br>Ou
                <br>
                <a href="../../login/index/">Logar com outro usuário</a>
            </div>
            <div class="lockscreen-footer text-center">
                Copyright &copy; 2014-2016 <b><a href="../../../../carteira/" class="text-black">WS Corporation</a></b><br>
                All rights reserved
            </div>
        </div>
        <!-- /.center -->

        <!-- jQuery 3 -->
        <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>
