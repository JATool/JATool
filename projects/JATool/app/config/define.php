<?php
// Domain real RC-HRM
define('domain_ja_tool', 'http://192.168.33.10/JATool');

/*
 * VALIDATE CONSTANT
 */
// Account login is not exist
define('ACCOUNT_NOT_EXIST', '-1');

// Login fail
define('FAIL_AUTHENTICATED', '0');

// Account login is inactive
define('ACCOUNT_INVALID', '1');

//// Login success
define('SUCCESS_AUTHENTICATED', '2');

// Max attempt numbers
define('max_attempt_numbers', '3');

// Times deny authenticate (minutes)
define('time_deny', '15');

/*
 * CACHE KEYS
 */
// Cache expire time default is 5 minutes.
define('CACHE_TIME', 5);

// Use cache flag.
define('USE_CACHE', true);

// Cache key for employee list in employee list page.
define('EMPLOYEE_LIST_DATA', 'hrm.employee.list.data');

// Cache key for employee list in employee list page.
define('EMPLOYEE_LIST_HEADER', 'hrm.employee.list.header');

// Cache key for category list in employee detail page.
define('CATE_LIST', 'hrm.employee.detail.category_list');

// Cache key for person record.
define('PERSON', 'hrm.employee.detail.person_%s');

// Cache key for all person records.
define('ALL_PERSON', 'hrm.employee.detail.all_person');

// Cache key for category content in employee detail page.
define('CATE_CONTENT', 'hrm.employee.detail.category_content_%s');