<? php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use frontend\models\Thread;
use yii\db\Query;

class Dashboard extends Model{

	public $id;

	public function retrieveByUser(){
		$thread = new Thread();

		$id = Yii::$app->user->id;

		$query = new Query()->select('title AS thread_title, date_created AS date, content AS text')
							->from('thread')
							->where(['user_id' => $id]);

		return $query;

	}
}