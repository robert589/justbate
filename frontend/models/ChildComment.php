<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
	public function getTable(){
		return 'comment';
	}

}