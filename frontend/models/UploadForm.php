<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;

class UploadForm extends Model
{
    /**
     * @var UploadForm::imageFiles
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('startUp/backend' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
