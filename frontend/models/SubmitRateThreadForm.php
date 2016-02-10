<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use common\models\ThreadRate;

class SubmitRateThreadForm extends Model
{
    public $user_id;

    public $thread_id;

    public $rate;


    public function rules()
    {
        return [
            [['choice_text'], 'required'],
            [['user_id', 'thread_id'], 'integer'],
            ['rate', 'integer']
        ];
    }

    //bad practice, change it
    public function insertRating(){

        if($this->checkExists()){
            $model = ThreadRate::findOne(['user_id' => $this->user_id, 'thread_id' => $this->thread_id]);
            if($model->rate == $this->rate){
                return true;
            }
            else{
                $model->rate = $this->rate;
                if($model->update()){
                    return true;
                }
                else{
                    return false;
                }
            }

        }
        else{

            $rateModel = new SubmitRateThreadForm();
            $rateModel->thread_id = $this->thread_id;
            $rateModel->user_id = $this->user_id;
            $rateModel->rate = $this->rate;

            if($rateModel->save()){
                return true;
            }
            else{
                return false;
            }
        }
    }

    public function checkExists(){
        return ThreadRate::find()
            ->where(['user_id' => $this->user_id])
            ->andWhere(['thread_id' => $this->thread_id])
            ->exists();
    }
}
