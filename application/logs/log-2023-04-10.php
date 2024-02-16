<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-04-10 06:19:31 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 06:19:31 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 06:24:38 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 06:24:38 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 07:20:21 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 07:20:21 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 07:20:24 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 07:20:24 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 07:21:06 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 07:21:06 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 07:25:48 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 07:25:48 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 07:26:51 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 07:26:51 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 07:27:12 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 07:27:12 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 08:15:03 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 08:15:03 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 08:16:11 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 08:16:11 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 08:20:47 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:20:47 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 08:21:06 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:21:06 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 08:21:39 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:21:39 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 08:22:44 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:22:44 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 08:24:22 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:24:22 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 08:34:34 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:34:34 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 08:35:37 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:35:37 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 08:43:33 --> Could not find the language line "auth_recover_password_form_password_label"
ERROR - 2023-04-10 08:43:33 --> Could not find the language line "auth_recover_password_form_confirm_password_label"
ERROR - 2023-04-10 12:46:03 --> 404 Page Not Found: /index
ERROR - 2023-04-10 08:46:57 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 08:46:57 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 08:47:02 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 08:47:02 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 08:47:30 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 08:47:30 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-04-10 08:59:23 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-04-10 08:59:23 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
