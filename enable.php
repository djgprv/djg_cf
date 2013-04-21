<?php
$settings = array(
    'emailAdress' => 'admin_mail@localhost.com',
	'subjectPrefix' => 'Message frow www, topic: ',
	'appendCssE'   => '1',
    'subject' => '1',
	'captcha'  => '1',
	'subjects' => 'subject 1#subject 2#other subject'
);
// Insert the new ones
if (Plugin::setAllSettings($settings, 'djg_cf'))
    Flash::setNow('success', __('djg_cf - plugin settings initialized.'));
else
    Flash::setNow('error', __('djg_cf - unable to store plugin settings!'));	