<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model zantonijevic\documents\models\Category */

$this->title = 'Create Document Category';
$this->params['breadcrumbs'][] = ['label' => 'Document Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-category-create">

    <?php $this->beginContent( '@app/views/layouts/common/jarwiswidget.php',
        [
            'cellClass' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
            'title'     => 'Create Document Category',
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
