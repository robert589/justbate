<?php

namespace common\entity;

use common\components\DateTimeFormatter;
use Yii;
use yii\data\ArrayDataProvider;

class NotificationEntity implements Entity{

    const ACTOR_SEPARATOR = "%,%";


    private $is_read;

    private $url_template;

    private $text_template;


    private $text_template_two_people;

    private $text_template_more_than_two_people;

    private $url_key_value;

    private $actors_in_string;

    private $photo_path;

    /**
     * @return mixed
     */
    public function getPhotoPath()
    {
        return Yii::$app->request->baseUrl . '/frontend/web/photos/ ' . $this->photo_path;
    }

    /**
     * @param mixed $photo_path
     */
    public function setPhotoPath($photo_path)
    {
        $this->photo_path = $photo_path;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->replace($this->url_template, [$this->url_key_value]);
    }

    /**
     * @param mixed $url_key_value
     */
    public function setUrlKeyValue($url_key_value)
    {
        $this->url_key_value = $url_key_value;
    }

    /**
     * @param mixed $actors_in_string
     */
    public function setActorsInString($actors_in_string)
    {
        $this->actors_in_string = $actors_in_string;
    }

    /**
     * @return mixed
     */
    public function getTextTemplateMoreThanTwoPeople()
    {
        return $this->text_template_more_than_two_people;
    }

    /**
     * @param mixed $text_template_more_than_two_people
     */
    public function setTextTemplateMoreThanTwoPeople($text_template_more_than_two_people)
    {
        $this->text_template_more_than_two_people = $text_template_more_than_two_people;
    }

    /**
     * @return mixed
     */
    public function getTextTemplateTwoPeople()
    {
        return $this->text_template_two_people;
    }

    /**
     * @param mixed $text_template_two_people
     */
    public function setTextTemplateTwoPeople($text_template_two_people)
    {
        $this->text_template_two_people = $text_template_two_people;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        $actors  = explode("%,%", $this->actors_in_string);
        switch(count($actors)){
            case 1: $text= $this->replace($this->text_template, $actors);
                break;

            case 2: $text= $this->replace($this->text_template, $actors);
                break;

            case 3: $text= $this->replace($this->text_template, $actors);
                break;
            default:
                $text = $this->replace($this->text_template, $actors);
                break;
        }
        return $text;
    }

    /**
     * @param mixed $text_template
     */
    public function setTextTemplate($text_template)
    {
        $this->text_template = $text_template;
    }



    /**
     * @param mixed $url_template
     */
    public function setUrlTemplate($url_template)
    {
        $this->url_template = $url_template;
    }


    /**
     * @return mixed
     */
    public function getIsRead()
    {
        return $this->is_read;
    }

    /**
     * @param mixed $is_read
     */
    public function setIsRead($is_read)
    {
        $this->is_read = $is_read;
    }

    private function replace($text, $args){
        foreach($args as $index => $arg){
            $text = str_replace('%'. $index . '$%',"$arg", $text);
        }

        return $text;
    }

}