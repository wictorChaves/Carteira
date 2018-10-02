<?php

use core\Config;
?>
<head>
    <?php include '_meta.php'; ?>
    <title><?php
        if (isset($_pagina['titulo'])): echo $_pagina['titulo'];
        else : echo Config::getConfig()['head']['titulo'];
        endif;
        ?></title>
    <!--[if IE]><link rel="shortcut icon" href="../../favicon.ico"><![endif]-->
    <link rel="icon" href="../../favicon.png">
    <?php include '_css.php'; ?>
    <?php include '_script.php'; ?>
</head>