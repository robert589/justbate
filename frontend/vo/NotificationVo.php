<?php

namespace frontend\vo;

use common\components\DateTimeFormatter;
use Yii;
use yii\data\ArrayDataProvider;

class NotificationVo implements Vo{

    const ACTOR_SEPARATOR = "%,%";

    private $read;

    private $url_template;

    private $text_template;

    private $text_template_two_people;

    private $text_template_more_than_two_people;

    private $url_key_value;

    private $actors_in_string;

    private $photo_path;

    static function createBuilder(){
        return new NotificationVoBuilder();
    }

    function __construct(NotificationVoBuilder $builder)
    {
        $this->read = $builder->getRead();
        $this->url_template = $builder->getTextTemplate();
        $this->text_template = $builder->getTextTemplate();
        $this->text_template_two_people = $builder->getTextTemplateTwoPeople();
        $this->text_template_more_than_two_people = $builder->getTextTemplateMoreThanTwoPeople();
        $this->url_key_value = $builder->getUrlKeyValue();
        $this->actors_in_string = $builder->getActorsInString();
        $this->photo_path = $builder->getActorsInString();

    }

    /**
     * @return mixed
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->replace($this->url_template, [$this->url_key_value]);
    }

    /**
     * @return mixed
     */
    public function getTextTemplate()
    {
        return $this->text_template;
    }

    /**
     * @return mixed
     */
    public function getTextTemplateTwoPeople()
    {
        return $this->text_template_two_people;
    }

    /**
     * @return mixed
     */
    public function getTextTemplateMoreThanTwoPeople()
    {
        return $this->text_template_more_than_two_people;
    }

    /**
     * @return mixed
     */
    public function getUrlKeyValue()
    {
        return $this->url_key_value;
    }

    /**
     * @return mixed
     */
    public function getActorsInString()
    {
        return $this->actors_in_string;
    }

    /**
     * @return mixed
     */
    public function getPhotoPath()
    {
        return $this->photo_path;
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


    private function replace($text, $args){
        foreach($args as $index => $arg){
            $text = str_replace('%'. $index . '$%',"$arg", $text);
        }

        return $text;
    }

}