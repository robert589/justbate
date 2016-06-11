<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password

 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public static function getUsername($id){
        return Self::find()->where(['id' => $id])->one()['username'];
    }

    /**
     * @param $q query
     */
    public static function getUserList($q){
        $sql = "SELECT id, concat(first_name, ' ', last_name) as text
                   from user
                   where first_name like concat('%', :q,'%') or last_name like concat('%', :q, '%')
                   limit 10";

        return Yii::$app->db->createCommand($sql)->
                bindParam(":q", $q)->
                queryAll();
    }



    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }



    /**
             * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Get fullname
     */
    public function getfullName(){
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get Fullname and Occupation
     * @return string
     */
    public function getfullNameAndOccupation(){
        return $this->getfullName() . ' - ' . $this->occupation;
    }



    /**
     * Get user based on id or username
     * @return array|null|ActiveRecord
     */
    public function getUser(){
        if(isset($this->username)){
            return $this->find()->where(['username' => $this->username])->one();

        }
        else if(isset($this->id)){
            return $this->find()->where(['id' => $this->id])->one();

        }
    }


    public function checkUsernameExist(){
        return $this->find()->where(['username' => $this->username])->exists();
    }

}
