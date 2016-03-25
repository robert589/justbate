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

    public $crop_info;

    public function rules()
    {
        return [
            [
                'imageFile',
                'file',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
            ],
            ['crop_info', 'safe'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {

            $extension = $this->imageFile->getExtension();

            // open image
            $this->imageFile = Image::getImagine()->open($this->imageFile->tempName);

            // rendering information about crop of ONE option 
            $crop_info = Json::decode($this->crop_info)[0];
            $crop_info['dWidth'] = (int)$crop_info['dWidth']; //new width image
            $crop_info['dHeight'] = (int)$crop_info['dHeight']; //new height image
           // $crop_info['x'] = $crop_info['x']; //begin position of frame crop by X
            //$crop_info['y'] = $crop_info['y']; //begin position of frame crop by Y

            $uniqId = uniqid();
            $user_id = Yii::$app->user->getId();
            $dir = $this->getDirectory();
            $file_name = $uniqId . '_' . $dir . '_'  . $user_id . '.' . $extension;
            $total_path  = $dir . '/' . $file_name;
            //saving thumbnail
            $newSizeThumb = new Box($crop_info['dWidth'], $crop_info['dHeight']);
            $cropSizeThumb = new Box(200, 200); //frame size of crop
            $cropPointThumb = new Point($crop_info['x'], $crop_info['y']);
            //profile save
            $pathThumbImage = Yii::getAlias('@image_dir_local')
                . '/' . $dir . '/' . $file_name;

            $this->imageFile->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);

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
