<?php
namespace frontend\models;

use common\models\ValidationToken;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use common\models\ThreadVote;
use common\models\User;

class ValidateAccountForm extends Model
{
    public $user_id;

    public $code;

    const CODE_IS_WRONG = 'code_is_wrong';

    public function rules()
    {
        return [
            ['user_id', 'integer'],
            ['code', 'integer'],
            [['user_id', 'code'], 'required']
        ];
    }


    public function validateAccount(){
        if(ValidationToken::find()->where(['user_id' => $this->user_id])->one()['code'] == $this->code){
            $user = User::findOne(['id' => $this->user_id]);
            if($user->validated == 0){
                $user->validated = 1;
                if(!$user->update(false)){
                    //error
                    Yii::$app->end('Update failed');
                }
            }

            ValidationToken::deleteAll(['user_id' => $this->user_id]);
            return true;

        }
        else{
            return false;
        }
    }





}
