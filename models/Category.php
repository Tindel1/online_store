<?php

namespace app\models;
use yii\db\ActiveRecord;

// для работы с категориями
class Category extends ActiveRecord {

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }	

	public static function tableName() {
		return 'category';
	}

	public function getProducts() {
		return $this->hasMany(Product::className(), ['category_id' => 'id']);
	}

}


