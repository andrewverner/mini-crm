<?php

declare(strict_types=1);

namespace backend\components\columns;

use common\models\User;
use Yii;
use yii\bootstrap5\Html;
use yii\grid\DataColumn;
use yii\rbac\Role;

final class RolesColumn extends DataColumn
{
    public $header = 'Role';

    protected function renderDataCellContent($model, $key, $index): ?string
    {
        if (!$model instanceof User) {
            return null;
        }

        $rolesList = ['' => ''] + array_map(
            callback: static fn (Role $role) => $role->name,
            array: Yii::$app->authManager->getRoles(),
        );

        $list = Html::dropDownList(
            name: 'userRole',
            selection: $this->getRolesListSelection(model: $model),
            items: array_combine(
                keys: $rolesList,
                values: array_map(
                    callback: static fn (string $roleName) => ucfirst(string: $roleName),
                    array: $rolesList,
                ),
            ),
            options: [
                'data-user' => $model->id,
                'class' => 'roles-list',
            ],
        );

        return Yii::$app->controller->renderFile(
            file: Yii::getAlias(alias: '@backend/components/columns/views/roles.php'),
            params: ['list' => $list],
        );
    }

    private function getRolesListSelection(User $model): string
    {
        $userRoles = Yii::$app->authManager->getRolesByUser(userId: $model->id);

        if (array_key_exists(key: 'admin', array: $userRoles)) {
            return 'admin';
        }

        if (array_key_exists(key: 'manager', array: $userRoles)) {
            return 'manager';
        }

        return '';
    }
}
