<?php
namespace frontend\models;

use common\models\User;
use common\models\Comment;
use yii\base\Model;
use yii\db\Expression;

use Yii;

/**
 * Signup form
 */
class EditCommentForm extends Model
{
	public $comment;
	public $parent_id;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['parent_id'], 'integer'],
			[['comment', 'parent_id'] , 'required'],


	   ];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function update()
	{
		if ($this->validate()) {

			$comment = Comment::findOne($this->parent_id);
			$comment->updated_at = new Expression('NOW()');
			$comment->comment = $this->comment;
			if($comment->update()){
				return true;
			}

			return null;
		}

		return null;
	}
}
