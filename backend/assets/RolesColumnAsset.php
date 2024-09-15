<?php

declare(strict_types=1);

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class RolesColumnAsset extends AssetBundle
{
    public $js = [
        'js/roles.js',
    ];

    public $depends = [
        JqueryAsset::class,
    ];

    public $sourcePath = '@backend/components/columns/';
}
