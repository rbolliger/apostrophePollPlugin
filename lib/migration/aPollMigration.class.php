<?php

/*
 * This file is part of the apostrophePollPlugin package.
 * (c) 2012 Raffaele Bolliger <raffaele.bolliger@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of aPollMigration
 *
 * @author Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
class aPollMigration {

    public static function migrate($event) {
        $migrate = $event->getSubject();


        if (!$migrate->tableExists('a_poll_answer')) {
            $migrate->sql(array('CREATE TABLE a_poll_answer (id BIGINT AUTO_INCREMENT, poll_id BIGINT NOT NULL, remote_address VARCHAR(255), culture VARCHAR(8), is_new TINYINT(1), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX poll_id_idx (poll_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;'));
        }

        if (!$migrate->tableExists('a_poll_answer_field')) {
            $migrate->sql(array('CREATE TABLE a_poll_answer_field (id BIGINT AUTO_INCREMENT, answer_id BIGINT NOT NULL, poll_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, value LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX poll_id_idx (poll_id), INDEX answer_id_idx (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;'));
        }

        if (!$migrate->tableExists('a_poll_poll')) {
            $migrate->sql(array('CREATE TABLE a_poll_poll (id BIGINT AUTO_INCREMENT, submissions_allow_multiple TINYINT(1), submissions_delay TIME, type VARCHAR(255) NOT NULL, published_from DATETIME, published_to DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;'));
        }

        if (!$migrate->tableExists('a_poll_poll_translation')) {
            $migrate->sql(array('CREATE TABLE a_poll_poll_translation (id BIGINT, title VARCHAR(255) NOT NULL, description LONGTEXT, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;'));
        }

        if (!$migrate->constraintExists('a_poll_answer','a_poll_answer_poll_id_a_poll_poll_id')) {
            $migrate->sql(array('ALTER TABLE a_poll_answer ADD CONSTRAINT a_poll_answer_poll_id_a_poll_poll_id FOREIGN KEY (poll_id) REFERENCES a_poll_poll(id) ON DELETE CASCADE;'));
        }
        
        if (!$migrate->constraintExists('a_poll_answer_field','a_poll_answer_field_poll_id_a_poll_poll_id')) {
            $migrate->sql(array('ALTER TABLE a_poll_answer_field ADD CONSTRAINT a_poll_answer_field_poll_id_a_poll_poll_id FOREIGN KEY (poll_id) REFERENCES a_poll_poll(id) ON DELETE CASCADE;'));
        }
        
        if (!$migrate->constraintExists('a_poll_answer_field','a_poll_answer_field_answer_id_a_poll_answer_id')) {
            $migrate->sql(array('ALTER TABLE a_poll_answer_field ADD CONSTRAINT a_poll_answer_field_answer_id_a_poll_answer_id FOREIGN KEY (answer_id) REFERENCES a_poll_answer(id) ON DELETE CASCADE;'));
        }
        
        if (!$migrate->constraintExists('a_poll_poll_translation','a_poll_poll_translation_id_a_poll_poll_id')) {
            $migrate->sql(array('ALTER TABLE a_poll_poll_translation ADD CONSTRAINT a_poll_poll_translation_id_a_poll_poll_id FOREIGN KEY (id) REFERENCES a_poll_poll(id) ON UPDATE CASCADE ON DELETE CASCADE;'));
        }


        if (!$migrate->columnExists('a_slot', 'poll_id')) {
            $migrate->sql(array('ALTER TABLE a_slot ADD COLUMN poll_id BIGINT'));
        }
    }

}


//$this->addColumn('a_slot', 'poll_id', 'integer', '8', array(
//            'notnull' => '0',
//        ));
//
//$this->removeIndex('a_slot', 'a_slot_type', array(
//             'fields' => 
//             array(
//              0 => 'type',
//             ),
//             ));



//ALTER TABLE a_slot ADD CONSTRAINT a_slot_poll_id_a_poll_poll_id FOREIGN KEY (poll_id) REFERENCES a_poll_poll(id) ON DELETE CASCADE;
//
//
//CREATE TABLE a_slot (id BIGINT AUTO_INCREMENT, type VARCHAR(100), variant VARCHAR(100), value LONGTEXT, poll_id BIGINT, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
//CREATE TABLE a_slot (id BIGINT AUTO_INCREMENT, type VARCHAR(100), variant VARCHAR(100), value LONGTEXT, poll_id BIGINT, INDEX a_slot_type_idx (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
