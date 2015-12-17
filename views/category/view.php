<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model zantonijevic\documents\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Document Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-category-view">

    <?php $this->beginContent('@app/views/layouts/common/jarwiswidget.php',
        [
            'cellClass' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
            'title' => 'Document - ' . $this->title,
            'dropdown' => 'Actions',
            'menu' => [
                [
                    'label' => '<i class="fa fa-list"></i> Back to List',
                    'url' => array('index')
                ],
                [
                    'label' => '<i class="fa fa-pencil"></i> Update',
                    'url' => ['update', 'id' => $model->id]
                ],
                [
                    'label' => '<i class="fa fa-times"></i> Delete',
                    'url' => ['delete', 'id' => $model->id],
                    'template' => '<a onclick="return confirm(\'Are you sure you want to delete this item?\')"
 href="{url}">{label}</a>',

                ],
            ]
        ]); ?>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'alias',
            'published',
            'parent_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <?php $this->endContent(); ?>
</div>
