<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-05-17 04:30:36 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:25:20 --> 404 Page Not Found: /index
ERROR - 2023-05-17 02:36:13 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-17 02:36:13 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
 LIMIT 1
ERROR - 2023-05-17 02:36:48 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-17 02:36:48 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
 LIMIT 1
ERROR - 2023-05-17 02:40:36 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-17 02:40:36 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
 LIMIT 1
ERROR - 2023-05-17 06:50:14 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:50:20 --> 404 Page Not Found: /index
ERROR - 2023-05-17 02:50:32 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-17 02:50:32 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 02:50:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 06:50:33 --> 404 Page Not Found: /index
ERROR - 2023-05-17 02:50:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 02:50:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 06:50:37 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:50:41 --> 404 Page Not Found: /index
ERROR - 2023-05-17 02:51:22 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 02:51:22 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 06:51:23 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:51:29 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:51:48 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:57:43 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:58:22 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:58:39 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:58:47 --> 404 Page Not Found: /index
ERROR - 2023-05-17 02:58:49 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-17 02:58:49 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 02:58:49 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 06:58:50 --> 404 Page Not Found: /index
ERROR - 2023-05-17 06:58:53 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:00:04 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:00:13 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:00:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:00:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:00:21 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:00:25 --> Severity: Notice --> Undefined variable: search_school /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 73
ERROR - 2023-05-17 03:00:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 73
ERROR - 2023-05-17 03:00:25 --> Severity: Notice --> Undefined variable: search /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 84
ERROR - 2023-05-17 03:00:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 84
ERROR - 2023-05-17 03:00:25 --> Severity: Notice --> Undefined variable: search_email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 97
ERROR - 2023-05-17 03:00:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 97
ERROR - 2023-05-17 03:00:25 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:00:25 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:00:26 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:00:28 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:00:28 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:00:29 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:00:31 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:00:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:00:32 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:00:56 --> Severity: Notice --> Undefined index: profile_pic /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Schools.php 473
ERROR - 2023-05-17 03:00:56 --> Severity: Notice --> Undefined variable: search_school /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 73
ERROR - 2023-05-17 03:00:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 73
ERROR - 2023-05-17 03:00:56 --> Severity: Notice --> Undefined variable: search /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 84
ERROR - 2023-05-17 03:00:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 84
ERROR - 2023-05-17 03:00:56 --> Severity: Notice --> Undefined variable: search_email /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 97
ERROR - 2023-05-17 03:00:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/schools/list.php 97
ERROR - 2023-05-17 03:00:56 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:00:56 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:00:56 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:01:07 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:01:12 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:48:11 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:48:33 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:50:10 --> 404 Page Not Found: /index
ERROR - 2023-05-17 07:50:24 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:55:35 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:55:36 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:55:38 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:38 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:55:39 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:55:44 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:55:45 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:55:48 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:48 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:55:48 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:55:50 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:50 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:55:51 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:55:54 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3822
ERROR - 2023-05-17 03:55:54 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/models/App_model.php 3834
ERROR - 2023-05-17 03:55:54 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:54 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:59 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:55:59 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:56:00 --> 404 Page Not Found: /index
ERROR - 2023-05-17 03:56:58 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 03:56:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 07:56:59 --> 404 Page Not Found: /index
ERROR - 2023-05-17 05:13:02 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 05:13:02 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 09:13:03 --> 404 Page Not Found: /index
ERROR - 2023-05-17 09:13:09 --> 404 Page Not Found: /index
ERROR - 2023-05-17 09:13:28 --> 404 Page Not Found: /index
ERROR - 2023-05-17 08:05:07 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-17 08:05:07 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
 LIMIT 1
ERROR - 2023-05-17 08:05:11 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-05-17 08:05:11 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
 LIMIT 1
ERROR - 2023-05-17 18:49:55 --> 404 Page Not Found: /index
ERROR - 2023-05-17 18:50:03 --> 404 Page Not Found: /index
ERROR - 2023-05-17 14:50:05 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-17 14:50:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 14:50:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 18:50:07 --> 404 Page Not Found: /index
ERROR - 2023-05-17 14:50:10 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 14:50:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 18:50:11 --> 404 Page Not Found: /index
ERROR - 2023-05-17 18:50:14 --> 404 Page Not Found: /index
ERROR - 2023-05-17 18:51:29 --> 404 Page Not Found: /index
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 14:51:39 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 14:51:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 18:51:44 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:04:32 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:04:32 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:04:34 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:04:36 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:05:15 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:05:24 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:05:30 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:05:30 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:05:32 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:05:39 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:05:39 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:05:40 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:05:47 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:05:47 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:05:48 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:06:18 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:06:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:06:19 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:06:42 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:06:42 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:06:43 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:07:59 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:08:19 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-17 15:08:19 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:08:19 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:08:21 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:08:23 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:08:23 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:08:24 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-05-17 15:08:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:08:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:08:33 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:36:22 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:36:25 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:36:37 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-05-17 15:36:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:36:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:36:38 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:37:11 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:37:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:37:12 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:37:14 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:38:28 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:48:36 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:48:41 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:48:41 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:48:41 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:49:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:49:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:49:05 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:49:09 --> Severity: Notice --> Undefined variable: session /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/orders/assign_hours.php 52
ERROR - 2023-05-17 15:49:09 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:49:09 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:49:10 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:49:18 --> Severity: Notice --> Undefined variable: session /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/orders/assign_hours.php 52
ERROR - 2023-05-17 15:49:18 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:49:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:49:19 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:49:35 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:49:35 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:49:35 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:49:45 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:49:45 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:49:46 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:49:52 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:49:52 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:49:53 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:50:22 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:50:22 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:50:23 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:50:43 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:50:43 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:50:43 --> 404 Page Not Found: /index
ERROR - 2023-05-17 19:51:21 --> 404 Page Not Found: /index
ERROR - 2023-05-17 15:54:44 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 15:54:44 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-05-17 19:54:45 --> 404 Page Not Found: /index
