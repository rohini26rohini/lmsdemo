<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include(FCPATH.'/configuration.php');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/

defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define("ENCRYPTION_KEY","de2c4ef21d5911a3f0fe082c1f7e27d6");
define("PDF_MASTER_PASSWORD","gbs!@#$%");
define('CAPTCHA_ATTEMPT','4');

define('DAILY_TEST_NEGATIVE',FALSE);
define('DEFAULT_OPTIONS_COUNT',5); //Set the number of default options availale for question adding in material managenemt
 
define("CURRENCY","INR");
define("FILE_MAX_SIZE",10240);
define("VIDEO_LECTURE_SIZE",25600);
define("AUDIO_LECTURE_SIZE",25600);

//define("APIURI",$api_base_url['api_base_url']);

// Leave
define('DOCUMENT_UPLOAD_SIZE_BYTE','1048576000'); 
define('DOCUMENT_UPLOAD_SIZE_MB','1000');
define('SCRIPT_CACHE_CODE','108');
define('RECEIPT_ITEM_LIMIT','2');

// Salary Constants
define('WORKING_DAYS','30');

// Salary Components
define('1','Basic Pay');
define('2','DA');
define('3','PF');
define('status','4'); 
define('START_YEAR','2018');
define('YEAR_LIMIT','30');
define('UPLOAD_IMAGE_SIZE', 5120); 
define('DEFAULT_STATE', 19); 
define('DEFAULT_CITY', 1947); 

//EXAM COLORS
define('EXAM_START_COLOR', '#1fac02'); 
define('EXAM_FINISH_COLOR', '#ff4e4e'); 
define('EXAM_RESULT_PUBLISHED_COLOR', '#837cae'); 
define('EXAM_CLOSED_COLOR', '#b0b0b0'); 
define('EXAM_DEACTIVATED_COLOR', '#b00020'); 

//CCAVENUE 

define("CCAVENUE_MERCHANT_ID", "218361");
define("ACCESS_CODE", "AVBB89HA72AM51BBMA");
define("WORKING_KEY", "44202116E147A5375A07F67936B6B0DB");

// define("CCAVENUE_SUCCESS_URL", "http://direction.school/beta/Transactions/success");
// define("CCAVENUE_CANCEL_URL", "http://direction.school/beta/Transactions/cancel");


define("CCAVENUE_SUCCESS_URL", "http://direction.school/Transaction_success");
define("CCAVENUE_CANCEL_URL", "http://direction.school/Transaction_success");
if($_SERVER['HTTP_HOST'] == 'localhost:88') {
    define('APIURI', "http://localhost:88/lms/");
} else if($_SERVER['HTTP_HOST'] == 'localhost') {
    define('APIURI', "http://localhost/lms/");
} else {
	define('APIURI', "http://13.232.81.74/lms_app/");
}

