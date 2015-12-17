<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel zantonijevic\documents\models\search\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Documents';
$this->params['breadcrumbs'][] = $this->title;

$template = '{view}';
$menu = null;
$isAdmin  = Yii::$app->user->identity->getIsAdmin();
$isUser   = Yii::$app->user->isUser();

if ( $isAdmin ) {
	$template = '{view} {update} {delete}';
	$menu     = [
		[
			'label' => '<i class="fa fa-plus"></i> Create Item',
			'url'   => array( 'create' )
		],
	];
}
?>
<div class="row">
	<div class="document-index">

		<?php $this->beginContent( '@app/views/layouts/common/jarwiswidget.php',
			[
				'cellClass' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
				'title'     => 'List of Documents',
				'dropdown'  => 'Actions',
				'menu'      => $menu
			] ); ?>

		<?= GridView::widget( [
			'dataProvider' => $dataProvider,
			'filterModel'  => $searchModel,
			'columns'      => [
				[ 'class' => 'yii\grid\SerialColumn' ],

				//'id',
				'title',
				//'alias',
				//'file_name',
				'original_file_name',
				// 'document_category',
				// 'created_at',
				// 'updated_at',

				[ 'class' => 'yii\grid\ActionColumn' , 'template'=>$template],
			],
		] ); ?>
		<?php $this->endContent(); ?>

	</div>
</div>
