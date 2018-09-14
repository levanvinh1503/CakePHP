<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       MIT License (https://opensource.org/licenses/mit-license.php)
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('ROOT', dirname(__DIR__));

/**
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('APP_DIR', 'src');

/**
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * Path to the config directory.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS', ROOT . DS . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

/**
 * Format 
 */
define('DATE_TIME', 'yyyy-MM-dd HH:mm:ss');

/**
 * Message function
 */
define('MS_ADD_POST_SUCCESS', 'Thêm bài viết thành công');
define('MS_ADD_POST_ERR', 'Thêm bài viết thất bại');

define('MS_ADD_CATEGORY_SUCCESS', 'Thêm chuyên mục thành công');
define('MS_ADD_CATEGORY_ERR', 'Thêm chuyên mục thất bại');

define('MS_REGISTER_SUCCESS', 'Đăng ký thành công');
define('MS_REGISTER_ERR', 'Thêm chuyên mục thành công');

define('MS_EDIT_POST_SUCCESS', 'Sửa bài viết thành công');

define('MS_EDIT_CATEGORY_SUCCESS', 'Sửa chuyên mục thành công');

define('MS_DELETE_POST_SUCCESS', 'Xóa bài viết thành công');
define('MS_DELETE_POST_ERR', 'Xóa bài viết thất bại, vui lòng kiểm tra lại');

define('MS_DELETE_CATEGORY_SUCCESS', 'Xóa chuyên mục thành công');
define('MS_DELETE_CATEGORY_ERR', 'Xóa chuyên mục thất bại, vui lòng kiểm tra lại');

define('MS_LOGIN_ERR', 'Sai tên đăng nhập hoặc mật khẩu, Vui lòng thử lại !');

/**
 * Message validate of Category
 */
define('MAXLENGTH_CATEGORY_NAME', 'Tên chuyên mục tối đa 191 kí tự');
define('REQUIRED_CATEGORY_NAME', 'Tên chuyên mục không được bỏ trống');
define('UNIQUE_CATEGORY_NAME', 'Tên chuyên mục đã có');

define('MAXLENGTH_CATEGORY_SLUG', 'Đường dẫn chuyên mục tối đa 191 kí tự');
define('REQUIRED_CATEGORY_SLUG', 'Đường dẫn chuyên mục không được bỏ trống');
define('UNIQUE_CATEGORY_SLUG', 'Trùng đường dẫn');

/**
 * Message validate of Posts
 */
define('MAXLENGTH_POST_TITLE', 'Tên bài viết tối đa 191 kí tự');
define('REQUIRED_POST_TITLE', 'Tên bài viết không được bỏ trống');
define('UNIQUE_POST_TITLE', 'Tên bài viết đã có');

define('MAXLENGTH_POST_SLUG', 'Đường dẫn của bài viết tối đa 191 kí tự');
define('REQUIRED_POST_SLUG', 'Đường dẫn của bài viết không được bỏ trống');
define('UNIQUE_POST_SLUG', 'Trùng đường dẫn bài viết');

define('MAXLENGTH_POST_DESCRIPTION', 'Mô tả ngắn quá dài');
define('REQUIRED_POST_DESCRIPTION', 'Mô tả ngắn của bài viết không được bỏ trống');

define('REQUIRED_POST_CONTENT', 'Nội dung bài viết không được bỏ trống');

define('REQUIRED_POST_IMAGE', 'Ảnh đại diện của bài viết không được bỏ trống');

/**
 * Message validate of Users
 */
define('MAXLENGTH_USER_USERNAME', 'Tên đăng nhập tối đa 191 kí tự');
define('REQUIRED_USER_USERNAME', 'Tên đăng nhập không được bỏ trống');
define('UNIQUE_USER_USERNAME', 'Tên đăng nhập đã có người sử dụng');

define('MAXLENGTH_USER_FULLNAME', 'Họ tên tối đa 191 kí tự');
define('REQUIRED_USER_FULLNAME', 'Họ tên không được bỏ trống');

define('MAXLENGTH_USER_EMAIL', 'Email tối đa 191 kí tự');
define('REQUIRED_USER_EMAIL', 'Email không được bỏ trống');
define('UNIQUE_USER_EMAIL', 'Email đã có người sử dụng');

define('MAXLENGTH_USER_PASSWORD', 'Mật khẩu tối đa 191 kí tự');
define('REQUIRED_USER_PASSWORD', 'Mật khẩu không được bỏ trống');
define('MINLENGTH_USER_PASSWORD', 'Mật khẩu ít nhất 8 kí tự');

define('MAXLENGTH_USER_RE_PASSWORD', 'Mật khẩu tối đa 191 kí tự');
define('REQUIRED_USER_RE_PASSWORD', 'Nhập lại mật khẩu không được bỏ trống');
define('MINLENGTH_USER_RE_PASSWORD', 'Mật khẩu ít nhất 8 kí tự');
define('ADD_USER_RE_PASSWORD', 'Mật khẩu và xác nhận mật khẩu không khớp');

define('MAXLENGTH_USER_PHONENUMBER', 'Số điện thoại tối đa 191 kí tự');
define('REQUIRED_USER_PHONENUMBER', 'Số điện thoại không được bỏ trống');
define('NUMBER_USER_PHONENUMBER', 'Số điện thoại phải là số');

define('MAXLENGTH_USER_ADDRESS', 'Địa chỉ tối đa 191 kí tự');
define('REQUIRED_USER_ADDRESS', 'Địa chỉ không được bỏ trống');

/**
 * Message Import file
 */
define('IMPORT_SUCCESS', 'Import file thành công !');
define('UPLOAD_ERR', 'Lỗi upload !');
define('FORMAT_ERR', 'Sai cấu trúc file !');
