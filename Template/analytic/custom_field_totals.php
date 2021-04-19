<?php if (! $is_ajax): ?>
    <div class="page-header">
        <h2><?= t('Custom Field Total distribution') ?></h2>
    </div>
<?php endif ?>

<?php if (empty($metrics)): ?>
    <p class="alert"><?= t('Not enough data to show the graph.') ?></p>
<?php else: ?>
    <?= $this->app->component('chart-project-task-distribution', array(
        'metrics' => $metrics,
    )) ?>

    <table class="table-striped">
        <tr>
            <th><?= t('Custom Field') ?></th>
            <th><?= t('Total Value') ?></th>
            <th><?= t('Percentage') ?></th>
        </tr>
        <?php foreach ($metrics as $metric): ?>
        <tr>
            <td>
                <?= $this->text->e($metric['column_title']) ?>
            </td>
            <td>
                <?= $metric['append'].$metric['nb_tasks'] ?>
            </td>
            <td>
                <?= n($metric['percentage']) ?>%
            </td>
        </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>