<?php
namespace frontend\dao;

use common\models\Notification;
use frontend\vo\ListNotificationVoBuilder;
use frontend\vo\NotificationVo;
use frontend\vo\NotificationVoBuilder;

class ListNotificationDao{
    const NUM_OF_NEW_NOTIFICATION = "SELECT count(*)
                                from (SELECT notification.*
                                      from notification, notification_receiver
                                      where notification_receiver.notification_id = notification.notification_id
                                            and notification_receiver.receiver_id = :user_id) notification_entity
                                left join
                                    (SELECT n.notification_id,
                                           group_concat(actor.first_name SEPARATOR '%,%') as actors
                                    FROM notification n, notification_actor na, user actor
                                    WHERE n.notification_id = na.notification_id
                                    and actor.id = na.actor_id and actor.id <> :user_id
                                    group by na.notification_id
                                    order by na.updated_at desc
                                    ) notification_actors
                                on notification_actors.notification_id = notification_entity.notification_id
                                left join(
                                    SELECT na.updated_at,na.actor_id, n.notification_id
                                    from notification n, notification_actor na
                                    where n.notification_id = na.notification_id and
                                          na.updated_at = (SELECT max(na1.updated_at)
                                                           from notification_actor na1
                                                           where n.notification_id = na1.notification_id
                                                           and na1.actor_id <> :user_id)
                                  ) last_actor
                                on notification_entity.notification_id = last_actor.notification_id
                                where last_actor.actor_id is not null and updated_at > (SELECT notif_last_seen from user where id = :user_id)";

    const NOTIFICATION_SQL = "SELECT notification_entity.*,
		notification_actors.actors, notification_actors.updated_at,
        last_actor.photo_path, last_actor.updated_at, last_actor.actor_id,
        notification_extra_value.extra_value, thread_anonymous.anonymous_id as anonymous
                                from (SELECT notification_type.url_template,
                                      		notification_verb.text_template,
                                            notification_verb.text_template_two_people,
                                            notification_verb.text_template_more_than_two_people, notification.*,
                                            notification_receiver.is_read
                                      from notification_type, notification_verb, notification, notification_receiver
                                      where notification_type.notification_type_name = notification_verb.notification_type_name
                                            and notification_verb.notification_verb_name = notification.notification_verb_name
                                      		and notification_verb.notification_type_name = notification.notification_type_name
                                            and notification_receiver.notification_id = notification.notification_id
                                            and notification_receiver.receiver_id = :user_id) notification_entity
                                left join
                                    (SELECT n.notification_id,
                                           na.updated_at,
                                           group_concat(actor.first_name SEPARATOR '%,%') as actors
                                    FROM notification n, notification_actor na, user actor
                                    WHERE n.notification_id = na.notification_id
                                    and actor.id = na.actor_id and actor.id <> :user_id
                                    group by na.notification_id
                                    order by na.updated_at desc
                                    ) notification_actors
                                on notification_actors.notification_id = notification_entity.notification_id
                                left join(
                                    SELECT u.photo_path, n.notification_id, na.updated_at,na.actor_id
                                    from notification n, notification_actor na, user u
                                    where n.notification_id = na.notification_id and
                                          na.actor_id = u.id and
                                          na.updated_at = (SELECT max(na1.updated_at)
                                                           from notification_actor na1
                                                           where n.notification_id = na1.notification_id
                                                           and na1.actor_id <> :user_id

                                                             )
                                  ) last_actor
                                on notification_entity.notification_id = last_actor.notification_id
                                left join notification_extra_value
                                on notification_extra_value.notification_type_name = notification_entity.notification_type_name
                                and notification_extra_value.url_key_value = notification_entity.url_key_value
                                left join thread_anonymous
                                on notification_entity.url_key_value = thread_anonymous.thread_id
                                and thread_anonymous.user_id = last_actor.actor_id and notification_entity.notification_type_name = 'thread'
             					where last_actor.actor_id is not null
                                order by notification_actors.updated_at desc";


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
            $notification_builder->notificationTypeName($result['notification_type_name']);
            $notification_builder->notificationVerbName($result['notification_verb_name']);
            $notification_builder->extraValue($result['extra_value']);
            $notification_builder->anonymous($result['anonymous']);
            $notification_builder->setTime($result['updated_at']);
            $notification_builder->setNotificationId($result['notification_id']);
            $list_notification[] = $notification_builder->build();
        }

        $builder->listNotification($list_notification);

        return $builder;


    }

    function getNumOfNewNotification($user_id) {
        // DAO
        $result =  \Yii::$app->db
            ->createCommand(self::NUM_OF_NEW_NOTIFICATION)
            ->bindValues([':user_id' => $user_id])
            ->queryScalar();

        return $result;
    }
}