<?php
namespace frontend\dao;

use common\models\Notification;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\NotificationVo;
use frontend\vo\NotificationVoBuilder;

class ListNotificationDao{
    const NOTIFICATION_SQL = "SELECT notification_entity.*, notification_actors.actors, last_actor.photo_path
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


    function buildListNotification($user_id ,ListNotificationVoBuilder $builder){

        // DAO
        $results =  \Yii::$app->db
            ->createCommand(self::NOTIFICATION_SQL)
            ->bindValues([':user_id' => $user_id])
            ->queryAll();

        $list_notification = array();
        foreach($results as $result){
            $notification_builder = NotificationVo::createBuilder();
            $notification_builder->read($result['is_read']);
            $notification_builder->actorsInString($result['actors']);
            $notification_builder->urlTemplate($result['url_template']);
            $notification_builder->textTemplate($result['text_template']);
            $notification_builder->textTemplateTwoPeople($result['text_template_two_people']);
            $notification_builder->textTemplateMoreThanTwoPeople($result['text_template_more_than_two_people']);
            $notification_builder->urlKeyValue($result['url_key_value']);
            $notification_builder->photoPath($result['photo_path']);
            $list_notification[] = $notification_builder->build();
        }

        $builder->listNotification($list_notification);

        return $builder;


    }
}