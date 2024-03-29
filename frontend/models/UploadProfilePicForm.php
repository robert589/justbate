<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use common\models\User;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;

define('MAXIMUM_FILE_SIZE_PER_DIRECTORY', 1000);
define('RECORD_LAST_DIR_PATH', Yii::getAlias('@image_dir') . '/last_dir.txt');

class UploadProfilePicForm extends Model
{
    /**
     * @var UploadForm::imageFiles
     */
    public $imageFile;

    public function rules()
    {
        return [
            [
                'imageFile',
                'file',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
            ],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {

            $extension = $this->imageFile->getExtension();


            $uniqId = uniqid();
            $user_id = Yii::$app->user->getId();
            $dir = $this->getDirectory();
            $file_name = $uniqId . '_' . $dir . '_'  . $user_id . '.' . $extension;
            $total_path  = $dir . '/' . $file_name;

            $this->imageFile->saveAs(Yii::getAlias('@image_dir_local') . '/' . $total_path);

            if($this->updateToUserProfile($total_path)){
                return true;

            }
            else{
                return true;
            }
        } else {
            Yii::$app->end('error');
            return false;
        }
    }

    public function uploadFacebookPhoto($photos){
        $uniqId = uniqid();
        $user_id = Yii::$app->user->getId();
        $dir = self::getDirectory();
        $file_name = $uniqId . '_' . $dir . '_'  . $user_id . '.' . 'jpg';
        $total_path  = $dir . '/' . $file_name;

        $full_path_name = Yii::getAlias('@image_dir_local') . '/'. $total_path;
        $file = fopen($full_path_name, 'w');
        fputs($file, $photos);
        fclose($file);

        return $total_path;
    }

    private function getDirectory(){
        $myfile = fopen(Yii::getAlias('@last_dir_path'), "r") or Yii::$app->end("Unable to open file!");
        $dir_name = fread($myfile, filesize(Yii::getAlias('@last_dir_path')));

        if($this->checkDirectoryAvailability($dir_name)){
            return $dir_name;
        }
        else{
            if($new_dir = $this->getNewDirectory($dir_name)){
                return $new_dir;
            }
        }
    }

    private function checkDirectoryAvailability($dir_name){
        $dir_path = Yii::getAlias('@image_dir_local') . '/' . $dir_name;

        $fi = glob($dir_path);

        $total_size = count($fi);

        if($total_size >= MAXIMUM_FILE_SIZE_PER_DIRECTORY){
            return false;
        }

        return true;

    }
    private function createNewDirectory($new_dir){
        if($this->saveNewDirectory($new_dir) != false){
            return mkdir(Yii::getAlias('@image_dir_local') . '/' . $new_dir);

        }
        else{
            return false;
        }
    }


    private function getNewDirectory($old_dir){
        $new_dir = $this->getNewDirectoryName($old_dir);

        if( $this->createNewDirectory($new_dir)){

            return $new_dir;
        }
        else{
            return false;
        }
    }

    private function getNewDirectoryName($old_dir){
        $old_dir_integer = intval($old_dir);
        $new_dir = $old_dir_integer + 1;

        return strval($new_dir);
    }

    private function saveNewDirectory($new_dir){
        return file_put_contents(Yii::getAlias('@last_dir_path'), $new_dir);
    }

    private function updateToUserProfile($total_path){

        $user = User::findOne(\Yii::$app->user->getId());
        $user->photo_path = $total_path;
        $user->update(false);
        return true;
    }
}
