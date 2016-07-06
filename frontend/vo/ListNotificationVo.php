<?php


namespace frontend\vo;

use common\components\DateTimeFormatter;
use Yii;
use yii\data\ArrayDataProvider;

class ListNotificationVo implements Vo{

    private $list_notification;

    private $num_of_new_notification;


    static function createBuilder(){
        return new ListNotificationVoBuilder();
    }

    function __construct(ListNotificationVoBuilder $builder)
    {
        $this->list_notification = $builder->getListNotification();
        $this->num_of_new_notification = $builder->getNumOfNewNotification();
    }

    /**
     * @return mixed
     */
    public function getListNotificationProvider()
    {
        return  new \yii\data\ArrayDataProvider([
            'allModels' => $this->list_notification,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }

    /**
     * @return mixed
     */
    public function getNumOfNewNotification()
    {
        return $this->num_of_new_notification;
    }

    public function convertTitle($title){
        return $this->delete_all_between("(", ")", $title);
    }


    private function delete_all_between($beginning, $end, $string) {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return str_replace($textToDelete, '', $string);
    }



}