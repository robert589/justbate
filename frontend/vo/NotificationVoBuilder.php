<?php
namespace frontend\vo;

class NotificationVoBuilder{
    private $read;

    private $url_template;

    private $text_template;

    private $text_template_two_people;

    private $text_template_more_than_two_people;

    private $url_key_value;

    private $actors;

    private $photo_path;

    private $notification_type_name;

    private $notification_verb_name;

    private $extra_value;

    private $anonymous;

    private $time;

    private $notification_id;

    /**
     * @return mixed
     */
    public function getNotificationId()
    {
        return $this->notification_id;
    }

    /**
     * @param mixed $notification_id
     */
    public function setNotificationId($notification_id)
    {
        $this->notification_id = $notification_id;
    }


    function __construct(){

    }

    function read($read){
        $this->read = $read;
    }


    function anonymous($anonymous){
        $this->anonymous = $anonymous;
    }

    function urlTemplate($url_template){
        $this->url_template = $url_template;
    }

    function textTemplate($text_template){
        $this->text_template = $text_template;
    }

    function textTemplateTwoPeople($text_template_two_people){
        $this->text_template_two_people = $text_template_two_people;
    }

    function textTemplateMoreThanTwoPeople($text_template_more_than_two_people){
        $this->text_template_more_than_two_people = $text_template_more_than_two_people;
    }

    function urlKeyValue($url_key_value){
        $this->url_key_value  = explode("%,%", $url_key_value);
    }

    function actorsInString($actors_in_string){
        $this->actors  = explode("%,%", $actors_in_string);
    }

    function photoPath($photo_path){
        $this->photo_path = $photo_path;
    }

    function notificationTypeName($notification_type_name){
        $this->notification_type_name = $notification_type_name;
    }

    function notificationVerbName($notification_verb_name){
        $this->notification_verb_name = $notification_verb_name;
    }

    function extraValue($extra_value){
        $this->extra_value = $extra_value;
    }

    function setTime($time) {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getRead() {
        return $this->read;
    }

    /**
     * @return mixed
     */
    public function getPhotoPath() {
        return $this->photo_path;
    }

    /**
     * @return mixed
     */
    public function getActors() {
        return $this->actors;
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
    public function getTextTemplateTwoPeople()
    {
        return $this->text_template_two_people;
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
    public function getUrlTemplate()
    {
        return $this->url_template;
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
    public function getNotificationTypeName()
    {
        return $this->notification_type_name;
    }

    /**
     * @return mixed
     */
    public function getNotificationVerbName()
    {
        return $this->notification_verb_name;
    }

    /**
     * @return mixed
     */
    public function getExtraValue()
    {
        return $this->extra_value;
    }

    public function getAnonymous(){
        return $this->anonymous;
    }

    public function getTime() {
        return $this->time;
    }

    function build(){
        return new NotificationVo($this);
    }
}