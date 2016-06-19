<?php

use yii\db\Migration;

class m160618_073619_update_notification extends Migration
{
    public function up()
    {
        $this->execute(
            "RENAME TABLE notification to old_notification;
            CREATE TABLE notification_type(
                notification_type_name varchar(255) not null primary key,
                url_template varchar(255) not null,
                created_at int not null,
                updated_at int not null
            );
            Create table notification_verb(
                notification_verb_id int not null primary key auto_increment,
                notification_verb_name varchar(255) not null,
                notification_type_name varchar(255) not null,
                text_template varchar(255) not null,
                text_template_two_people varchar(255) null,
                text_template_more_than_two_people varchar(255) null,
                created_at int not null,
                updated_at int not null,
                foreign key (notification_type_name) references notification_type(notification_type_name)
            );

            Create table notification(
                notification_id int not null primary key auto_increment,
                is_read boolean not null default false,
                notification_verb_id int not null,
                url_key_value int not null,
                foreign key(notification_verb_id) references notification_verb(notification_verb_id)
            );

            Create table notification_receiver(
                notification_id int not null,
                receiver_id int not null,
                created_at int not null,
                updated_at int not null,
                primary key(notification_id, receiver_id),
                foreign key(notification_id) references notification(notification_id),
                foreign key(receiver_id) references user(id)
            );

            Create table notification_actor(
                notification_id int not null,
                actor_id int not null,
                created_at int not null,
                updated_at int not null,
                primary key(notification_id, actor_id),
                FOREIGN key(notification_id) REFERENCES  notification(notification_id),
                FOREIGN key(actor_id) REFERENCES  user(id)
            );
            INSERT INTO notification_type(notification_type_name, url_template, created_at, updated_at) values('thread', '/thread/%1$%/%2$%', unix_timestamp()
            , unix_timestamp());
            INSERT INTO notification_verb(notification_verb_name, notification_type_name, text_template, text_template_two_people,
                text_template_more_than_two_people, created_at, updated_at) values ('people_comment', 'thread', '%1$% commented on your thread',
                '%1$% and %2$% commented on your thread', '%1$% and %2$% other people commented on your thread', unix_timestamp(), unix_timestamp());
            INSERT INTO notification_verb(notification_verb_name, notification_type_name, text_template, text_template_two_people,
                text_template_more_than_two_people, created_at, updated_at) values ('people_vote', 'thread', '1 person voted on your thread',
                '%1$% people voted on your thread', '%1$% people voted on your thread', unix_timestamp(), unix_timestamp());
            "
           );


    }

    public function down()
    {
        $this->execute("DROP table notification_actor;
                        DROP table notification_receiver;
                          DROP table notification;
                          DROP table notification_verb;
                          DROP table notification_type;
                          RENAME TABLE old_notification to notification;

      ");
    }

}
