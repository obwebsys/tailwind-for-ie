<?php
/*
Plugin Name: Tailwind.css for IE
Description: Tailwind.css v3 CDNが吐き出したcssをIE用に静的ファイル出力します
Version: 1.0
*/
if ( ! defined( 'ABSPATH' ) ) exit;
require_once(ABSPATH.'wp-admin/includes/file.php');

define( 'MY_PLUGIN_VERSION', '1.0' );
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

add_action('wp_enqueue_scripts', function() {
    // if IE, load css
    $browser = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (!is_user_logged_in()) {
    // if (strstr($browser,'trident') || strstr($browser,'msie')) {
        wp_enqueue_style('style_tw_ie', MY_PLUGIN_URL.'style_tw_ie.css', '', MY_PLUGIN_VERSION);
    }
}, 11);

add_action('the_post','style_tw_ie_func', 10);
function style_tw_ie_func() {
    global $post;
    global $wp_filesystem;

    // check
    if (!file_exists(MY_PLUGIN_PATH.'style_tw_ie.css')) {
        if(WP_Filesystem()){
            $wp_filesystem->put_contents(MY_PLUGIN_PATH."style_tw_ie.css","@charset 'utf-8';\n");
        }
    }
    if (is_user_logged_in()) {
        wp_enqueue_script('script_tw_ie',MY_PLUGIN_URL.'script_tw_ie.js', array(), MY_PLUGIN_VERSION,true);
    }

    // prefetch?
}

// ajax
add_action('wp_head','add_twie_ajaxurl',1);
function add_twie_ajaxurl() {
?>
    <script>
        var twie_ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
    </script>
<?php
}
add_action('wp_ajax_twie_ajaxpost','func_twie_ajaxsubmit');
add_action('wp_ajax_nopriv_twie_ajaxpost','func_twie_ajaxsubmit');
function func_twie_ajaxsubmit(){
    global $wp_filesystem;
    $ret_ary = array();
    $ret_ary["need_refresh"] = false;
    $result = "";
    if (isset($_POST['cmd'])) {
        $cmd =  $_POST['cmd'];
        $style_tw =  $_POST['style_tw'];

        if (WP_Filesystem()) {
            if (!file_exists(MY_PLUGIN_PATH.'style_tw_ie.css')) return;
            $style_base = $wp_filesystem->get_contents(MY_PLUGIN_PATH."style_tw_ie.css");

            $style_base = str_replace(array("\r\n", "\r", "\n"), "\n", $style_base);
            $style_tw = str_replace(array("\r\n", "\r", "\n"), "\n", $style_tw);
            $style_tw = str_replace(array("\\\\"), "\\", $style_tw);
            $style_combine .= $style_base;
            $style_combine .= $style_tw;
            $style_combine = explode("\n", $style_combine);
            // $style_combine = array_unique($style_combine);
            $style_combine = array_reduce($style_combine, function($carry, $item) {
                if (!in_array($item, $carry)) {
                    if (!preg_match('/^\}\*\, \:\:before\, \:\:after \{/', $item)) {
                        $carry[] = $item;
                    }
                } else if (preg_match('/\s+?}$/', $item) && $carry[count($carry)-1] != $item) {
                    $carry[] = $item;
                }
                return $carry;
            }, []);
            $style_combine = join("\n",$style_combine);

            if (strcmp($style_combine,$style_base)!=0) {
                $wp_filesystem->put_contents(MY_PLUGIN_PATH."style_tw_ie.css",$style_combine);
            }
        }
    }

    // $ret_ary["debugout1"] = "";
    $result = json_encode($ret_ary);
    header("Content-type: application/json; charset=UTF-8");
    echo $result;
    die();
}