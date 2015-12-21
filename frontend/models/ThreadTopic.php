<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use yii\db\Query;
use frontend\models\ThreadTopic;
use common\models\User;
use Yii;
class ThreadTopic extends ActiveRecord{

	public static function tableName()
    {
        return 'thread_topic';
    }


  public static function retrieveAll(){
    return Self::find()->all();
  }
}