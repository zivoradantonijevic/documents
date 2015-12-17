<?php

namespace zantonijevic\documents\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%document_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $published
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Document[] $documents
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%document_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'published', 'created_at', 'updated_at'], 'required'],
            [['published', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255]
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'alias' => 'Alias',
            'published' => 'Published',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['document_category_id' => 'id']);
    }
}
