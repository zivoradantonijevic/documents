<?php

namespace zantonijevic\documents\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%document}}".
 *
 * @property integer      $id
 * @property string       $title
 * @property string       $alias
 * @property UploadedFile $file_name
 * @property string       $original_file_name
 * @property integer      $document_category_id
 * @property integer      $published
 * @property integer      $created_at
 * @property integer      $updated_at
 *
 * @property Category     $documentCategory
 * @property string       file_extension
 * @property string       file_type
 */
class Document extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%document}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'title', ], 'required' ],
			[ [ 'document_category_id', 'published', 'created_at', 'updated_at' ], 'integer' ],
			[ [ 'file_extension', 'file_type' ], 'string', 'max' => 20 ],
			[ [ 'title', 'original_file_name' ], 'string', 'max' => 255 ],
			[
				[ 'file_name' ],
				'file',
				'skipOnEmpty'              => false,
				'checkExtensionByMimeType' => false,
				'extensions'               => [ 'xls', 'pdf', 'doc', 'csv', 'jpg', 'png', 'gif', 'xml', 'xsls', 'docx' ]
			],
		];
	}


	/**
	 * @return array
	 */
	public function behaviors() {
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'created_at',
				'updatedAtAttribute' => 'updated_at',
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id'                   => 'ID',
			'title'                => 'Title',
			'published'            => 'Published',
			'file_name'            => 'File Name',
			'original_file_name'   => 'Original File Name',
			'document_category_id' => 'Document Category',
			'created_at'           => 'Created At',
			'updated_at'           => 'Updated At',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDocumentCategory() {
		return $this->hasOne( Category::className(), [ 'id' => 'document_category_id' ] );
	}

	/*
	 * Categories Select
	 */
	public function getCategoriesSelect( $id ) {
		$sql        = 'SELECT id,title FROM {{%document_category}} WHERE published = 1 AND id !=' . $id;
		$categories = Category::findBySql( $sql )->asArray()->all();


		$array = [ ];
		foreach ( $categories as $category ) {
			$array[ $category['id'] ] = $category['title'];
		}

		return $array;

	}

	public function uploadFile() {
		$file = UploadedFile::getInstance( $this, 'file_name' );

		// if no file was uploaded abort the upload
		if ( empty( $file ) ) {
			return false;
		}

		$extension    = $file->extension;
		$originalName = $file->name;
		$fileName     = $this->generateFileName( $originalName ) . '.' . $extension;
		// set field to filename.extensions

		// update file->name
		$file->name = $fileName;
		// save images to imagePath
		if ( $file->saveAs( Yii::getAlias( '@app/web/uploads/' ) . $fileName ) ) {
			$this->original_file_name = $originalName;
			if ( $this->file_name && $this->file_name !== $fileName ) {
				$this->deleteFile();
			}
			$this->file_name      = $file;
			$this->file_type      = $file->type;
			$this->file_extension = $file->extension;

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Generate fileName
	 *
	 * @return string fileName
	 */
	public function generateFileName( $name ) {
		// remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace( array( '/\s+/', '/[^A-Za-z0-9\-]/' ), array( '-', '' ), $name );

		// lowercase and trim
		$str = trim( strtolower( $str ) );

		return md5( time() ) . $str;
	}

	public function getThumb() {
		if ( $this->file_name ) {
			$file_extension = $this->file_extension;
			if ( $file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif' || $file_extension == 'svg' ) {
				return '/backend/web/uploads/' . $this->file_name;
			} else if ( file_exists( Yii::getAlias( '@app/web/images/icons/512px/' . $file_extension ) ) ) {
				return 'images/icons/512px/' . $file_extension;
			}

			return 'images/icons/512px/_blank.png';

		}
	}

	public function deleteFile() {
		$filename = Yii::getAlias( '@app/web/uploads/' ) . $this->file_name;

		if ( empty( $filename ) || ! file_exists( $filename ) ) {
			return true;
		}

		if ( ! unlink( $filename ) ) {
			return false;
		}

		return true;
	}

}
