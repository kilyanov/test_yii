<?php
/**
 * @var string $assetDir
 */

use common\helpers\MenuHelpers;
use common\rbac\CollectionRolls;
use hail812\adminlte\widgets\Menu;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="<?= Yii::$app->name ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
       <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo Menu::widget([
                'items' => [
                    [
                        'label' => 'Пользователи',
                        'iconStyle' => 'far',
                        'url' => ['/user/default/index'],
                        'visible' => Yii::$app->user->can(CollectionRolls::ROLE_SUPER_ADMIN)
                    ],
                    [
                        'label' => 'Заказы',
                        'iconStyle' => 'far',
                        'url' => ['/orders/default/index'],
                        'visible' => Yii::$app->user->can(CollectionRolls::ROLE_SUPER_ADMIN)
                    ],
                    [
                        'label' => 'Товары',
                        'iconStyle' => 'far',
                        'url' => ['/products/default/index'],
                        'visible' => Yii::$app->user->can(CollectionRolls::ROLE_USER)
                    ],
                    [
                        'label' => 'Клиенты',
                        'iconStyle' => 'far',
                        'url' => ['/clients/default/index'],
                        'visible' => Yii::$app->user->can(CollectionRolls::ROLE_SUPER_ADMIN)
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>