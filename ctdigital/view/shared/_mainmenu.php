<?php

namespace view\shared;

use tela\Menu;

$m = new Menu();
$menu = $m->getMenu();
?>
<ul class="sidebar-menu">
    <li class="header">MENU PRINCIPAL</li>
    <?php foreach ($menu as $itemMenu) : ?>
        <?php if (count($itemMenu[1]) == 1): ?>
            <li class="<?php echo $m->ativo($itemMenu[1][0][1]); ?>">
                <a href="../../<?php echo $itemMenu[1][0][1]; ?>">
                    <i class="fa <?php echo $itemMenu[2]; ?>"></i> <span> <?php echo ucfirst($itemMenu[0]); ?></span>
                </a>
            </li>
            <?php
            continue;
        endif;
        ?>
        <li class="treeview <?php echo $m->ativoMainMenu($itemMenu[1][0][1]); ?>"> 
            <a href="#"><i class="fa <?php echo $itemMenu[2]; ?>"></i> <span><?php echo ucfirst($itemMenu[0]); ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php foreach ($itemMenu[1] as $subMenu) : ?>
                    <li class="<?php echo $m->ativo($subMenu[1]); ?>"><a href="../../<?php echo $subMenu[1]; ?>"><?php echo ucfirst($subMenu[0]); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>

    <?php endforeach; ?>
</ul>