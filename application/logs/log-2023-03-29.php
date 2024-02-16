<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-03-29 02:56:51 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-29 02:56:51 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-29 02:59:24 --> Severity: Warning --> mysqli::query(): (21000/1242): Subquery returns more than 1 row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2023-03-29 02:59:24 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT `order_schedules`.*, `orders`.`order_no`, `orders`.`school_id`, `grades`.`name` AS `grade_name`, `worktypes`.`name` AS `worktype_name`, `title_topics`.`topic` AS `topic_name`, `order_schedule_status_log`.`attachment`, `log`.`attachment` AS `log_attachment`, `order_schedule_status_log`.`content`, `user_meta`.`meta_value` AS `school_name`, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND new_status="Log sent - awaiting principal signature" AND old_status="Create log") AS create_log_content, (SELECT content FROM order_schedule_status_log WHERE order_schedules.id = order_schedule_status_log.order_schedule_id AND old_status="Log sent - awaiting principal signature" AND new_status="Awaiting Review") AS log_signature, `users`.`first_name`, `users`.`last_name`
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
ERROR - 2023-03-29 07:17:57 --> 404 Page Not Found: /index
ERROR - 2023-03-29 03:18:18 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-29 03:18:18 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:18:18 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 07:18:19 --> 404 Page Not Found: /index
ERROR - 2023-03-29 03:18:21 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:18:21 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 07:18:22 --> 404 Page Not Found: /index
ERROR - 2023-03-29 03:18:26 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:18:26 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:18:29 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:18:29 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 07:18:30 --> 404 Page Not Found: /index
ERROR - 2023-03-29 07:18:34 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 07:18:34 --> 404 Page Not Found: /index
ERROR - 2023-03-29 07:18:38 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 07:18:46 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 07:18:51 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 07:18:56 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 07:19:24 --> 404 Page Not Found: /index
ERROR - 2023-03-29 03:19:37 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-29 03:19:37 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:19:37 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 07:19:38 --> 404 Page Not Found: /index
ERROR - 2023-03-29 03:19:40 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:19:40 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 07:19:42 --> 404 Page Not Found: /index
ERROR - 2023-03-29 03:21:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:21:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 03:21:10 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 03:21:10 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 07:21:11 --> 404 Page Not Found: /index
ERROR - 2023-03-29 07:21:16 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 07:21:19 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 07:21:26 --> 404 Page Not Found: ../modules/App/controllers//index
ERROR - 2023-03-29 08:19:05 --> 404 Page Not Found: /index
ERROR - 2023-03-29 08:19:07 --> 404 Page Not Found: /index
ERROR - 2023-03-29 04:19:17 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-29 04:19:17 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 04:19:17 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:19:17 --> 404 Page Not Found: /index
ERROR - 2023-03-29 04:19:20 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 04:19:20 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:19:20 --> 404 Page Not Found: /index
ERROR - 2023-03-29 04:19:31 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 04:19:31 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 913
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: row /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/presenter_billing.php 920
ERROR - 2023-03-29 04:19:33 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 04:19:33 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:19:34 --> 404 Page Not Found: /index
ERROR - 2023-03-29 08:20:10 --> 404 Page Not Found: /index
ERROR - 2023-03-29 10:35:24 --> 404 Page Not Found: /index
ERROR - 2023-03-29 10:35:25 --> 404 Page Not Found: /index
ERROR - 2023-03-29 10:35:34 --> 404 Page Not Found: /index
ERROR - 2023-03-29 12:50:20 --> 404 Page Not Found: /index
ERROR - 2023-03-29 08:50:58 --> Severity: Notice --> Undefined variable: total_new_schedule_hour /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/Auth/views/dashboard.php 775
ERROR - 2023-03-29 08:50:58 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:50:58 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:03 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:03 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:05 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:05 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:08 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:08 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:11 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:11 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: data /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1836
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1836
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-29 08:51:16 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: data /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1836
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Presenters.php 1836
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 95
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 103
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 106
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 109
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 112
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: order /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 115
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 118
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 142
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 147
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 148
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 162
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Undefined variable: schedule /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-29 08:51:47 --> Severity: Notice --> Trying to get property of non-object /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/views/presenters/create_log.php 163
ERROR - 2023-03-29 08:51:56 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Orders.php 1963
ERROR - 2023-03-29 08:51:56 --> Severity: Notice --> Undefined offset: 2 /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/modules/App/controllers/Orders.php 1971
ERROR - 2023-03-29 08:51:57 --> Severity: Notice --> Undefined variable: teacher_grades /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
ERROR - 2023-03-29 08:51:57 --> Severity: Warning --> Invalid argument supplied for foreach() /home/wyktsmhg/public_html/baasolutionsonline.east-coast-developer.pro/application/views/templates/school/template.php 177
