<?php
/**
 * @var array $data
 */
?>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Attribute</th>
            <th>Old value</th>
            <th>New Value</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $attribute => $log): ?>
        <tr>
            <td><?= $attribute ?></td>
            <td><?= $log['old'] ?></td>
            <td><?= $log['new'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
