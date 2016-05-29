<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * Class Thread
 * @package common\models
 */
class Thread extends ActiveRecord
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
	const STATUS_BANNED = 11;

	const PREFIX = "thread_";



	public static function tableName() {
		return 'thread';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	public static function getThreads($user_id, $issue_name = null) {
		$template_sql = "
						Select parent_thread_info.* , thread_vote.choice_text from(
							Select thread_info.*, count(comments.comment_id) as total_comments
							from (Select thread.*, user.id, user.first_name, user.last_name, user.photo_path
								  from thread, user
								  where thread.user_id = user.id and
								  thread_status = 10
							) thread_info
							left join (select thread_comment.comment_id, thread_comment.thread_id
										from thread_comment, comment
									  where thread_comment.comment_id = comment.comment_id and
									  comment.comment_status = 10) comments
							on thread_info.thread_id = comments.thread_id
							group by thread_info.thread_id
							order by (created_at) desc

						) parent_thread_info
						left join thread_vote
						on parent_thread_info.thread_id = thread_vote.thread_id and thread_vote.user_id = :user_id

						";
		if($issue_name == null){
			$sql =  $template_sql;
			return  \Yii::$app->db->createCommand($sql)->
					bindParam(':user_id', $user_id)
					->queryAll();
		}
		else{
			$sql =  "

						Select parent_thread_info.* , thread_vote.choice_text from(
							Select thread_info.*, count(comments.comment_id) as total_comments
							from (Select thread.*, user.id, user.first_name, user.last_name, user.photo_path from thread, user, thread_issue, issue
								  where thread.user_id = user.id and
								  thread_status = 10 and
								thread_issue.thread_id = thread.thread_id
								and issue.issue_name = :issue_name
								and issue.issue_name = thread_issue.issue_name
							) thread_info
							left join (select thread_comment.comment_id, thread_comment.thread_id
										from thread_comment, comment
									  where thread_comment.comment_id = comment.comment_id and
									  comment.comment_status = 10) comments
							on thread_info.thread_id = comments.thread_id
							group by thread_info.thread_id
							order by (created_at) desc
						) parent_thread_info
						left join thread_vote
						on parent_thread_info.thread_id = thread_vote.thread_id and thread_vote.user_id = :user_id

			";

			return  \Yii::$app->db->createCommand($sql)->
									bindParam(':issue_name', $issue_name)->
									bindParam(':user_id', $user_id)
									->queryAll();
		}


	}


	/**
	 * WEAKNESS: it is not right, it is wrong
	 * @return array
	 */
	public static function getTop10TrendingTopic() {
		//Retrieve top 10 trending topic which counted from participants
		$sql = "SELECT count( distinct comment.user_id)  as total_user, thread.* from thread, thread_comment, comment
				where thread.thread_id = thread_comment.thread_id and
					comment.comment_id = thread_comment.comment_id and
					WEEKOFYEAR(from_unixtime(comment.created_at)) = WEEKOFYEAR(now())
				group by thread.thread_id
				order by total_user desc
				limit 10
		";

		return \Yii::$app->db->createCommand($sql)->queryAll();
	}


	public static function retrieveAll() {
		return self::find()->all();
	}

	/**
	 *
	 * @param $thread_id
	 * @param $user_id
	 * @return array|false
	 */
	public static function retrieveThreadById($thread_id, $user_id) {
		if(empty($user_id)) {
			$user_id = 0;
		}

		$sql = "SELECT TU.*,
					(SELECT choice_text from thread_vote where thread_id = :thread_id and user_id = :user_id) as user_choice
				  	FROM (SELECT thread.*, user.id, user.first_name, user.last_name from thread inner join user on thread.user_id = user.id) TU
					where thread_id = :thread_id";

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
							 user, thread_issue
				 where thread_thread_rate.user_id = user.id and user.id in (SELECT followee_id from follower_relation where follower_id = :follower_id )
				 group by(thread_thread_rate.thread_id)
				 order by (date_created) desc";

		return \Yii::$app->db
			->createCommand($sql)
			->bindParam(':follower_id', $follower_id)
			->queryAll();
	}

	public static function getThreadStartersByUserId($user_id){

		$sql = "SELECT * from thread where user_id = :user_id";

		return \Yii::$app->db
			->createCommand($sql)
			->bindParam(':user_id', $user_id)
			->queryAll();

	}

	public static function getThreadBySearch($q){
		$q = '%' . $q . '%';
		$sql = "Select thread_id as id, title as text from thread where title like :query and thread.thread_status = 10";

		return \Yii::$app->db
			->createCommand($sql)
			->bindParam(':query', $q)
			->queryAll();
	}
}