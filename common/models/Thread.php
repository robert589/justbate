<?php

namespace common\models;
use yii\db\ActiveRecord;
use Yii;

class Thread extends ActiveRecord
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
	const STATUS_BANNED = 11;

	public static function tableName() {
		return 'thread';
	}


	public static function countAll() {
		$command =  \Yii::$app->db->createCommand('SELECT COUNT(*) FROM (Select * from thread inner join user on thread.user_id = user.id) TU')->queryScalar();
		return (int)($command);


	}

	public static function countByTopic($topic_name) {
		$command =  \Yii::$app->db->createCommand("SELECT COUNT(*) FROM (Select * from thread inner join user on thread.user_id = user.id where topic_name = \"$topic_name\") TU")->queryScalar();
		return (int)($command);
	}

	public static  function getRecentActivityCreateThread($username) {
		$sql = "SELECT thread.*
		FROM thread, user
		where thread.user_id = user.id and user.username = '$username'
		order by `date_created` desc";

		$result =  \Yii::$app->db->createCommand($sql)->queryAll();

		return $result;
	}

	public static function getAllThreads() {
		$sql =  "
			 Select thread.*, user.*
				 from thread,user
				 where thread.user_id = user.id and thread_status = 10
				 order by (date_created) desc       ";

		return  \Yii::$app->db->createCommand($sql)->queryAll();
	}

	public static function getThreadsBytag($tag) {
		 $sql =  "
				 Select thread_thread_rate.*, user.*, avg(thread_thread_rate.rate) as avg_rating
				 from (SELECT thread.*, thread_rate.rate as rate
							 from thread left join thread_rate
							 on thread.thread_id = thread_rate.thread_id) thread_thread_rate,
							 user, thread_tag, tag
				 where thread_thread_rate.user_id = user.id and
							 thread_tag.thread_id = thread_thread_rate.thread_id AND
							 tag.tag_id = thread_tag.tag_id
							 and tag.tag_name =  :tag and thread_status = 10
				 group by(thread_thread_rate.thread_id)
		";

		return  \Yii::$app->db->createCommand($sql)
			->bindParam(":tag", $tag)
			->queryAll();
	}

	public static function getThreadsBySearch($query) {
		$sql = "SELECT thread_id as id, title as text from thread where title like concat('%', :query,'%') and thread_status = 10";

		return  \Yii::$app->db->createCommand($sql)
			->bindParam(":query", $query)
			->queryAll();
	}


	/**
	 * WEAKNESS: it is not right, it is wrong
	 * @return array
	 */
	public static function getTop10TrendingTopic() {
		//Retrieve top 10 trending topic which counted from participants
		$sql = "SELECT T.thread_id, TT.participants, title from thread T
				left join
				(SELECT thread_id, COUNT(user_id) as participants
						from (SELECT distinct user_id, thread_id from thread_rate
									union
								 SELECT distinct user_id, thread_id from thread_comment inner join comment on thread_comment.comment_id = comment.comment_id where thread_id is not null)  P
						group by thread_id
						order by participants desc
						limit 10 ) TT
						on T.thread_id = TT.thread_id
						where thread_status = 10
						limit 10
		";

		return \Yii::$app->db->createCommand($sql)->queryAll();
	}


	public static function retrieveAll() {
		return Self::find()->all();
	}

	public static function retrieveThreadById($thread_id, $user_id) {
		if(empty($user_id)) {
			$user_id = 0;
		}

		$sql = "SELECT (SELECT avg(rate) from thread_rate where thread_id = :thread_id) as avg_rating,
									(SELECT count(*) from thread_rate where thread_id = :thread_id) as total_raters,
									TU.*,
									(SELECT choice_text from thread_vote where thread_id = :thread_id and user_id = :user_id) as user_choice,
									(SELECT count(*) from thread_rate where thread_id = :thread_id and user_id = :user_id) as has_rate
					FROM (SELECT * from thread inner join user on thread.user_id = user.id) TU
					where thread_id = :thread_id and thread_status = 10";

		$result =  \Yii::$app->db->createCommand($sql)->
			bindParam(':thread_id', $thread_id)->
			bindParam(':user_id', $user_id)->
			queryOne();

		return $result;
	}

	/**
	 *Variable: avg_rating, all variables of users that create thread , all variable of threads
	 *
	 */
	public static function retrieveThreadFromFollowee($follower_id) {
		$sql =  "
			 Select thread_thread_rate.*, user.*, avg(thread_thread_rate.rate) as avg_rating
				 from (SELECT thread.*, thread_rate.rate as rate
							 from thread left join thread_rate
							 on thread.thread_id = thread_rate.thread_id) thread_thread_rate,
							 user, thread_tag
				 where thread_thread_rate.user_id = user.id and user.id in (SELECT followee_id from follower_relation where follower_id = :follower_id )
				 group by(thread_thread_rate.thread_id)
				 order by (date_created) desc";

		return \Yii::$app->db
			->createCommand($sql)
			->bindParam(':follower_id', $follower_id)
			->queryAll();
	}
}