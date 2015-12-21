<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Rate extends ActiveRecord
{
	public function getTable(){
		return 'rate';
	}
}