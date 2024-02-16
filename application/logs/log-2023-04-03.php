<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-04-03 02:11:58 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:11:58 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:13:09 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:13:09 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:16:53 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:16:53 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:16:58 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:16:58 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:17:33 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:17:33 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:17:37 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:17:37 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:17:42 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:17:42 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:18:11 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:18:11 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:18:39 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:18:39 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:18:49 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:18:49 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:19:35 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:19:35 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:21:53 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:21:53 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 02:22:07 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 02:22:07 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:04:50 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:04:50 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:05:07 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:05:07 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:06:51 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:06:51 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:07:02 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:07:02 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:12:18 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:12:18 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:12:46 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:12:46 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:13:20 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:13:20 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:13:40 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:13:40 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:13:55 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:13:55 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:14:21 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:14:21 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:16:41 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:16:41 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:16:54 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:16:54 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:17:24 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:17:24 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:17:28 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:17:28 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:17:37 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:17:37 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 03:37:11 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 03:37:11 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 10:37:07 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:37:15 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:37:31 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-04-03 06:37:31 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:37:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:37:31 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:37:34 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:37:34 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:37:34 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:37:36 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:37:54 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:38:31 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:38:33 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:38:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:38:34 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:38:40 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:38:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:38:40 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:39:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:39:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:39:31 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:39:36 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:39:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:39:36 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:39:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:39:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:39:50 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:39:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:39:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:39:55 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:40:15 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:40:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:40:16 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:40:40 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:40:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:40:41 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:40:42 --> Severity: Notice --> Undefined variable: session /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/orders/assign_hours.php 52
ERROR - 2023-04-03 06:40:42 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:40:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:40:43 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:40:52 --> Severity: Notice --> Undefined variable: res /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3529
ERROR - 2023-04-03 06:41:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:41:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:41:26 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:41:27 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:42:03 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:42:03 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:42:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:42:06 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:42:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:42:09 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:42:13 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:42:14 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:42:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:42:17 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:42:49 --> Severity: Notice --> Undefined index: profile_pic /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Schools.php 379
ERROR - 2023-04-03 06:42:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:42:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:42:50 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:42:52 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:44:21 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:44:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:44:22 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:44:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:44:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:44:51 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:46:17 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:46:17 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 10:47:05 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:47:16 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:47:26 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:47:26 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 10:47:31 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:48:47 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:48:47 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:48:59 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:48:59 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:49:22 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:49:22 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 10:49:23 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:50:24 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:50:24 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 10:51:19 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:51:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:51:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:51:26 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:51:28 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:51:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:51:29 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:52:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:52:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:52:06 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:52:24 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:52:24 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:52:25 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:52:36 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:52:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:52:36 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:52:40 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:52:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:52:41 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:52:42 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:52:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:52:43 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:52:51 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:52:51 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:52:52 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:52:56 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:52:56 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:53:42 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:53:42 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:53:46 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:53:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:53:47 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:53:48 --> 404 Page Not Found: /index
ERROR - 2023-04-03 10:54:05 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:54:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:54:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:54:08 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:54:14 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:54:14 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:54:15 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:54:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 06:54:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 10:54:23 --> 404 Page Not Found: /index
ERROR - 2023-04-03 06:55:37 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:55:37 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:58:01 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:58:01 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:58:12 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:58:12 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:58:36 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:58:36 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 06:59:53 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 06:59:53 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 07:00:56 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-03 07:00:56 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-03 07:55:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 07:55:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 11:55:24 --> 404 Page Not Found: /index
ERROR - 2023-04-03 07:55:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 07:55:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 11:55:26 --> 404 Page Not Found: /index
ERROR - 2023-04-03 07:55:37 --> Severity: Notice --> Undefined index: profile_pic /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Schools.php 379
ERROR - 2023-04-03 07:55:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 07:55:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 11:55:38 --> 404 Page Not Found: /index
ERROR - 2023-04-03 07:56:00 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 07:56:00 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 11:56:01 --> 404 Page Not Found: /index
ERROR - 2023-04-03 07:58:17 --> Severity: Notice --> Undefined index: profile_pic /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Schools.php 379
ERROR - 2023-04-03 07:58:17 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 07:58:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 11:58:18 --> 404 Page Not Found: /index
ERROR - 2023-04-03 13:24:39 --> 404 Page Not Found: /index
ERROR - 2023-04-03 13:24:41 --> 404 Page Not Found: /index
ERROR - 2023-04-03 09:25:04 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-04-03 09:25:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 09:25:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 13:25:04 --> 404 Page Not Found: /index
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 09:25:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 13:25:09 --> 404 Page Not Found: /index
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-04-03 09:25:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 09:25:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-04-03 13:25:30 --> 404 Page Not Found: /index
