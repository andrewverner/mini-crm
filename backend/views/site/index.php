<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">mini CRM!</h1>

        <p><a class="btn btn-lg btn-success" href="/user">Users</a></p>
        <p><a class="btn btn-lg btn-success" href="/ticket">Tickets</a></p>
        <?php if (Yii::$app->user->can(permissionName: 'admin')): ?>
            <p><a class="btn btn-lg btn-success" href="/changelog">Changelog</a></p>
        <?php endif ?>
    </div>

</div>
