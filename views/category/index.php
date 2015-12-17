<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel zantonijevic\documents\models\DocumentCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-category-index">

    <?php $this->beginContent('@app/views/layouts/common/jarwiswidget.php',
        [
            'cellClass' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
            'title' => 'List of Document Categories',
            'dropdown' => 'Actions',
            'menu' => [
                [
                    'label' => '<i class="fa fa-plus"></i> Create Item',
                    'url' => array('create')
                ],
            ]
        ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'alias',
            'published',
            'parent_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php $this->endContent(); ?>
</div>
