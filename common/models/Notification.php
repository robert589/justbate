<?php

namespace common\models;
use common\entity\NotificationEntity;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Notification model
 *
 * @property integer $notification_id
 * @property boolean $read
 * @property string $notification_type_name
 * @property string $notification_verb_name
 * @property string $url_key_value
 */
class Notification extends ActiveRecord{

    public static function tableName()
    {
        return 'notification';
    }



    public static function getAllNotifications($user_id){
        $sql = "SELECT notification_entity.*, notification_actors.actors, last_actor.photo_path
                from (SELECT notification_type.url_template,notification_verb.text_template,
                            notification_verb.text_template_two_people,
                            notification_verb.text_template_more_than_two_people, notification.*
                      from notification_type, notification_verb, notification, notification_receiver
                      where notification_type.notification_type_name = notification_verb.notification_type_name
                            and notification_verb.notification_verb_id = notification.notification_verb_id
                            and notification_receiver.notification_id = notification.notification_id
                            and notification_receiver.receiver_id = :user_id) notification_entity
		        left join
                    (SELECT n.notification_id,
                           group_concat(actor.first_name SEPARATOR '%,%') as actors
                    FROM notification n, notification_actor na, user actor
                    WHERE n.notification_id = na.notification_id
                    and actor.id = na.actor_id
                    group by na.notification_id
                    ) notification_actors
                on notification_actors.notification_id = notification_entity.notification_id
                left join(
       			SELECT u.photo_path, n.notification_id
           		from notification n, notification_actor na, user u
           		where n.notification_id = na.notification_id and
           		na.actor_id = u.id and
           		na.updated_at = (SELECT max(na1.updated_at)
                                   from notification_actor na1
                                   where n.notification_id = na1.notification_id
                             	   )
           ) last_actor
      on notification_entity.notification_id = last_actor.notification_id";

        // DAO
        $results =  \Yii::$app->db
            ->createCommand($sql)
            ->bindValues([':user_id' => $user_id])
            ->queryAll();

        $notification_entities = array();

        foreach($results as $result){
            $notification_entity = new NotificationEntity();
            $notification_entity->setUrlTemplate($result['url_template']);
            $notification_entity->setTextTemplate($result['text_template']);
            $notification_entity->setTextTemplateTwoPeople($result['text_template_two_people']);
            $notification_entity->setTextTemplateMoreThanTwoPeople($result['text_template_more_than_two_people']);
            $notification_entity->setIsRead($result['is_read']);
            $notification_entity->setUrlKeyValue($result['url_key_value']);
            $notification_entity->setActorsInString($result['actors']);
            $notification_entity->setPhotoPath($result['photo_path']);
            $notification_entities[] = $notification_entity;
        }

        return $notification_entities;
    }
}