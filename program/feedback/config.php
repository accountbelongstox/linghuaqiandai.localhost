<?php return array (
  'program' => 
  array (
    'language' => 'chinese_simplified',
    'cache_time' => 5,
    'template_1' => 'default',
    'template_0' => 'default',
    'imageMark' => false,
    'state' => 'opening',
  ),
  'class_name' => 'feedback',
  'version' => '3.0',
  'compatible_template_version' => '3.0',
  'author' => 'cloud',
  'author_url' => 'http://www.ddweb.com.cn',
  'feedback_max_times' => 10,
  'alert' => 
  array (
    'admin_phone_msg' => false,
    'admin_email_msg' => true,
    'admin_phone_account' => '',
    'admin_email_account' => '2620631@qq.com',
    'phone_msg' => false,
    'email_msg' => false,
  ),
  'program_unlogin_function_power' => 
  array (
    0 => 'feedback.add',
    1 => 'feedback.list',
  ),
  'dashboard_module' => 
  array (
    0 => 'feedback.sum',
  ),
)?>