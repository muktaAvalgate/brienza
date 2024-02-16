<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-05-08 01:37:52 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:37:52 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:38:05 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:38:05 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:40:36 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:40:36 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:40:40 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:40:40 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:41:07 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:41:07 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:44:05 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:44:05 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:45:02 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:45:02 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:49:49 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:49:49 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:49:54 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:49:54 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:49:57 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:49:57 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:50:14 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:50:14 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:50:18 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:50:18 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:52:11 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:52:11 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:54:52 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:54:52 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:55:03 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:55:03 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:55:16 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:55:16 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:56:16 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:56:16 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:57:03 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:57:03 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:58:38 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:58:38 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:59:09 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:59:09 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 01:59:30 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 01:59:30 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:01:21 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:01:21 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:01:56 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:01:56 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:03:10 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:03:10 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:03:31 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:03:31 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:03:37 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:03:37 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:04:46 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:04:46 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:08:06 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:08:06 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:08:51 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:08:51 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:10:33 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:10:33 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:10:39 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:10:39 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:10:45 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:10:45 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:10:50 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:10:50 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:11:44 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:11:44 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:12:03 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:12:03 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:12:16 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:12:16 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:13:48 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:13:48 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:13:53 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:13:53 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:17:49 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:17:49 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:17:59 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:17:59 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:20:57 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:20:57 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:35:37 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:35:37 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:35:47 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:35:47 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:36:22 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:36:22 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 06:38:42 --> 404 Page Not Found: /index
ERROR - 2023-05-08 02:39:14 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-08 02:39:14 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:18 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:27 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:34 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:36 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:38 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:38 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:39:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:40:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:40:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:01 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:46 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:48 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:53 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:57 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:59 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:41:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:02 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:15 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:34 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:39 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:45 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:42:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 02:45:07 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:45:07 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 02:58:07 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 02:58:07 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:05:17 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:24 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:24 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:27 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:52 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:05:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:06:01 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:06:03 --> 404 Page Not Found: /index
ERROR - 2023-05-08 03:06:11 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:06:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:06:12 --> 404 Page Not Found: /index
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:06:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:06:21 --> 404 Page Not Found: /index
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined index: email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/list.php 98
ERROR - 2023-05-08 03:06:25 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:06:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:06:25 --> 404 Page Not Found: /index
ERROR - 2023-05-08 03:06:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:06:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:06:29 --> 404 Page Not Found: /index
ERROR - 2023-05-08 03:08:49 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:08:49 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:24:45 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:24:45 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:25:12 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:25:12 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:26:27 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:26:27 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:27:39 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:27:39 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:27:51 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:27:51 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:27:55 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:27:55 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:27:56 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:27:56 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:28:01 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:28:01 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:28:03 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:20 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:28:20 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:28:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:40 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:43 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:28:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:29:00 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:29:00 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1169
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:35:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:35:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:36:01 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:36:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:36:06 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:36:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:37:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:37:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 03:38:14 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:38:14 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1177
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 03:40:34 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 03:40:34 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 1568
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 07:45:38 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:16:06 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:16:11 --> 404 Page Not Found: /index
ERROR - 2023-05-08 04:34:09 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 04:34:09 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2313
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 04:34:30 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 04:34:30 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2313
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 04:35:26 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-08 04:35:26 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2313
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-05-08 09:32:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:32:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:50:02 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:52:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:52:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:52:17 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:52:21 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:52:21 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:52:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:52:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:52:39 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:52:43 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:52:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:52:45 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:52:51 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-08 05:52:51 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:52:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:52:52 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:52:53 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:52:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:52:54 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:52:56 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:52:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:52:57 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-08 05:53:02 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:53:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:53:03 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:53:06 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:53:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:53:06 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:53:11 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:53:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:53:11 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:53:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:53:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:53:24 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:53:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:53:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:53:26 --> 404 Page Not Found: /index
ERROR - 2023-05-08 05:53:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 05:53:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:53:50 --> 404 Page Not Found: /index
ERROR - 2023-05-08 11:49:46 --> 404 Page Not Found: /index
ERROR - 2023-05-08 11:49:49 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:49:57 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:49:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:49:58 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:05 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:09 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:09 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:17 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:17 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:19 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:19 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:24 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:24 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:24 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:29 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:34 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:34 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:42 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:42 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:46 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:46 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:50:56 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:50:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:50:56 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:51:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:51:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:51:07 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:52:12 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:52:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:52:12 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:52:28 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:52:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:52:29 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:52:32 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:52:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:52:32 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:52:35 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:52:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:52:35 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:52:40 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:52:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:52:40 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:52:56 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:52:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:52:56 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:53:19 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:53:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:53:19 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:53:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:53:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:53:30 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:58:35 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:58:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:58:36 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:58:39 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:58:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:58:42 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:58:44 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:58:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:58:44 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:58:51 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:58:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:58:51 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:58:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:58:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:58:55 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:58:57 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:58:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:58:57 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:58:59 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:58:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:58:59 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:59:02 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:59:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:59:03 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:59:13 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:59:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:59:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:59:24 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:59:24 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:59:24 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:59:27 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:59:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:59:28 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:59:36 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:59:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:59:36 --> 404 Page Not Found: /index
ERROR - 2023-05-08 07:59:45 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 07:59:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 11:59:45 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:00:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:00:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:00:08 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:00:09 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:00:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:00:09 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:00:12 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:00:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:00:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:00:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:00:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:00:21 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:00:47 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:00:47 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:00:47 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:00:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:00:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:00:54 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:01:02 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:01:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:01:02 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:01:13 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:01:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:01:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:01:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:01:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:01:16 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:01:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:01:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:01:20 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:01:27 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:01:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:01:28 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:01:31 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:01:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:01:31 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:01:33 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:01:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:01:36 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:02:11 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:02:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:02:12 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:02:17 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:02:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:02:18 --> 404 Page Not Found: /index
ERROR - 2023-05-08 12:03:12 --> 404 Page Not Found: /index
ERROR - 2023-05-08 12:03:12 --> 404 Page Not Found: /index
ERROR - 2023-05-08 12:09:47 --> 404 Page Not Found: /index
ERROR - 2023-05-08 12:09:51 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:19:03 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:19:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:19:04 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:19:45 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:19:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:19:46 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:19:58 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:19:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:19:59 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:08 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:19 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:20 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:25 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:25 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:30 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:33 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:33 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:37 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:44 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:45 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:48 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:48 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:20:57 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:20:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:20:58 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:21:06 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:21:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:21:06 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:25:22 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:25:22 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:25:23 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:25:28 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:25:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:25:29 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:25:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:25:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:25:38 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:25:42 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:25:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:25:42 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:25:48 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:25:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:25:49 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:25:51 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:25:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:25:51 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:25:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:25:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:25:55 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:26:09 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:26:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:26:10 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:26:12 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:26:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:26:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:26:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:26:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:26:16 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:26:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:26:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:26:54 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:26:59 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:26:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:26:59 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:04 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:08 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:10 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:10 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:13 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:14 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:18 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:18 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:25 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:25 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:31 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:38 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:49 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:27:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:27:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:27:55 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:28:00 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:28:00 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:28:01 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:28:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:28:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:28:05 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:28:09 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:28:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:28:09 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:28:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:28:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:28:37 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:29:01 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:29:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:29:01 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:29:39 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:29:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:29:40 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:29:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:29:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:29:55 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:30:11 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:30:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:30:11 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:30:31 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:30:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:30:32 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:30:46 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:30:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:30:47 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:30:53 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:30:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:30:53 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:10 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:10 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:16 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:26 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:32 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:32 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:42 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:46 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:47 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:50 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:31:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:31:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:31:55 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:32:14 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:32:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:32:14 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:32:21 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:32:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:32:21 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:45:12 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:45:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:45:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:45:18 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:45:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:45:19 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:45:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:45:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:45:30 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:45:34 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:45:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:45:34 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:45:39 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:45:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:45:40 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:46:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:46:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:46:05 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:46:59 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:46:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:46:59 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:47:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:47:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:47:41 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:47:46 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:47:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:47:47 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:47:52 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:47:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:47:52 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:47:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:47:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:47:55 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:47:59 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:47:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:47:59 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:48:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:48:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:48:08 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:52:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:52:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:52:26 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:52:28 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:52:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:52:29 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:52:47 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:52:47 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:52:47 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:52:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:52:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:52:51 --> 404 Page Not Found: /index
ERROR - 2023-05-08 12:52:52 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:52:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:52:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:52:55 --> 404 Page Not Found: /index
ERROR - 2023-05-08 12:52:56 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:52:58 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:52:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:52:58 --> 404 Page Not Found: /index
ERROR - 2023-05-08 08:53:01 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 08:53:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 12:53:02 --> 404 Page Not Found: /index
ERROR - 2023-05-08 12:53:03 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:06:58 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:06:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:06:58 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:07:19 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:07:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:07:19 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:07:32 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:07:35 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:08:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:08:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:08:06 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:08 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:08:13 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:08:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:08:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:08:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:08:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:08:21 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:08:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:08:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:08:23 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:08:25 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:08:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:08:26 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:28 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:31 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:34 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:35 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:36 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:37 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:39 --> 404 Page Not Found: /index
ERROR - 2023-05-08 09:08:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 09:08:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 13:08:41 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:44 --> 404 Page Not Found: /index
ERROR - 2023-05-08 13:08:46 --> 404 Page Not Found: /index
ERROR - 2023-05-08 16:24:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:24:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:24:31 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:24:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 20:24:32 --> 404 Page Not Found: /index
ERROR - 2023-05-08 20:24:36 --> 404 Page Not Found: /index
ERROR - 2023-05-08 20:24:40 --> 404 Page Not Found: /index
ERROR - 2023-05-08 16:24:45 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-08 16:24:45 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:24:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 20:24:46 --> 404 Page Not Found: /index
ERROR - 2023-05-08 16:24:48 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:24:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 20:24:48 --> 404 Page Not Found: /index
ERROR - 2023-05-08 20:24:50 --> 404 Page Not Found: /index
ERROR - 2023-05-08 20:25:38 --> 404 Page Not Found: /index
ERROR - 2023-05-08 20:28:38 --> 404 Page Not Found: /index
ERROR - 2023-05-08 20:28:42 --> 404 Page Not Found: /index
ERROR - 2023-05-08 16:28:47 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:28:47 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 20:28:48 --> 404 Page Not Found: /index
ERROR - 2023-05-08 16:29:01 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:29:01 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 20:29:02 --> 404 Page Not Found: /index
ERROR - 2023-05-08 16:29:12 --> Severity: Notice --> Undefined variable: session /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/orders/assign_hours.php 52
ERROR - 2023-05-08 16:29:12 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:29:12 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 20:29:13 --> 404 Page Not Found: /index
ERROR - 2023-05-08 16:29:17 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 16:29:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-08 20:29:18 --> 404 Page Not Found: /index
