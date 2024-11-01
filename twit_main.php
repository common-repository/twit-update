<?php
/*
Plugin Name: Twit-update
Plugin URI: http://software.o-o.ro/twit-update/
Description: This plugin lets your twitter followers know when you edit a post.
Version: 0.004
Author: Andrew M
Author URI: http://software.o-o.ro

*/

function twit_option()
{
    add_options_page("Twit-update", "Twit-update", 'activate_plugins', 'twit-update/twit_options.php');
}
add_action('admin_menu', 'twit_option');
add_action( 'admin_init', 'twit_init' );
 add_action( 'publish_post' , 'twit_edit' );   
 add_action( 'wp_footer' , 'twit_link' );
 add_action("widgets_init", 'twit_widreg');

function twit_edit($post_ID)
{
$twit_p = get_post($post_ID); 

if($twit_p->post_date==$twit_p->post_modified)
{if(get_option('twit_new')=="1")$twit_message=get_option('twit_new_m');}
else if (get_option('twit_edit')=="1" && $twit_p->post_status=="publish" )$twit_message=get_option('twit_edit_m');
else $post_ID;
$twit_message=str_replace("[n]",$twit_p->post_title,$twit_message);
$twit_message=str_replace("[url]",get_bloginfo('url')."/?p=".$post_ID,$twit_message);
$twit_temp=$twit_p->post_author;
$twit_temp2=get_userdata($twit_temp);
$twit_message=str_replace("[a]",$twit_temp2->display_name,$twit_message);
$twit_message=str_replace("[c]",$twit_p->comment_count,$twit_message);
$twit_message=str_replace("[o]",$twit_p->post_date,$twit_message);
$twit_message=str_replace("[l]",$twit_p->post_modified,$twit_message);
$twit_message=str_replace("[some]",$twit_p->post_excerpt,$twit_message);
$twit_message=str_replace("[all]",$twit_p->post_content,$twit_message);

twit_posting($twit_message);
return $post_ID;
}

function twit_posting($message)
{
$username = get_option('twit_mail');
$password = get_option('twit_pass');



$url = 'http://twitter.com/statuses/update.xml';

$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, "$url");
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");
curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
$buffer = curl_exec($curl_handle);
curl_close($curl_handle);

}


function twit_widctrl()
{echo'
<p><label>Title<input name="twit_w_title" type="text" value="'.get_option('twit_w_title').'" /></label></p>
  <p><label>Tweets<input name="twit_w_count" type="text" value="'.get_option('twit_w_count').'" /></label></p>
  ';
    if (isset($_POST['twit_w_title'])){
    update_option('twit_w_title',attribute_escape($_POST['twit_w_title']));
    update_option('twit_w_count',attribute_escape($_POST['twit_w_count']));
  }
}

function twit_widcont($args)
{
echo $args['before_widget'];
    echo $args['before_title'] . get_option('twit_w_title') . $args['after_title'];
$twit_count=get_option('twit_w_count');   
   if($twit_count<1 || $twit_count>20){$twit_count=3;}
	echo'<div id="twitter_div">
<ul id="twitter_update_list"></ul>
<a href="http://twitter.com/'.get_option('twit_mail').'" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a>
</div>
<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.get_option('twit_mail').'.json?callback=twitterCallback2&amp;count='.$twit_count.'"></script>';
	
    echo $args['after_widget'];
}

function twit_widreg()
{register_sidebar_widget('Twit widget', 'twit_widcont');
 register_widget_control('Twit widget', 'twit_widctrl');
  }
  
  function twit_init(){
	register_setting( 'twit-opt', 'twit_mail' );
	register_setting( 'twit-opt', 'twit_pass' );
	register_setting( 'twit-opt', 'twit_new' );
	register_setting( 'twit-opt', 'twit_edit' );
	register_setting( 'twit-opt', 'twit_new_m' );
	register_setting( 'twit-opt', 'twit_edit_m' );
        register_setting( 'twit-opt', 'twit_cred' );
}


function twit_link()
{if(get_option('twit_cred')!=1){echo'<a href="http://software.o-o.ro" alt="Software, projects and code"> <img src="';bloginfo('wpurl');echo '/wp-content/plugins/twit-update/cred.jpg"> </a>'; }
}
?>