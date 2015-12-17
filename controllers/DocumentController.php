<?php

namespace zantonijevic\documents\controllers;

use zantonijevic\documents\components\Controller;
use zantonijevic\documents\models\Document;
use zantonijevic\documents\models\search\DocumentSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller {
	public $adminActions = [ 'create', 'update', 'delete-file', 'delete' ];


	/**
	 * Lists all Document models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel  = new DocumentSearch();
		$dataProvider = $searchModel->search( Yii::$app->request->queryParams );

		return $this->render( 'index',
			[
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
			] );
	}

	/**
	 * Displays a single Document model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView( $id ) {
		$model = $this->findModel( $id );

		header( "Content-Description: File Transfer" );
		header( 'Content-Type: application/octet-stream' );
		//header("Content-Transfer-Encoding: Binary");
		header( "Content-disposition: attachment; filename=\"" . $model->original_file_name . "\"" );
		readfile( Yii::getAlias( '@app/web/uploads/' ) . $model->file_name );
	}

	/**
	 * Creates a new Document model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Document();

		if ( $model->load( Yii::$app->request->post() ) ) {
			$uploaded = $model->uploadFile();
			if ( $uploaded ) {
				if ( $model->save() ) {
					return $this->redirect( [ 'index' ] );
				} else {
					$model->deleteFile();
				}
			}
			//_p( $uploaded, 1);
		}

		return $this->render( 'create',
			[
				'model' => $model,
			] );

	}

	/**
	 * Updates an existing Document model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate( $id ) {
		$model = $this->findModel( $id );

		if ( $model->load( Yii::$app->request->post() ) ) {
			$original = $model->file_name;
			$uploaded = $model->uploadFile();
			if ( $uploaded ) {
				if ( $model->save() ) {
					return $this->redirect( [ 'index' ] );
				}
			}
			//_p( $uploaded, 1);
		}


		return $this->render( 'update',
			[
				'model' => $model,
			] );

	}

	/**
	 * Deletes an existing Document model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDelete( $id ) {
		$model = $this->findModel( $id );
		if ( $model->deleteFile() && $model->delete() ) {

		}


		return $this->redirect( [ 'index' ] );
	}

	/**
	 * Deletes an existing Article Image.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDeleteFile( $id ) {
		$model = $this->findModel( $id );
		//_p($model);
		if ( $model->deleteFile() ) {
			$model->file_name = null;
			$model->save();
			Yii::$app->session->setFlash( 'success', 'File was removed successfully! Now, you can upload another by clicking Browse.' );
		} else {
			Yii::$app->session->setFlash( 'error', 'Error removing file. Please try again later or contact the system admin.' );
		}

		return $this->redirect( [
			'update',
			'id' => $model->id,
		] );
	}

	/**
	 * Finds the Document model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Document the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel( $id ) {
		if ( ( $model = Document::findOne( $id ) ) !== null ) {
			return $model;
		} else {
			throw new NotFoundHttpException( 'The requested page does not exist.' );
		}
	}
}
