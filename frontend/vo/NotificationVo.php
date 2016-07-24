<?php

namespace frontend\vo;

use common\components\DateTimeFormatter;
use common\libraries\CommentUtility;
use common\models\Notification;
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

    private $actors;

    private $photo_path;

    private $extra_value;

    private $notification_type_name;

    private $notification_verb_name;

    private $anonymous;

    private $time;

    private $notification_id;

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
        $this->actors = $builder->getActors();
        $this->photo_path = $builder->getPhotoPath();
        $this->notification_type_name = $builder->getNotificationTypeName();
        $this->notification_verb_name = $builder->getNotificationVerbName();
        $this->extra_value = $builder->getExtraValue();
        $this->anonymous = $builder->getAnonymous();
        $this->time = $builder->getTime();
        $this->notification_id = $builder->getNotificationId();
    }

    /**
     * @return mixed
     */
    public function getRead()
    {
        return $this->read;
    }

    public function getTime() {
        return DateTimeFormatter::getTimeText($this->time);
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        if($this->notification_type_name === NotificationType::THREAD_TYPE ){
            return Yii::$app->request->baseUrl . '/' . $this->replace($this->url_template,
                [$this->url_key_value[0], str_replace(' ' , '-', strtolower($this->extra_value))]);
        }
        else if($this->notification_type_name === NotificationType::COMMENT_TYPE) {
            return Yii::$app->request->baseUrl . '/' . $this->replace($this->url_template,
                [$this->url_key_value[0], $this->url_key_value[1], str_replace(' ' , '-', strtolower($this->extra_value))]);
        }

        return null;
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
        if($this->notification_type_name === NotificationType::THREAD_TYPE){
            return $this->getThreadText();
        }
        else if($this->notification_type_name === NotificationType::COMMENT_TYPE) {
            return $this->getCommentText();
        }
    }

    private function getCommentText(){
        $cut_text_value = CommentUtility::cutText($this->extra_value);
        if($this->anonymous){
            $actors[] = 'Anonymous';
        }
        else {
            $actors = array_map(function($actor) { return ucfirst($actor); }, $this->actors);
        }
        $actors[] = $cut_text_value;

        switch(count($this->actors)){
            case 1:
                $text= $this->replace($this->text_template, $actors);
                break;
            case 2:
                if($this->anonymous){
                    $text= $this->replace($this->text_template_two_people, array('Anonymous', $cut_text_value));
                }
                else{
                    $text= $this->replace($this->text_template_two_people, $actors);
                }
                break;
            case 3: $text= $this->replace($this->text_template_more_than_two_people, [$actors[0], count($actors) - 1, $cut_text_value ]);
                break;
            default:
                $actors[] = $cut_text_value;
                $text = $this->replace($this->text_template, $actors);
                break;
        }
        return $text;
    }



    private function getThreadText(){
        $cut_thread_text = CommentUtility::cutText($this->extra_value);
        if($this->anonymous){
            $actors[] = 'Anonymous';
        }
        else {
            $actors = array_map(function($actor) { return ucfirst($actor); }, $this->actors);
        }
        $actors[] =  $cut_thread_text;
        switch(count($this->actors)){
            case 1:
                $text= $this->replace($this->text_template, $actors);
                break;
            case 2:
                if($this->anonymous){
                    $text= $this->replace($this->text_template_two_people, array('Anonymous', $cut_thread_text));
                }
                else{
                    $actors[] =  $cut_thread_text;
                    $text= $this->replace($this->text_template_two_people, $actors);
                }
                break;
            case 3: $text= $this->replace($this->text_template_more_than_two_people, [$actors[0], count($actors) - 1, $cut_thread_text]);
                break;
            default:
                $actors[] = $cut_thread_text;
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

    /**
     * @return mixed
     */
    public function getNotificationId()
    {
        return $this->notification_id;
    }



}