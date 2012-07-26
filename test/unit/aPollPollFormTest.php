    <?php

include(dirname(__FILE__) . '/../bootstrap/unit.php');


$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
sfContext::createInstance($configuration);

$pi = array(
    'contact' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm'),
    'cip' => array('name' => 'sdf'),
    'ciop' => array('form' => 'sdfgsdfg'),
    'ciap' => array('form' => 'testForm'),
    'view_template' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'view_template' => 'aPollSlot/sdgdfg'),
    'view_template_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'view_template' => 'aPollSlot/default_form_view'),
    'submit_action' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'submit_action' => 'aPollSlot/sdgdfg'),
    'submit_action_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'submit_action' => 'aPollSlot/submitPollForm'),
    'submit_success_template' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'submit_success_template' => 'aPollSlot/dfgsdfgdfg'),
    'submit_success_template_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'submit_success_template' => 'aPollSlot/default_submit_success'),
    'send_notification' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_notification' => 'asdgsdfgsdf'),
    'send_notification_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_notification' => true),
    'email_to' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_to' => 'asdgsdfgsdf'),
    'email_to_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_to' => 'asdfsdf@asdgdfg.com'),
    'email_to_ok2' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_to' => 'admin'),
    'email_from' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_from' => 'asdgsdfgsdf'),
    'email_from_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_from' => 'asdfsdf@asdgdfg.com'),
    'email_from_ok2' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'send_from' => 'admin'),
    'email_title' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'email_title_partial' => 'aPollSlot/sdgdfg'),
    'email_title_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'email_title_partial' => 'aPollSlot/email_title'),
    'email_body' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'email_body_partial' => 'aPollSlot/sdgdfg'),
    'email_body_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'email_body_partial' => 'aPollSlot/email_body'),
    'email_stylesheets_single_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'email_stylesheets' => 'apostrophePollPlugin/css/aPoll_email.css'),
    'email_stylesheets_array_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'email_stylesheets' => array('apostrophePollPlugin/css/aPoll_email.css')),
    'email_stylesheets_array' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'email_stylesheets' => array('asdfsd', 'apostrophePollPlugin/css/aPoll_email.css', 'eeee.css')),
    'captcha_do_display' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'captcha_do_display' => 'asdgsdfgsdf'),
    'captcha_do_display_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'captcha_do_display' => true),
    'reports_true' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'reports' => true),
    'reports_num' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'reports' => 5),
    'reports_single_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'reports' => 'excel'),
    'reports_default_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'reports' => '~'),
    'reports_array_ok' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'reports' => array('~', 'excel')),
    'reports_array' => array('name' => 'sadfgsdf', 'form' => 'aPollContactForm', 'reports' => array('asdfsd', 'excel', 'eeee')),
);

class testForm extends sfForm {

    public function configure() {
        
    }

}

$t = new lime_test(34);



$t->diag('aPollValidatorPollItem');


$v = new aPollValidatorPollItem(array('poll_items' => $pi));

$t->is($v->clean('contact'), true, 'The validator accepts valid entries in app_aPoll_available_polls');

test_try($t, $v, 'sdfgdfghfghgj', '/not defined/', 'The validator accepts only poll items defined in app.yml');
test_try($t, $v, 'cip', '/not defined/', 'A "form" field must be defined in app_aPoll_available_polls_xxx');
test_try($t, $v, 'ciop', '/does not exist/', 'The form defined must be callable');
test_try($t, $v, 'ciap', '/does not extend/', 'The form defined must extend aPollBaseForm');
test_try($t, $v, 'view_template', '/"view_template" field cannot be found/', 'The validator checks the view_template field.');
$t->is($v->clean('view_template_ok'), true, 'The validator accepts correct view_template fields.');
test_try($t, $v, 'submit_action', '/"submit_action" field cannot be found/', 'The validator checks the submit_action field.');
$t->is($v->clean('submit_action_ok'), true, 'The validator accepts correct submit_action fields.');
test_try($t, $v, 'submit_success_template', '/"submit_success_template" field cannot be found/', 'The validator checks the submit_success_template field.');
$t->is($v->clean('submit_success_template_ok'), true, 'The validator accepts correct submit_success_template fields.');
test_try($t, $v, 'send_notification', '/only accepts "true" and "false"/', 'The validator checks the send_notification field.');
$t->is($v->clean('send_notification_ok'), true, 'The validator accepts correct send_notification fields.');
test_try($t, $v, 'email_to', '/a valid email or a valid user/', 'The validator checks the send_to field.');
$t->is($v->clean('email_to_ok'), true, 'The validator accepts emails in send_to fields.');
$t->is($v->clean('email_to_ok2'), true, 'The validator accepts usernames in send_to fields.');
test_try($t, $v, 'email_from', '/a valid email or a valid user/', 'The validator checks the send_from field.');
$t->is($v->clean('email_from_ok'), true, 'The validator accepts emails in send_from fields.');
$t->is($v->clean('email_from_ok2'), true, 'The validator accepts usernames in send_from fields.');
test_try($t, $v, 'email_title', '/"email_title_template" field cannot/', 'The validator checks the email_title_partial field.');
$t->is($v->clean('email_title_ok'), true, 'The validator accepts correct email_title_partial fields.');
test_try($t, $v, 'email_body', '/"email_body_template" field cannot/', 'The validator checks the email_body_partial field.');
$t->is($v->clean('email_body_ok'), true, 'The validator accepts correct email_body_partial fields.');

test_try($t, $v, 'email_stylesheets_array', '/Cannot find stylesheets "asdfsd, eeee.css"./', 'The validator checks if stylesheetes are really defined.');
$t->is($v->clean('email_stylesheets_single_ok'), true, 'The validator accepts strings in email_stylesheets field.');
$t->is($v->clean('email_stylesheets_array_ok'), true, 'The validator accepts arrays in email_stylesheets field.');

test_try($t, $v, 'captcha_do_display', '/"captcha_do_display" only accepts/', 'The validator checks the captcha_do_display field.');
$t->is($v->clean('captcha_do_display_ok'), true, 'The validator accepts correct captcha_do_display fields.');
test_try($t, $v, 'reports_true', '/"reports" is not correctly defined/', 'The validator checks the reports field.');
test_try($t, $v, 'reports_num', '/"reports" is not correctly defined/', 'The validator checks the reports field.');

if (class_exists('PHPExcel')) {
    test_try($t, $v, 'reports_array', '/Unknown reports "asdfsd, eeee"./', 'The validator checks if reports are really defined.');
    $t->is($v->clean('reports_single_ok'), true, 'The validator accepts strings in reports field.');
    $t->is($v->clean('reports_array_ok'), true, 'The validator accepts arrays in reports field.');
} else {
    $t->pass('PHPexcel is not enabled. Skipping report checking test.');
    $t->pass('PHPexcel is not enabled. Skipping report checking test.');
    $t->pass('PHPexcel is not enabled. Skipping report checking test.');
}

$t->is($v->clean('reports_default_ok'), true, 'The validator accepts "~" in reports field.');

function test_try($t, $v, $poll, $err_msg, $test_msg) {

    try {
        $t->is($v->clean($poll), true);
        $t->fail('This should not happen.');
    } catch (Exception $e) {
        $t->like($e->getMessage(), $err_msg, $test_msg);
    }
}