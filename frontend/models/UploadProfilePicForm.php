<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;

use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;

class UploadProfilePicForm extends Model
{
    const MAXIMUM_FILE_SIZE_PER_DIRECTORY = 5;
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

            $uniqid = uniqid();

            //saving thumbnail
            $newSizeThumb = new Box($crop_info['dWidth'], $crop_info['dHeight']);
            $cropSizeThumb = new Box(200, 200); //frame size of crop
            $cropPointThumb = new Point($crop_info['x'], $crop_info['y']);
            $pathThumbImage = Yii::getAlias('@image_dir')
                . '/dir'
                . $uniqid
                . '.'
                . $extension;

            $user_id = Yii::$app->user->getId();
            $dir = $this->getDirectory();
            $this->imageFile->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);

            return true;
        } else {
            Yii::$app->end('error');
            return false;
        }
    }

    private function getDirectory(){
        $path = Yii::getAlias('@image_dir') . '/last_dir.txt';
        $myfile = fopen($path, "r") or Yii::$app->end("Unable to open file!");
    }

    private function checkDirectoryAvailability($dir_name){
        $dir_path = Yii::getAlias('@image_dir') . '/' . $dir_name;

        $fi = glob($dir_path);

        printf("There were %d Files", count($fi));
    }
}
