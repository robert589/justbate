<?php

namespace frontend\vo;

use common\components\DateTimeFormatter;
use common\models\NotificationType;
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

    private $extra_value;

    private $notification_type_name;

    private $notification_verb_name;

    private $anonymous;

    static function createBuilder(){
        return new NotificationVoBuilder();
    }

    function __construct(NotificationVoBuilder $builder)
    {
        $this->read = $builder->getRead();
        $this->url_template = $builder->getUrlTemplate();
        $this->text_template = $builder->getTextTemplate();
        $this->text_template_two_people = $builder->getTextTemplateTwoPeople();
        $this->text_template_more_than_two_people = $builder->getTextTemplateMoreThanTwoPeople();
        $this->url_key_value = $builder->getUrlKeyValue();
        $this->actors_in_string = $builder->getActorsInString();
        $this->photo_path = $builder->getPhotoPath();
        $this->notification_type_name = $builder->getNotificationTypeName();
        $this->notification_verb_name = $builder->getNotificationVerbName();
        $this->extra_value = $builder->getExtraValue();
        $this->anonymous = $builder->getAnonymous();
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
        if($this->notification_type_name === NotificationType::THREAD_TYPE ){
            return Yii::$app->request->baseUrl . '/' . $this->replace($this->url_template,
                [$this->url_key_value, str_replace(' ' , '-', strtolower($this->extra_value))]);
        }

        return null;
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
        if($this->anonymous){
            return Yii::$app->request->baseUrl . '/frontend/web/photos/default.png';
        }
        else{
            return Yii::$app->request->baseUrl . '/frontend/web/photos/' . $this->photo_path;

        }
    }



    /**
     * @return mixed
     */
    public function getText()
    {
        $actors  = explode("%,%", $this->actors_in_string);
        $actors = array_map(function($actor) { return ucfirst($actor); }, $actors);

        switch(count($actors)){
            case 1:
                if($this->anonymous){
                    $text= $this->replace($this->text_template, array('Anonymous'));
                }
                else{
                    $text= $this->replace($this->text_template, $actors);
                }

                break;
            case 2:
                if($this->anonymous){
                    $text= $this->replace($this->text_template_more_than_two_people, array('Anonymous', 1));
                }
                else{
                   $text= $this->replace($this->text_template_two_people, $actors);
                }
                break;
            case 3: $text= $this->replace($this->text_template_more_than_two_people, [$actors[0], count($actors) - 1]);
                break;
            default:
                $text = $this->replace($this->text_template, $actors);
                break;
        }
        return $text;
    }


    private function replace($text, $args){

        foreach($args as $index => $arg){
            $text = str_replace('%'. ($index + 1) . '$%',"$arg", $text);
        }

        return $text;
    }

}