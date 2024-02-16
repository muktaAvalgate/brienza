<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-03-09 00:03:28 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 00:03:28 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 00:11:26 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 00:11:26 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 06:07:48 --> 404 Page Not Found: /index
ERROR - 2023-03-09 06:07:53 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:08:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:08:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:08:05 --> 404 Page Not Found: /index
ERROR - 2023-03-09 06:08:08 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:08:11 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 01:08:11 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:08:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:08:12 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:08:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:08:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:08:23 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:10:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:10:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:10:08 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:10:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:10:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:10:41 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:10:53 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:10:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:10:54 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:11:29 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 01:11:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:11:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:11:30 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:11:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:11:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:11:31 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:11:33 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:11:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:11:34 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:11:50 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 01:11:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:11:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:11:50 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:11:53 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:11:53 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:11:53 --> 404 Page Not Found: /index
ERROR - 2023-03-09 06:11:59 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:12:06 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:12:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:12:07 --> 404 Page Not Found: /index
ERROR - 2023-03-09 06:12:09 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:19:50 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:19:50 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 01:20:43 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:20:43 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 01:25:18 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:25:18 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 01:25:56 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:25:56 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 01:26:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:26:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:26:42 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:26:43 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:26:43 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 01:30:21 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:30:21 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 06:30:34 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:31:44 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:31:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:31:45 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:31:49 --> Severity: Notice --> Undefined index: profile_pic /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Admin/controllers/Users.php 308
ERROR - 2023-03-09 01:31:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:31:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:31:50 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:32:22 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:32:22 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 01:32:35 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:32:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:32:36 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:32:43 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:32:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:32:43 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:32:48 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:32:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:32:48 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:32:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:32:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:32:50 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:32:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:32:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:32:56 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:33:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:33:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:33:17 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:33:22 --> Severity: Notice --> Undefined index: profile_pic /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Admin/controllers/Users.php 308
ERROR - 2023-03-09 01:33:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:33:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:33:23 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:33:27 --> Severity: Notice --> Undefined index: profile_pic /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Admin/controllers/Users.php 308
ERROR - 2023-03-09 01:33:27 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:33:27 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:33:27 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:33:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:33:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:33:37 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:36:04 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 01:36:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:36:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:36:04 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:36:08 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 01:36:08 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 01:36:17 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:36:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:36:18 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:36:22 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 01:36:22 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 06:36:26 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:36:32 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:36:32 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2381
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 01:36:36 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:36:36 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2381
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 01:37:21 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 01:37:21 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 06:37:39 --> 404 Page Not Found: /index
ERROR - 2023-03-09 06:37:58 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:38:13 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:38:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:38:14 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:38:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:38:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:38:17 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:38:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:38:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:38:24 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:38:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:38:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:38:27 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:38:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:38:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:38:49 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:39:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 01:39:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 06:39:06 --> 404 Page Not Found: /index
ERROR - 2023-03-09 01:40:13 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 01:40:13 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 01:41:33 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 01:41:33 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 01:45:44 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:45:44 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:45:57 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:45:57 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:46:12 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:46:12 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:51:22 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:51:22 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:51:35 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:51:35 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:51:40 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:51:40 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:54:07 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:54:07 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:54:34 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:54:34 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:55:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:55:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:56:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:56:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:56:35 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:56:35 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:57:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 01:57:02 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 01:57:51 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 01:57:51 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 01:59:11 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 01:59:11 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 01:59:20 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 01:59:20 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 02:00:07 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 02:00:07 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 02:03:09 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:03:09 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:03:55 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 02:03:55 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 02:04:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:04:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:05:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:05:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:06:31 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 02:06:31 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 02:06:53 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:06:53 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:09:28 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 02:09:28 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 02:16:04 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 02:16:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 02:16:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:16:05 --> 404 Page Not Found: /index
ERROR - 2023-03-09 02:16:06 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 02:16:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:16:07 --> 404 Page Not Found: /index
ERROR - 2023-03-09 02:21:40 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:21:40 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:22:06 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 02:22:06 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 02:24:08 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 02:24:08 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 02:24:20 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:24:20 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:25:18 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:25:18 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:26:21 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 02:26:21 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 02:30:57 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 02:30:57 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 02:38:59 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 02:38:59 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 03:01:59 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 03:01:59 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 03:05:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:05:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:05:42 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:05:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:05:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:05:50 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:05:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:05:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:05:55 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:06:00 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 03:06:00 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:06:00 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:06:01 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:06:03 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:06:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:06:04 --> 404 Page Not Found: /index
ERROR - 2023-03-09 08:06:06 --> 404 Page Not Found: /index
ERROR - 2023-03-09 08:06:42 --> 404 Page Not Found: /index
ERROR - 2023-03-09 08:07:02 --> 404 Page Not Found: /index
ERROR - 2023-03-09 08:07:24 --> 404 Page Not Found: /index
ERROR - 2023-03-09 08:07:58 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:09:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:09:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:09:04 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:09:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:09:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:09:24 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:09:36 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 03:09:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:09:36 --> 404 Page Not Found: /index
ERROR - 2023-03-09 03:16:53 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 03:16:53 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2381
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 03:19:59 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3806
ERROR - 2023-03-09 03:19:59 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3818
ERROR - 2023-03-09 03:27:47 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 03:27:47 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 03:31:36 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1955
ERROR - 2023-03-09 03:31:36 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1964
ERROR - 2023-03-09 03:38:21 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1955
ERROR - 2023-03-09 03:38:21 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1964
ERROR - 2023-03-09 04:12:43 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 04:12:43 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 04:14:22 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 04:14:22 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 04:15:36 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 04:15:36 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 04:46:07 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 04:46:07 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 04:46:49 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 04:46:49 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2384
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 04:47:45 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 04:47:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 09:47:45 --> 404 Page Not Found: /index
ERROR - 2023-03-09 04:47:52 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 04:47:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 09:47:53 --> 404 Page Not Found: /index
ERROR - 2023-03-09 04:47:57 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 04:47:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 09:47:58 --> 404 Page Not Found: /index
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 04:48:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: data /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1817
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1817
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-09 04:48:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-09 09:48:06 --> 404 Page Not Found: /index
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: data /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1817
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1817
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-09 04:48:17 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-09 04:48:36 --> Severity: Notice --> Undefined offset: 199 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Orders.php 2021
ERROR - 2023-03-09 04:48:36 --> Severity: Notice --> Undefined offset: 199 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Orders.php 2032
ERROR - 2023-03-09 04:48:36 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 04:48:36 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 09:48:37 --> 404 Page Not Found: /index
ERROR - 2023-03-09 04:53:03 --> Severity: Notice --> Undefined offset: 3 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 04:53:03 --> Severity: Notice --> Undefined offset: 3 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 04:57:37 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 04:57:37 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 04:59:38 --> Severity: Notice --> Undefined offset: 3 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 04:59:38 --> Severity: Notice --> Undefined offset: 3 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 05:01:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:01:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:01:55 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:02:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:02:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:02:21 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:02:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:02:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:02:30 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:02:36 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:02:40 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:02:47 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 05:02:47 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:02:47 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:02:48 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:02:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:02:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:02:49 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:02:56 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:02:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:02:57 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:02:58 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:02:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:02:58 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:03:00 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:03:18 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:03:35 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:03:52 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:03:55 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:03:55 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:03:56 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:04:16 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:04:16 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:04:17 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:04:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:04:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:04:37 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:04:52 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:05:07 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 05:05:07 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 05:07:35 --> Severity: Notice --> Undefined offset: 3 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1955
ERROR - 2023-03-09 05:07:35 --> Severity: Notice --> Undefined offset: 3 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1964
ERROR - 2023-03-09 05:19:27 --> Severity: Notice --> Undefined offset: 4 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 05:27:19 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:27:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:27:19 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:35:40 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:35:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:35:41 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:35:48 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:36:02 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 05:36:02 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:36:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:36:03 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:36:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:36:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:36:05 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:36:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:36:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:36:09 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:36:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:36:09 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:36:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 05:36:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 10:36:51 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:42:31 --> Severity: Notice --> Undefined offset: 4 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1415
ERROR - 2023-03-09 10:42:38 --> 404 Page Not Found: /index
ERROR - 2023-03-09 10:43:18 --> 404 Page Not Found: /index
ERROR - 2023-03-09 05:46:25 --> Severity: Notice --> Undefined offset: 4 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1415
ERROR - 2023-03-09 11:11:36 --> 404 Page Not Found: /index
ERROR - 2023-03-09 06:13:48 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 06:13:48 --> Severity: Notice --> Undefined offset: 1 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
ERROR - 2023-03-09 06:27:42 --> Severity: Notice --> Undefined offset: 4 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1955
ERROR - 2023-03-09 06:27:42 --> Severity: Notice --> Undefined offset: 4 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1964
ERROR - 2023-03-09 07:10:35 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 07:10:35 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 12:24:50 --> 404 Page Not Found: /index
ERROR - 2023-03-09 07:24:58 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-09 07:24:58 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:24:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:02 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:04 --> Severity: Notice --> Undefined variable: topic_name /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:04 --> Severity: Notice --> Undefined variable: topic_name /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:04 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:04 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:04 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:06 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:07 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:07 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:09 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:10 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:13 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:13 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:15 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:15 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:18 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:20 --> Severity: Notice --> Undefined variable: topic_name /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:20 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:20 --> Severity: Notice --> Undefined variable: topic_name /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:20 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/custom_template_edit.php 42
ERROR - 2023-03-09 07:25:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:22 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:25:22 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:44:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 07:44:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-09 08:23:45 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1955
ERROR - 2023-03-09 08:23:45 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1964
ERROR - 2023-03-09 08:24:14 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 08:24:14 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 08:26:22 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 08:26:22 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
FROM `order_schedules`
LEFT JOIN `title_topics` ON `order_schedules`.`topic_id` = `title_topics`.`id`
LEFT JOIN `grades` ON `order_schedules`.`grade_id` = `grades`.`id`
LEFT JOIN `worktypes` ON `order_schedules`.`type_id` = `worktypes`.`id`
LEFT JOIN `orders` ON `order_schedules`.`order_id` = `orders`.`id`
LEFT JOIN `order_schedule_status_log` ON `order_schedules`.`id` = `order_schedule_status_log`.`order_schedule_id` AND `order_schedule_status_log`.`new_status` = `order_schedules`.`status`
LEFT JOIN `order_schedule_status_log` AS `log` ON `order_schedules`.`id` = `log`.`order_schedule_id` AND `log`.`old_status` = 'Log sent - awaiting principal signature'
LEFT OUTER JOIN `user_meta` ON `user_meta`.`user_id` = `orders`.`school_id` AND `user_meta`.`meta_key` = 'school_name'
LEFT OUTER JOIN `users` ON `users`.`id` = `order_schedules`.`created_by`
WHERE `order_schedules`.`id` = 2361
ORDER BY `order_schedules`.`start_date` ASC
ERROR - 2023-03-09 08:29:18 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 08:29:18 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 19:50:08 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-09 19:50:08 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-09 23:59:42 --> Severity: Notice --> Undefined offset: 4 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1402
ERROR - 2023-03-09 23:59:42 --> Severity: Notice --> Undefined offset: 4 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Api/controllers/Orders.php 1410
