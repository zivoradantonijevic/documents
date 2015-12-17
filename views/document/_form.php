<?php

use kartik\file\FileInput;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model zantonijevic\documents\models\Document */
/* @var $form yii\widgets\ActiveForm */


$id = (int) $model->id;
$documentCategory = $model->getCategoriesSelect($id);
//_p($documentCategory,1)
?>

<div class="document-form">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data'
            ],
        ]); ?>
        <?= $form->errorSummary($model); ?>

        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field( $model, 'published' )->dropDownList( [ 1 => 'yes', 2 => 'no' ] ); ?>
            <?= $form->field($model, 'document_category_id')->dropDownList($documentCategory,[ 'prompt' => '--Select--' ] ); ?>
        </div>
        <div class="col-md-6">
            <p class="bg-info"></p>
            <?= $form->field($model, 'file_name')->widget(FileInput::className(),
                [
                    /*            'options'       => [
                                    'accept' => 'file_name/' . $file_nametype
                                ],*/
                    'pluginOptions' => [
                        'previewFileType' => 'file_name',
                        'showUpload' => false,
                        'browseLabel' => 'Browse &hellip;',
                    ],
                ]); ?>

            <?php if (isset($model->file_name) && !empty($model->file_name)): ?>

                <div class="thumbnail">
                    <img alt="200x200" class="img-thumbnail" style="width: 300px;"
                         src="<?= $model->getThumb(); ?>">


                </div>

            <?php endif ?>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
