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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="carregando"></div>
        <div class="mensagem_all <?php
        if (isset($_SESSION["erroLogin"])) : echo 'show';
        endif;
        ?>">
            <div class="mensagem_all_content warning"><?php echo $_SESSION["erroLogin"]; ?> </div>
        </div>
        <div class="login-box">
            <div class="login-logo">
                <b><a href="../../../../carteira/"><?php echo Config::getConfig()['head']['titulo']; ?> </b>Digital_</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Bem vindo à carteira digital</p>

                <form id="form_login" method="post">
                    <div class="form-group">
                        <label>Tipo</label>
                        <div class="radio" id="cpf">
                            <label>
                                <input type="radio" name="tipo" value="cpf" <?php
                                if (!isset($_SESSION[SessionVO::$TIPO]) || $_SESSION[SessionVO::$TIPO] != 'cnpj') : echo 'checked';
                                endif;
                                ?>>
                                Trabalhador
                            </label>
                        </div>
                        <div class="radio" id="cnpj">
                            <label>
                                <input type="radio" name="tipo"  value="cnpj"<?php
                                if (isset($_SESSION[SessionVO::$TIPO]) && $_SESSION[SessionVO::$TIPO] == 'cnpj') : echo 'checked';
                                endif;
                                ?>>
                                Empresa
                            </label>
                        </div>
                    </div>
                    <div id="login_cpf" class="form-group has-feedback">
                        <input value="<?php
                        if (isset($_SESSION[SessionVO::$LOGIN])) : echo $_SESSION[SessionVO::$LOGIN];
                        endif;
                        ?>" name="login" type="text"  data-mask="000.000.000-00" class="fldObrigatorio form-control" placeholder="Usuário" required="" />
                        <span class="glyphicon form-control-feedback"></span>
                    </div>
                    <div id="login_cnpj" class="form-group has-feedback">
                        <input value="<?php
                        if (isset($_SESSION[SessionVO::$LOGIN])) : echo $_SESSION[SessionVO::$LOGIN];
                        endif;
                        ?>" type="text" name="oculto"  data-mask="00.000.000/0000-00" class="fldObrigatorio form-control" placeholder="Usuário" required="" />
                        <span class="glyphicon form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input value="<?php
                        if (isset($_SESSION[SessionVO::$SENHA])) : echo $_SESSION[SessionVO::$SENHA];
                        endif;
                        ?>" name="senha" type="password" class="fldObrigatorio form-control" placeholder="Senha" required="">
                        <span class="glyphicon form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <!-- <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> Remember Me
                                </label>
                            </div>
                        </div> -->
                        <!-- /.col -->
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <a href="#">I forgot my password</a><br>
                <a href="register.html" class="text-center">Register a new membership</a>-->

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="<?php echo $cssJs; ?>layout/jquery-2.2.3.min.js"></script>
        <!-- Clique cpf ou cnpj -->
        <script>
            $(function () {
                $('#login_cnpj input').attr('type', 'hidden');
<?php
if (isset($_SESSION[SessionVO::$TIPO]) && $_SESSION[SessionVO::$TIPO] == 'cnpj') :
    ?>
                    $('#login_cnpj input').attr('type', 'text');
                    $('#login_cpf input').attr('type', 'hidden');

                    $('#login_cnpj').fadeIn();
                    $('#login_cpf').hide();

                    $('#login_cnpj input').attr('name', 'login');
                    $('#login_cpf input').attr('name', 'oculto');
    <?php
endif;
?>
                $('#cnpj label').on('click', function () {
                    $('#login_cnpj input').attr('type', 'text');
                    $('#login_cpf input').attr('type', 'hidden');

                    $('#login_cnpj').fadeIn();
                    $('#login_cpf').hide();

                    $('#login_cnpj input').attr('name', 'login');
                    $('#login_cpf input').attr('name', 'oculto');
                });
                $('#cpf label').on('click', function () {
                    $('#login_cpf input').attr('type', 'text');
                    $('#login_cnpj input').attr('type', 'hidden');

                    $('#login_cpf').fadeIn();
                    $('#login_cnpj').hide();

                    $('#login_cpf input').attr('name', 'login');
                    $('#login_cnpj input').attr('name', 'oculto');
                });
            });
        </script>
        <!-- Validar campos - Documentação: http://parsleyjs.org/doc/examples/simple.html -->
        <script src="<?php echo $cssJs; ?>parsley.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo $cssJs; ?>layout/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo $cssJs; ?>layout/icheck.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo $cssJs; ?>jquery.mask.js"></script>
    </body>
</html>
