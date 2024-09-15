<?php
/**
 * @var string $list
 * @var View $this
 */

use backend\assets\RolesColumnAsset;
use yii\web\View;

RolesColumnAsset::register(view: $this);
?>

<?= $list ?>
