<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model zantonijevic\documents\models\Category */

$this->title = 'Update Document Category: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Document Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-category-update">

    <?php $this->beginContent( '@app/views/layouts/common/jarwiswidget.php',
        [
            'cellClass' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
            'title'     => 'Update Document Category',
            'dropdown'  => 'Actions',
            'menu'      => [
                [
                    'label' => '<i class="fa fa-list"></i> Back to List',
                    'url'   => array( 'index' )
                ],
            ]
        ] ); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php $this->endContent(); ?>
</div>
