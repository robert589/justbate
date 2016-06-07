<?php

namespace backend\creator;

use yii\base\Exception;
use yii\data\ArrayDataProvider;

use backend\entity\HomeEntity;
use backend\entity\ThreadEntity;

use common\models\Thread;

class HomeCreator implements CreatorInterface
{
    const NEED_ALL_THREADS = 1;
    const NEED_THREAD_COMMENTS = 2;
    const NEED_CHILD_COMMENT = 3;
    const NEED_ALL_ISSUES = 4;
    const NEED_WELCOME = 5;

    /**
     * @var HomeEntity
     */
    public $home;

    /**
     * HomeCreator constructor.
     * @param HomeEntity $home
     */
     function __construct(HomeEntity $home)
     {
         $this->home = $home;

         $this->validateModel();
     }

     function validateModel()
     {
         //id must not empty
         if(is_nan($this->home->getCurrentUserLoginId())){
             throw new Exception("Login User id must not be empty");
         }
     }

     /**
      * @param array $config
      * @return ThreadEntity
      */
     public function get(array $needs)
     {
         foreach ($needs as $need) {
             switch ($need) {
                 case self::NEED_ALL_THREADS:
                     $this->getAllThreads();
                     break;

                case self::NEED_THREAD_COMMENTS:
                    $this->getThreadComments();
                    break;

                case self::NEED_CHILD_COMMENT:
                    $this->getChildComment();
                    break;

                case self::NEED_ALL_ISSUES:
                    $this->getAllIssues();
                    break;

                case self::NEED_WELCOME:
                    $this->getWelcomeMessage();
                    break;

                 default:
                     break;
             }
         }
         return $this->home;
     }

     private function getAllThreads()
     {
         
     }

     private function getThreadComments()
     {

     }

     private function getChildComment()
     {

     }

     private function getAllIssues()
     {

     }

     private function getWelcomeMessage()
     {
         $this->home->setWelcome("Welcome to Administrator Homepage!");
         $this->home->setDesc("This other side of JustBate.com remains accessible only by authenticated users.");
     }
}

?>
