<?php
namespace frontend\vo;

class NotificationVoBuilder{
    private $read;

    private $url_template;

    private $text_template;

    private $text_template_two_people;

    private $text_template_more_than_two_people;

    private $url_key_value;

    private $actors_in_string;

    private $photo_path;

    function __construct(){

    }

    function read($read){
        $this->read = $read;
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
        $this->url_key_value = $url_key_value;
    }

    function actorsInString($actors_in_string){
        $this->actors_in_string = $actors_in_string;
    }

    function photoPath($photo_path){
        $this->photo_path = $photo_path;
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
    public function getPhotoPath()
    {
        return $this->photo_path;
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



    function build(){
        return new NotificationVo($this);
    }
}