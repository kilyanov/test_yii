<?php

declare(strict_types=1);

namespace backend\assets;

use johnitvn\ajaxcrud\CrudAsset as CrudAssetBase;

class CrudAsset extends CrudAssetBase
{
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'kartik\grid\GridViewAsset',
    ];
}
