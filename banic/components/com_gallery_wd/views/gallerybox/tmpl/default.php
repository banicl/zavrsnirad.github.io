<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();




require_once(WD_BWG_DIR . '/framework/WDWLibrary.php');
 $current_url = '';
 $session = JFactory::getSession();
 
 $current_url = $session->get('current_url');
 


 $current_url=bgw_url_decode(JRequest::getVar('current_url'));


 
 
   $tag_id = (isset($_GET['tag_id']) ? htmlspecialchars($_GET['tag_id']) : 0);
    $gallery_id = (isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : 0);
    $bwg = (isset($_GET['current_view']) ? htmlspecialchars($_GET['current_view']) : 0);
    $current_image_id = (isset($_GET['image_id']) ? htmlspecialchars($_GET['image_id']) : 0);
    $theme_id = (isset($_GET['theme_id']) ? htmlspecialchars($_GET['theme_id']) : 1);
    $thumb_width = (isset($_GET['thumb_width']) ? htmlspecialchars($_GET['thumb_width']) : 120);
    $thumb_height = (isset($_GET['thumb_height']) ? htmlspecialchars($_GET['thumb_height']) : 90);
    $open_with_fullscreen = (isset($_GET['open_with_fullscreen']) ? htmlspecialchars($_GET['open_with_fullscreen']) : 0);
    $open_with_autoplay = (isset($_GET['open_with_autoplay']) ? htmlspecialchars($_GET['open_with_autoplay']) : 0);
    $image_width = (isset($_GET['image_width']) ? htmlspecialchars($_GET['image_width']) : 800);
    $image_height = (isset($_GET['image_height']) ? htmlspecialchars($_GET['image_height']) : 500);
    $image_effect = 'fade';
    $sort_by = (isset($_GET['sort_by']) ? htmlspecialchars($_GET['sort_by']) : 'order');
    $order_by = (isset($_GET['order_by']) ? htmlspecialchars($_GET['order_by']) : 'asc');
    $enable_image_filmstrip = FALSE;
    $enable_image_fullscreen = (isset($_GET['enable_image_fullscreen']) ? htmlspecialchars($_GET['enable_image_fullscreen']) : 0);
    $popup_enable_info = (isset($_GET['popup_enable_info']) ? htmlspecialchars($_GET['popup_enable_info']) : 1);
    $popup_info_always_show = (isset($_GET['popup_info_always_show']) ? htmlspecialchars($_GET['popup_info_always_show']) : 0);
    $popup_enable_rate = 0;
    $popup_hit_counter = 0;

    if ($enable_image_filmstrip) {
      $image_filmstrip_height = (isset($_GET['image_filmstrip_height']) ? htmlspecialchars($_GET['image_filmstrip_height']) : '20');
      $thumb_ratio = $thumb_width / $thumb_height;
      $image_filmstrip_width = round($thumb_ratio * $image_filmstrip_height);
    }
    else {
      $image_filmstrip_height = 0;
      $image_filmstrip_width = 0;
    }

    $slideshow_interval = (isset($_GET['slideshow_interval']) ? (int) $_GET['slideshow_interval'] : 5);
    $enable_image_ctrl_btn = (isset($_GET['enable_image_ctrl_btn']) ? htmlspecialchars($_GET['enable_image_ctrl_btn']) : 0);
    $enable_comment_social = FALSE;
    $enable_image_facebook = FALSE;
    $enable_image_twitter = FALSE;
    $enable_image_google = FALSE;
    $enable_image_pinterest = FALSE;
    $enable_image_tumblr = FALSE;

    $watermark_type = (isset($_GET['watermark_type']) ? htmlspecialchars($_GET['watermark_type']) : 'none');
    $watermark_text = (isset($_GET['watermark_text']) ? htmlspecialchars($_GET['watermark_text']) : '');
    $watermark_font_size = (isset($_GET['watermark_font_size']) ? htmlspecialchars($_GET['watermark_font_size']) : 12);
    $watermark_font = (isset($_GET['watermark_font']) ? htmlspecialchars($_GET['watermark_font']) : 'Arial');
    $watermark_color = (isset($_GET['watermark_color']) ? htmlspecialchars($_GET['watermark_color']) : 'FFFFFF');
    $watermark_opacity = (isset($_GET['watermark_opacity']) ? htmlspecialchars($_GET['watermark_opacity']) : 30);
    $watermark_position = explode('-', (isset($_GET['watermark_position']) ? htmlspecialchars($_GET['watermark_position']) : 'bottom-right'));
    $watermark_link = (isset($_GET['watermark_link']) ? htmlspecialchars($_GET['watermark_link']) : '');
    $watermark_url = (isset($_GET['watermark_url']) ? htmlspecialchars($_GET['watermark_url']) : '');
    $watermark_width = (isset($_GET['watermark_width']) ? htmlspecialchars($_GET['watermark_width']) : 90);
    $watermark_height = (isset($_GET['watermark_height']) ? htmlspecialchars($_GET['watermark_height']) : 90);

    $theme_row = $this->get_theme_row_data;
    $option_row = $this->get_option_row_data;
    $image_right_click = $option_row->image_right_click;
    $comment_moderation = $option_row->comment_moderation;

    $filmstrip_direction = 'horizontal';
    if ($theme_row->lightbox_filmstrip_pos == 'right' || $theme_row->lightbox_filmstrip_pos == 'left') {
      $filmstrip_direction = 'vertical';        
    }
    if ($enable_image_filmstrip) {
      if ($filmstrip_direction == 'horizontal') {
        $image_filmstrip_height = (isset($_GET['image_filmstrip_height']) ? htmlspecialchars($_GET['image_filmstrip_height']) : '20');
        $thumb_ratio = $thumb_width / $thumb_height;
        $image_filmstrip_width = round($thumb_ratio * $image_filmstrip_height);
      }
      else {
        $image_filmstrip_width = (isset($_GET['image_filmstrip_height']) ? htmlspecialchars($_GET['image_filmstrip_height']) : '50');
        $thumb_ratio = $thumb_height / $thumb_width;
        $image_filmstrip_height = round($thumb_ratio * $image_filmstrip_width);
      }
    }
    else {
      $image_filmstrip_height = 0;
      $image_filmstrip_width = 0;
    }

    if ($tag_id != 0) {
      $image_rows = $this->get_image_rows_data_tag;
    }
    else {
      $image_rows = $this->get_image_rows_data;
    }
    $image_id = (isset($_POST['image_id']) ? (int) $_POST['image_id'] : $current_image_id);
    $comment_rows = $this->get_comment_rows_data;

    $params_array = array(
      'view' => 'gallerybox',
      'image_id' => $current_image_id,
      'gallery_id' => $gallery_id,
      'theme_id' => $theme_id,
      'thumb_width' => $thumb_width,
      'thumb_height' => $thumb_height,
      'open_with_fullscreen' => $open_with_fullscreen,
      'image_width' => $image_width,
      'image_height' => $image_height,
      'image_effect' => $image_effect,
      'sort_by' => $sort_by,
      'order_by' => $order_by,
      'enable_image_filmstrip' => $enable_image_filmstrip,
      'image_filmstrip_height' => $image_filmstrip_height,
      'enable_image_ctrl_btn' => $enable_image_ctrl_btn,
      'enable_image_fullscreen' => $enable_image_fullscreen,
      'popup_enable_info' => $popup_enable_info,
      'popup_info_always_show' => $popup_info_always_show,
      'popup_hit_counter' => $popup_hit_counter,
      'popup_enable_rate' => $popup_enable_rate,
      'slideshow_interval' => $slideshow_interval,
      'enable_comment_social' => $enable_comment_social,
      'enable_image_facebook' => $enable_image_facebook,
      'enable_image_twitter' => $enable_image_twitter,
      'enable_image_google' => $enable_image_google,
      'enable_image_pinterest' => $enable_image_pinterest,
      'enable_image_tumblr' => $enable_image_tumblr,
      'watermark_type' => $watermark_type,
      'current_url' => bgw_url_encode($current_url)
    );
    if ($watermark_type != 'none') {
      $params_array['watermark_link'] = $watermark_link;
      $params_array['watermark_opacity'] = $watermark_opacity;
      $params_array['watermark_position'] = $watermark_position;
    }
    if ($watermark_type == 'text') {
      $params_array['watermark_text'] = $watermark_text;
      $params_array['watermark_font_size'] = $watermark_font_size;
      $params_array['watermark_font'] = $watermark_font;
      $params_array['watermark_color'] = $watermark_color;
    }
    elseif ($watermark_type == 'image') {
      $params_array['watermark_url'] = $watermark_url;
      $params_array['watermark_width'] = $watermark_width;
      $params_array['watermark_height'] = $watermark_height;
    }
	
	
    $popup_url = array_to_url($params_array);

	
	
    $filmstrip_thumb_margin = $theme_row->lightbox_filmstrip_thumb_margin;
    $margins_split = explode(" ", $filmstrip_thumb_margin);
    $filmstrip_thumb_margin_right = 0;
    $filmstrip_thumb_margin_left = 0;
    $temp_iterator = ($filmstrip_direction == 'horizontal' ? 1 : 0);
    if (isset($margins_split[$temp_iterator])) {
      $filmstrip_thumb_margin_right = (int) $margins_split[$temp_iterator];
      if (isset($margins_split[$temp_iterator + 2])) {
        $filmstrip_thumb_margin_left = (int) $margins_split[$temp_iterator + 2];
      }
      else {
        $filmstrip_thumb_margin_left = $filmstrip_thumb_margin_right;
      }
    }
    elseif (isset($margins_split[0])) {
      $filmstrip_thumb_margin_right = (int) $margins_split[0];
      $filmstrip_thumb_margin_left = $filmstrip_thumb_margin_right;
    }
    $filmstrip_thumb_margin_hor = $filmstrip_thumb_margin_right + $filmstrip_thumb_margin_left;
    $rgb_bwg_image_info_bg_color = WDWLibrary::spider_hex2rgb($theme_row->lightbox_info_bg_color);
    $rgb_bwg_image_hit_bg_color = WDWLibrary::spider_hex2rgb($theme_row->lightbox_hit_bg_color);
    $rgb_lightbox_ctrl_cont_bg_color = WDWLibrary::spider_hex2rgb($theme_row->lightbox_ctrl_cont_bg_color);
    if (!$enable_image_filmstrip) {
      if ($theme_row->lightbox_filmstrip_pos == 'left') {
        $theme_row->lightbox_filmstrip_pos = 'top';
      }
      if ($theme_row->lightbox_filmstrip_pos == 'right') {
        $theme_row->lightbox_filmstrip_pos = 'bottom';
      }
    }
    $left_or_top = 'left';
    $width_or_height= 'width';
    $outerWidth_or_outerHeight = 'outerWidth';
    if (!($filmstrip_direction == 'horizontal')) {
      $left_or_top = 'top';
      $width_or_height = 'height';
      $outerWidth_or_outerHeight = 'outerHeight';
    }
    ?>
    <style>
      .spider_popup_wrap * {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
      }
      .spider_popup_wrap {
        background-color: #<?php echo $theme_row->lightbox_bg_color; ?>;
        display: inline-block;
        left: 50%;
        outline: medium none;
        position: fixed;
        text-align: center;
        top: 50%;
        z-index: 100000;
      }
      .bwg_popup_image {
        max-width: <?php echo $image_width - ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>px;
        max-height: <?php echo $image_height - ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>px;
        vertical-align: middle;
        display: inline-block;
      }
      .bwg_popup_video {
        width: <?php echo $image_width - ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>px;
        height: <?php echo $image_height - ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>px;
        vertical-align: middle;
        display: inline-block;
      }
      .bwg_ctrl_btn {
        color: #<?php echo $theme_row->lightbox_ctrl_btn_color; ?>;
        font-size: <?php echo $theme_row->lightbox_ctrl_btn_height; ?>px;
        margin: <?php echo $theme_row->lightbox_ctrl_btn_margin_top; ?>px <?php echo $theme_row->lightbox_ctrl_btn_margin_left; ?>px;
        opacity: <?php echo $theme_row->lightbox_ctrl_btn_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_ctrl_btn_transparent; ?>);
      }
      .bwg_toggle_btn {
        color: #<?php echo $theme_row->lightbox_ctrl_btn_color; ?>;
        font-size: <?php echo $theme_row->lightbox_toggle_btn_height; ?>px;
        margin: 0;
        opacity: <?php echo $theme_row->lightbox_ctrl_btn_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_ctrl_btn_transparent; ?>);
        padding: 0;
      }
      .bwg_btn_container {
        bottom: 0;
        left: 0;
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 0;
      }
      .bwg_ctrl_btn_container {
        background-color: rgba(<?php echo $rgb_lightbox_ctrl_cont_bg_color['red']; ?>, <?php echo $rgb_lightbox_ctrl_cont_bg_color['green']; ?>, <?php echo $rgb_lightbox_ctrl_cont_bg_color['blue']; ?>, <?php echo $theme_row->lightbox_ctrl_cont_transparent / 100; ?>);
        /*background: none repeat scroll 0 0 #<?php echo $theme_row->lightbox_ctrl_cont_bg_color; ?>;*/
        <?php
        if ($theme_row->lightbox_ctrl_btn_pos == 'top') {
          ?>
          border-bottom-left-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          border-bottom-right-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          <?php
        }
        else {
          ?>
          bottom: 0;
          border-top-left-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          border-top-right-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          <?php
        }?>
        height: <?php echo $theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top; ?>px;
        /*opacity: <?php echo $theme_row->lightbox_ctrl_cont_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_ctrl_cont_transparent; ?>);*/
        position: absolute;
        text-align: <?php echo $theme_row->lightbox_ctrl_btn_align; ?>;
        width: 100%;
        z-index: 10150;
      }
      .bwg_toggle_container {
        background: none repeat scroll 0 0 #<?php echo $theme_row->lightbox_ctrl_cont_bg_color; ?>;
        <?php
        if ($theme_row->lightbox_ctrl_btn_pos == 'top') {
          ?>
          border-bottom-left-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          border-bottom-right-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          top: <?php echo $theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top; ?>px;
          <?php
        }
        else {
          ?>
          border-top-left-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          border-top-right-radius: <?php echo $theme_row->lightbox_ctrl_cont_border_radius; ?>px;
          bottom: <?php echo $theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top; ?>px;
          <?php
        }?>
        cursor: pointer;
        left: 50%;
        line-height: 0;
        margin-left: -<?php echo $theme_row->lightbox_toggle_btn_width / 2; ?>px;
        opacity: <?php echo $theme_row->lightbox_ctrl_cont_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_ctrl_cont_transparent; ?>);
        position: absolute;
        text-align: center;
        width: <?php echo $theme_row->lightbox_toggle_btn_width; ?>px;
        z-index: 10150;
      }
      .bwg_close_btn {
        opacity: <?php echo $theme_row->lightbox_close_btn_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_close_btn_transparent; ?>);
      }
      .spider_popup_close {
        background-color: #<?php echo $theme_row->lightbox_close_btn_bg_color; ?>;
        border-radius: <?php echo $theme_row->lightbox_close_btn_border_radius; ?>;
        border: <?php echo $theme_row->lightbox_close_btn_border_width; ?>px <?php echo $theme_row->lightbox_close_btn_border_style; ?> #<?php echo $theme_row->lightbox_close_btn_border_color; ?>;
        box-shadow: <?php echo $theme_row->lightbox_close_btn_box_shadow; ?>;
        color: #<?php echo $theme_row->lightbox_close_btn_color; ?>;
        height: <?php echo $theme_row->lightbox_close_btn_height; ?>px;
        font-size: <?php echo $theme_row->lightbox_close_btn_size; ?>px;
        right: <?php echo $theme_row->lightbox_close_btn_right; ?>px;
        top: <?php echo $theme_row->lightbox_close_btn_top; ?>px;
        width: <?php echo $theme_row->lightbox_close_btn_width; ?>px;
      }
      .spider_popup_close_fullscreen {
        color: #<?php echo $theme_row->lightbox_close_btn_full_color; ?>;
        font-size: <?php echo $theme_row->lightbox_close_btn_size; ?>px;
        right: 15px;
      }
      .spider_popup_close span,
      #spider_popup_left-ico span,
      #spider_popup_right-ico span {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
      }
      #spider_popup_left-ico,
      #spider_popup_right-ico {
        background-color: #<?php echo $theme_row->lightbox_rl_btn_bg_color; ?>;
        border-radius: <?php echo $theme_row->lightbox_rl_btn_border_radius; ?>;
        border: <?php echo $theme_row->lightbox_rl_btn_border_width; ?>px <?php echo $theme_row->lightbox_rl_btn_border_style; ?> #<?php echo $theme_row->lightbox_rl_btn_border_color; ?>;
        box-shadow: <?php echo $theme_row->lightbox_rl_btn_box_shadow; ?>;
        color: #<?php echo $theme_row->lightbox_rl_btn_color; ?>;
        height: <?php echo $theme_row->lightbox_rl_btn_height; ?>px;
        font-size: <?php echo $theme_row->lightbox_rl_btn_size; ?>px;
        width: <?php echo $theme_row->lightbox_rl_btn_width; ?>px;
        opacity: <?php echo $theme_row->lightbox_rl_btn_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_rl_btn_transparent; ?>);
      }
      .bwg_ctrl_btn:hover,
      .bwg_toggle_btn:hover,
      .spider_popup_close:hover,
      .spider_popup_close_fullscreen:hover,
      #spider_popup_left-ico:hover,
      #spider_popup_right-ico:hover {
        color: #<?php echo $theme_row->lightbox_close_rl_btn_hover_color; ?>;
        cursor: pointer;
      }
      .bwg_image_wrap {
        height: inherit;
        display: table;
        position: absolute;
        text-align: center;
        width: inherit;
      }
      .bwg_image_wrap * {
        -moz-user-select: none;
        -khtml-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .bwg_comment_wrap {
        bottom: 0;
        left: 0;
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 0;
        z-index: -1;
      }
      .bwg_comment_container {
        -moz-box-sizing: border-box;
        background-color: #<?php echo $theme_row->lightbox_comment_bg_color; ?>;
        color: #<?php echo $theme_row->lightbox_comment_font_color; ?>;
        font-size: <?php echo $theme_row->lightbox_comment_font_size; ?>px;
        font-family: <?php echo $theme_row->lightbox_comment_font_style; ?>;
        height: 100%;
        overflow: hidden;
        position: absolute;
        <?php echo $theme_row->lightbox_comment_pos; ?>: -<?php echo $theme_row->lightbox_comment_width; ?>px;
        top: 0;
        width: <?php echo $theme_row->lightbox_comment_width; ?>px;
        z-index: 10103;
      }
      .bwg_comments {
        bottom: 0;
        font-size: <?php echo $theme_row->lightbox_comment_font_size; ?>px;
        font-family: <?php echo $theme_row->lightbox_comment_font_style; ?>;
        height: 100%;
        left: 0;
        overflow-x: hidden;
        overflow-y: auto;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 10101;
      }
      .bwg_comments p,
      .bwg_comment_body_p {
        margin: 5px !important;
        text-align: left;
        word-wrap: break-word;
        word-break: break-word;
      }
      .bwg_comments input[type="submit"] {
        background: none repeat scroll 0 0 #<?php echo $theme_row->lightbox_comment_button_bg_color; ?>;
        border: <?php echo $theme_row->lightbox_comment_button_border_width; ?>px <?php echo $theme_row->lightbox_comment_button_border_style; ?> #<?php echo $theme_row->lightbox_comment_button_border_color; ?>;
        border-radius: <?php echo $theme_row->lightbox_comment_button_border_radius; ?>;
        color: #<?php echo $theme_row->lightbox_comment_font_color; ?>;
        cursor: pointer;
        padding: <?php echo $theme_row->lightbox_comment_button_padding; ?>;
      }
      .bwg_comments input[type="text"],
      .bwg_comments textarea {
        background: none repeat scroll 0 0 #<?php echo $theme_row->lightbox_comment_input_bg_color; ?>;
        border: <?php echo $theme_row->lightbox_comment_input_border_width; ?>px <?php echo $theme_row->lightbox_comment_input_border_style; ?> #<?php echo $theme_row->lightbox_comment_input_border_color; ?>;
        border-radius: <?php echo $theme_row->lightbox_comment_input_border_radius; ?>;
        color: #<?php echo $theme_row->lightbox_comment_font_color; ?>;
        padding: <?php echo $theme_row->lightbox_comment_input_padding; ?>;
        width: 100%;
      }
      .bwg_comments textarea {
        resize: vertical;
      }
      .bwg_comment_header_p {
        border-top: <?php echo $theme_row->lightbox_comment_separator_width; ?>px <?php echo $theme_row->lightbox_comment_separator_style; ?> #<?php echo $theme_row->lightbox_comment_separator_color; ?>;
      }
      .bwg_comment_header {
        color: #<?php echo $theme_row->lightbox_comment_font_color; ?>;
        font-size: <?php echo $theme_row->lightbox_comment_author_font_size; ?>px;
      }
      .bwg_comment_date {
        color: #<?php echo $theme_row->lightbox_comment_font_color; ?>;
        float: right;
        font-size: <?php echo $theme_row->lightbox_comment_date_font_size; ?>px;
      }
      .bwg_comment_body {
        color: #<?php echo $theme_row->lightbox_comment_font_color; ?>;
        font-size: <?php echo $theme_row->lightbox_comment_body_font_size; ?>px;
      }
      .bwg_comment_delete_btn {
        color: #FFFFFF;
        cursor: pointer;
        float: right;
        font-size: 14px;
        margin: 2px;
      }
      .bwg_comments_close {
        cursor: pointer;
        line-height: 0;
        position: relative;
        font-size: 13px;
        text-align: <?php echo (($theme_row->lightbox_comment_pos == 'left') ? 'right' : 'left'); ?>;
        margin: 5px;
        z-index: 10150;
      }
      .bwg_comment_textarea::-webkit-scrollbar {
        width: 4px;
      }
      .bwg_comment_textarea::-webkit-scrollbar-track {
      }
      .bwg_comment_textarea::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.55);
        border-radius: 2px;
      }  
      .bwg_comment_textarea::-webkit-scrollbar-thumb:hover {
        background-color: #D9D9D9;
      }
      .bwg_ctrl_btn_container a,
      .bwg_ctrl_btn_container a:hover {
        text-decoration: none;
      }
      .bwg_rate:hover {
        color: #<?php echo $theme_row->lightbox_rate_color; ?>;
      }
      .bwg_facebook:hover {
        color: #3B5998;
      }
      .bwg_twitter:hover {
        color: #4099FB;
      }
      .bwg_google:hover {
        color: #DD4B39;
      }
      .bwg_pinterest:hover {
        color: #cb2027;
      }
      .bwg_tumblr:hover {
        color: #2F5070;
      }
      .bwg_facebook,
      .bwg_twitter,
      .bwg_google,
      .bwg_pinterest,
      .bwg_tumblr {
        color: #<?php echo $theme_row->lightbox_comment_share_button_color; ?>;
      }
      .bwg_image_container {
        display: table;
        position: absolute;
        text-align: center;
        <?php echo $theme_row->lightbox_filmstrip_pos; ?>: <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : $image_filmstrip_width); ?>px;
        vertical-align: middle;
        width: 100%;
      }      
      .bwg_filmstrip_container {
        display: <?php echo ($filmstrip_direction == 'horizontal'? 'table' : 'block'); ?>;
        height: <?php echo ($filmstrip_direction == 'horizontal'? $image_filmstrip_height : $image_height); ?>px;
        position: absolute;
        width: <?php echo ($filmstrip_direction == 'horizontal' ? $image_width : $image_filmstrip_width); ?>px;
        z-index: 10105;
        <?php echo $theme_row->lightbox_filmstrip_pos; ?>: 0;
      }
      .bwg_filmstrip {
        <?php echo $left_or_top; ?>: 20px;
        overflow: hidden;
        position: absolute;
        <?php echo $width_or_height; ?>: <?php echo ($filmstrip_direction == 'horizontal' ? $image_width - 40 : $image_height - 40); ?>px;
        z-index: 10106;
      }
      .bwg_filmstrip_thumbnails {
        height: <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : ($image_filmstrip_height + $filmstrip_thumb_margin_hor) * count($image_rows)); ?>px;
        <?php echo $left_or_top; ?>: 0px;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
        width: <?php echo ($filmstrip_direction == 'horizontal' ? ($image_filmstrip_width + $filmstrip_thumb_margin_hor) * count($image_rows) : $image_filmstrip_width); ?>px;
      }
      .bwg_filmstrip_thumbnail {
        position: relative;
        background: none;
        border: <?php echo $theme_row->lightbox_filmstrip_thumb_border_width; ?>px <?php echo $theme_row->lightbox_filmstrip_thumb_border_style; ?> #<?php echo $theme_row->lightbox_filmstrip_thumb_border_color; ?>;
        border-radius: <?php echo $theme_row->lightbox_filmstrip_thumb_border_radius; ?>;
        cursor: pointer;
        float: left;
        height: <?php echo $image_filmstrip_height; ?>px;
        margin: <?php echo $theme_row->lightbox_filmstrip_thumb_margin; ?>;
        width: <?php echo $image_filmstrip_width; ?>px;
        overflow: hidden;
      }
      .bwg_thumb_active {
        opacity: 1;
        filter: Alpha(opacity=100);
        border: <?php echo $theme_row->lightbox_filmstrip_thumb_active_border_width; ?>px solid #<?php echo $theme_row->lightbox_filmstrip_thumb_active_border_color; ?>;
      }
      .bwg_thumb_deactive {
        opacity: <?php echo $theme_row->lightbox_filmstrip_thumb_deactive_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_filmstrip_thumb_deactive_transparent; ?>);
      }
      .bwg_filmstrip_thumbnail_img {
        display: block;
        opacity: 1;
        filter: Alpha(opacity=100);
      }
      .bwg_filmstrip_left {
        background-color: #<?php echo $theme_row->lightbox_filmstrip_rl_bg_color; ?>;
        cursor: pointer;
        display: <?php echo ($filmstrip_direction == 'horizontal' ? 'table-cell' : 'block') ?>;
        vertical-align: middle;
        <?php echo $width_or_height; ?>: 20px;
        z-index: 10106;
        <?php echo $left_or_top; ?>: 0;
        <?php echo ($filmstrip_direction == 'horizontal' ? '' : 'position: absolute;') ?>
        <?php echo ($filmstrip_direction == 'horizontal' ? '' : 'width: 100%;') ?> 
      }
      .bwg_filmstrip_right {
        background-color: #<?php echo $theme_row->lightbox_filmstrip_rl_bg_color; ?>;
        cursor: pointer;
        <?php echo($filmstrip_direction == 'horizontal' ? 'right' : 'bottom') ?>: 0;
        <?php echo $width_or_height; ?>: 20px;
        display: <?php echo ($filmstrip_direction == 'horizontal' ? 'table-cell' : 'block') ?>;
        vertical-align: middle;
        z-index: 10106;
        <?php echo ($filmstrip_direction == 'horizontal' ? '' : 'position: absolute;') ?>
        <?php echo ($filmstrip_direction == 'horizontal' ? '' : 'width: 100%;') ?>
      }
      .bwg_filmstrip_left i,
      .bwg_filmstrip_right i {
        color: #<?php echo $theme_row->lightbox_filmstrip_rl_btn_color; ?>;
        font-size: <?php echo $theme_row->lightbox_filmstrip_rl_btn_size; ?>px;
      }
      .bwg_none_selectable {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .bwg_watermark_container {
        display: table-cell;
        margin: 0 auto;
        position: relative;
        vertical-align: middle;
      }
      .bwg_watermark_spun {
        display: table-cell;
        overflow: hidden;
        position: relative;
        text-align: <?php echo $watermark_position[1]; ?>;
        vertical-align: <?php echo $watermark_position[0]; ?>;
        /*z-index: 10140;*/
      }
      .bwg_watermark_image {
        margin: 4px;
        max-height: <?php echo $watermark_height; ?>px;
        max-width: <?php echo $watermark_width; ?>px;
        opacity: <?php echo $watermark_opacity / 100; ?>;
        filter: Alpha(opacity=<?php echo $watermark_opacity; ?>);
        position: relative;
        z-index: 10141;
      }
      .bwg_watermark_text,
      .bwg_watermark_text:hover {
        text-decoration: none;
        margin: 4px;
        font-size: <?php echo $watermark_font_size; ?>px;
        font-family: <?php echo $watermark_font; ?>;
        color: #<?php echo $watermark_color; ?> !important;
        opacity: <?php echo $watermark_opacity / 100; ?>;
        filter: Alpha(opacity=<?php echo $watermark_opacity; ?>);
        position: relative;
        z-index: 10141;
      }
      .bwg_slide_container {
        display: table-cell;
        position: absolute;
        vertical-align: middle;
        width: 100%;
        height: 100%;
      }
      .bwg_slide_bg {
        margin: 0 auto;
        width: inherit;
        height: inherit;
      }
      .bwg_slider {
        height: inherit;
        width: inherit;
      }
      .bwg_popup_image_spun {
        height: inherit;
        display: table-cell;
        filter: Alpha(opacity=100);
        opacity: 1;
        position: absolute;
        vertical-align: middle;
        width: inherit;
        z-index: 2;
      }
      .bwg_popup_image_second_spun {
        width: inherit;
        height: inherit;
        display: table-cell;
        filter: Alpha(opacity=0);
        opacity: 0;
        position: absolute;
        vertical-align: middle;
        z-index: 1;
      }
      .bwg_grid {
        display: none;
        height: 100%;
        overflow: hidden;
        position: absolute;
        width: 100%;
      }
      .bwg_gridlet {
        opacity: 1;
        filter: Alpha(opacity=100);
        position: absolute;
      }
      .bwg_image_info_container1 {
        display: <?php echo $popup_info_always_show ? 'table-cell' : 'none'; ?>;
      }
      .bwg_image_hit_container1 {
        display: <?php echo $popup_hit_counter ? 'table-cell' : 'none'; ?>;;
      }
      .bwg_image_info_spun {
        text-align: <?php echo $theme_row->lightbox_info_align; ?>;
        vertical-align: <?php echo $theme_row->lightbox_info_pos; ?>;
      }
      .bwg_image_hit_spun {
        text-align: <?php echo $theme_row->lightbox_hit_align; ?>;
        vertical-align: <?php echo $theme_row->lightbox_hit_pos; ?>;
      }
      .bwg_image_hit {
        background: rgba(<?php echo $rgb_bwg_image_hit_bg_color['red']; ?>, <?php echo $rgb_bwg_image_hit_bg_color['green']; ?>, <?php echo $rgb_bwg_image_hit_bg_color['blue']; ?>, <?php echo $theme_row->lightbox_hit_bg_transparent / 100; ?>);
        border: <?php echo $theme_row->lightbox_hit_border_width; ?>px <?php echo $theme_row->lightbox_hit_border_style; ?> #<?php echo $theme_row->lightbox_hit_border_color; ?>;
        border-radius: <?php echo $theme_row->lightbox_info_border_radius; ?>;
        <?php echo ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_hit_pos == 'bottom') ? 'bottom: ' . ($theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top) . 'px;' : '' ?>
        margin: <?php echo $theme_row->lightbox_hit_margin; ?>;
        padding: <?php echo $theme_row->lightbox_hit_padding; ?>;
        <?php echo ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_hit_pos == 'top') ? 'top: ' . ($theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top) . 'px;' : '' ?>
      }
      .bwg_image_hits,
      .bwg_image_hits * {
        color: #<?php echo $theme_row->lightbox_hit_color; ?> !important;
        font-family: <?php echo $theme_row->lightbox_hit_font_style; ?>;
        font-size: <?php echo $theme_row->lightbox_hit_font_size; ?>px;
        font-weight: <?php echo $theme_row->lightbox_hit_font_weight; ?>;
      }
      .bwg_image_info {
        background: rgba(<?php echo $rgb_bwg_image_info_bg_color['red']; ?>, <?php echo $rgb_bwg_image_info_bg_color['green']; ?>, <?php echo $rgb_bwg_image_info_bg_color['blue']; ?>, <?php echo $theme_row->lightbox_info_bg_transparent / 100; ?>);
        border: <?php echo $theme_row->lightbox_info_border_width; ?>px <?php echo $theme_row->lightbox_info_border_style; ?> #<?php echo $theme_row->lightbox_info_border_color; ?>;
        border-radius: <?php echo $theme_row->lightbox_info_border_radius; ?>;
        <?php echo ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_info_pos == 'bottom') ? 'bottom: ' . ($theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top) . 'px;' : '' ?>
        margin: <?php echo $theme_row->lightbox_info_margin; ?>;
        padding: <?php echo $theme_row->lightbox_info_padding; ?>;
        <?php echo ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_info_pos == 'top') ? 'top: ' . ($theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top) . 'px;' : '' ?>
      }
      .bwg_image_title,
      .bwg_image_title * {
        color: #<?php echo $theme_row->lightbox_title_color; ?> !important;
        font-family: <?php echo $theme_row->lightbox_title_font_style; ?>;
        font-size: <?php echo $theme_row->lightbox_title_font_size; ?>px;
        font-weight: <?php echo $theme_row->lightbox_title_font_weight; ?>;
      }
      .bwg_image_description,
      .bwg_image_description * {
        color: #<?php echo $theme_row->lightbox_description_color; ?> !important;
        font-family: <?php echo $theme_row->lightbox_description_font_style; ?>;
        font-size: <?php echo $theme_row->lightbox_description_font_size; ?>px;
        font-weight: <?php echo $theme_row->lightbox_description_font_weight; ?>;
      }
      .bwg_image_rate_spun {
        text-align: <?php echo $theme_row->lightbox_rate_align; ?>;
        vertical-align: <?php echo $theme_row->lightbox_rate_pos; ?>;
      }
      .bwg_image_rate {
        <?php echo ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_rate_pos == 'bottom') ? 'bottom: ' . ($theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top) . 'px;' : '' ?>
        padding: <?php echo $theme_row->lightbox_rate_padding; ?>;
        <?php echo ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_rate_pos == 'top') ? 'top: ' . ($theme_row->lightbox_ctrl_btn_height + 2 * $theme_row->lightbox_ctrl_btn_margin_top) . 'px;' : '' ?>
      }
      #bwg_rate_form .bwg_hint,
      #bwg_rate_form .fa-<?php echo $theme_row->lightbox_rate_icon; ?>,
      #bwg_rate_form .fa-<?php echo $theme_row->lightbox_rate_icon; ?>-half-o,
      #bwg_rate_form .fa-<?php echo $theme_row->lightbox_rate_icon; ?>-o,
      #bwg_rate_form .fa-minus-square-o {
        color: #<?php echo $theme_row->lightbox_rate_color; ?>;
        font-size: <?php echo $theme_row->lightbox_rate_size; ?>px;
      }
      #bwg_rate_form .bwg_hint {
        margin: 0 5px;
        display: none;
      }
      .bwg_rate_hover {
        color: #<?php echo $theme_row->lightbox_rate_hover_color; ?> !important;
      }
      .bwg_star {
        display: inline-block;
      }
      .bwg_rated {
        color: #<?php echo $theme_row->lightbox_rate_color; ?>;
        display: none;
        font-size: <?php echo $theme_row->lightbox_rate_size - 2; ?>px;
      }
    </style>
    <script>
      var data = [];
      var event_stack = [];
      <?php
      $image_id_exist = FALSE;
      foreach ($image_rows as $key => $image_row) {
	  		$image_row->thumb_url=addslashes(htmlspecialchars($image_row->thumb_url));
			  $image_row->image_url=addslashes(htmlspecialchars($image_row->image_url));
			  $image_row->alt=addslashes(htmlspecialchars($image_row->alt));
			  $image_row->filename=addslashes(htmlspecialchars($image_row->filename));
 

        if ($image_row->id == $image_id) {
          $current_avg_rating = $image_row->avg_rating;
          $current_rate = $image_row->rate;
          $current_rate_count = $image_row->rate_count;
          $current_image_key = $key;
        }
        if ($image_row->id == $current_image_id) {
          $current_image_alt = $image_row->alt;
          $current_image_hit_count = $image_row->hit_count;
          $current_image_description = str_replace(array("\r\n", "\n", "\r"), htmlspecialchars('<br />'), $image_row->description);
          $current_image_url = $image_row->image_url;
          $current_thumb_url = $image_row->thumb_url;
          $current_filetype = $image_row->filetype;
          $image_id_exist = TRUE;
        }
        ?>
        data["<?php echo $key; ?>"] = [];
        data["<?php echo $key; ?>"]["id"] = "<?php echo $image_row->id; ?>";
        data["<?php echo $key; ?>"]["alt"] = "<?php echo addslashes($image_row->alt); ?>";
        data["<?php echo $key; ?>"]["description"] = "<?php echo str_replace(array("\r\n", "\n", "\r"), htmlspecialchars('<br />'), addslashes($image_row->description)); ?>";
        data["<?php echo $key; ?>"]["image_url"] = "<?php echo $image_row->image_url; ?>";
        data["<?php echo $key; ?>"]["thumb_url"] = "<?php echo $image_row->thumb_url; ?>";
        data["<?php echo $key; ?>"]["date"] = "<?php echo $image_row->date; ?>";
        data["<?php echo $key; ?>"]["comment_count"] = "<?php echo $image_row->comment_count; ?>";
        data["<?php echo $key; ?>"]["filetype"] = "<?php echo $image_row->filetype; ?>";
        data["<?php echo $key; ?>"]["filename"] = "<?php echo $image_row->filename; ?>";
        data["<?php echo $key; ?>"]["avg_rating"] = "<?php echo $image_row->avg_rating; ?>";
        data["<?php echo $key; ?>"]["rate"] = "<?php echo $image_row->rate; ?>";
        data["<?php echo $key; ?>"]["rate_count"] = "<?php echo $image_row->rate_count; ?>";
        data["<?php echo $key; ?>"]["hit_count"] = "<?php echo $image_row->hit_count; ?>";
        <?php
      }
      ?>
    </script>
    <?php
    if (!$image_id_exist) {
      echo WDWLibrary::message(JText::_('DELETED_IMAGE'), 'error');
      die();
    }
    ?>
    <div class="bwg_image_wrap">
      <?php
      if ($enable_image_ctrl_btn) {
      ?>
      <div class="bwg_btn_container">
        <div class="bwg_ctrl_btn_container">
          <i title="<?php echo JText::_('PLAY'); ?>" class="bwg_ctrl_btn bwg_play_pause fa fa-play"></i>
          <?php if ($enable_image_fullscreen) {
                  if (!$open_with_fullscreen) {
          ?>
          <i title="<?php echo JText::_('MAXIMIZE'); ?>" class="bwg_ctrl_btn bwg_resize-full fa fa-resize-full "></i>
          <?php
          }
          ?>
          <i title="<?php echo JText::_('FULLSCREEN'); ?>" class="bwg_ctrl_btn bwg_fullscreen fa fa-fullscreen"></i>
          <?php } if ($popup_enable_info) { ?>
          <i title="<?php echo JText::_('SHOW_INFO'); ?>" class="bwg_ctrl_btn bwg_info fa fa-info"></i>
          <?php } if ($enable_comment_social) { ?>
          <i title="<?php echo JText::_('SHOW_COMMENTS'); ?>" class="bwg_ctrl_btn bwg_comment fa fa-comment"></i>
          <?php } if ($popup_enable_rate) { ?>
          <i title="<?php echo JText::_('SHOW_RATING'); ?>" class="bwg_ctrl_btn bwg_rate fa fa-star"></i>
          <?php } 
          $share_url =  JURI::root().array_to_url(array('view' => 'Share', 'curr_url' => bgw_url_encode($current_url), 'image_id' => $current_image_id)) . '#bwg' . $gallery_id . '/' . $current_image_id;
		  

          $share_image_url = urlencode(($current_filetype == "YOUTUBE" || $current_filetype == "VIMEO") ? $current_thumb_url : JURI::root()  . WD_BWG_UPLOAD_DIR .'/' . $current_image_url);
          if ($enable_image_facebook) {
            ?>
<a id="bwg_facebook_a" href="https://www.facebook.com/sharer/sharer.php?sdk=joey&u=<?php echo urlencode($share_url) ?>" target="_blank" title="<?php echo JText::_('SHARE_FACEBOOK'); ?>">
              <i title="<?php echo JText::_('SHARE_FACEBOOK'); ?>" class="bwg_ctrl_btn bwg_facebook fa fa-facebook"></i>
            </a>
            <?php
          }
          if ($enable_image_twitter) {
            ?>
            <a id="bwg_twitter_a" href="https://twitter.com/share?url=<?php echo urlencode($share_url); ?>" target="_blank" title="<?php echo JText::_('SHARE_TWITTER'); ?>">
              <i title="<?php echo JText::_('SHARE_TWITTER'); ?>" class="bwg_ctrl_btn bwg_twitter fa fa-twitter"></i>
            </a>
            <?php
          }
          if ($enable_image_google) {
            ?>
            <a id="bwg_google_a" href="https://plus.google.com/share?url=<?php echo urlencode($share_url); ?>" target="_blank" title="<?php echo JText::_('SHARE_GOOGLE'); ?>">
              <i title="<?php echo JText::_('SHARE_GOOGLE'); ?>" class="bwg_ctrl_btn bwg_google fa fa-google-plus"></i>
            </a>
            <?php
          }
          if ($enable_image_pinterest) {
            ?>
            <a id="bwg_pinterest_a" href="http://pinterest.com/pin/create/button/?s=100&url=<?php echo urlencode($share_url); ?>&media=<?php echo $share_image_url; ?>&description=<?php echo $current_image_description; ?>" target="_blank" title="<?php echo JText::_('SHARE_PINTEREST'); ?>">
              <i title="<?php echo JText::_('SHARE_PINTEREST'); ?>" class="bwg_ctrl_btn bwg_pinterest fa fa-pinterest"></i>
            </a>
            <?php
          }
          if ($enable_image_tumblr) {
            ?>
            <a id="bwg_tumblr_a" href="https://www.tumblr.com/share/photo?source=<?php echo $share_image_url; ?>&caption=<?php echo urlencode($current_image_alt); ?>&clickthru=<?php echo urlencode($share_url); ?>" target="_blank" title="<?php echo JText::_('SHARE_TUMBLR'); ?>">
              <i title="<?php echo JText::_('SHARE_TUMBLR'); ?>" class="bwg_ctrl_btn bwg_tumblr fa fa-tumblr"></i>
            </a>
            <?php
          }
          if ($option_row->popup_enable_fullsize_image) {
            ?>
            <a id="bwg_fullsize_image" href="<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/' . $current_image_url; ?>" target="_blank">
              <i title="<?php echo JText::_('IMAGE_ORIGINAL_SIZE'); ?>" class="bwg_ctrl_btn fa fa-external-link"></i>
            </a>
            <?php
          }
          if ($option_row->popup_enable_download) {
            ?>
            <a id="bwg_download" href="<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/' . $current_image_url; ?>" target="_blank" download="<?php echo $current_image_url; ?>">
              <i title="<?php echo JText::_('DOWNLOAD_ORIGINAL_IMAGE'); ?>" class="bwg_ctrl_btn fa fa-download"></i>
            </a>
            <?php
          }
          ?>
        </div>
        <div class="bwg_toggle_container">
          <i class="bwg_toggle_btn fa <?php echo (($theme_row->lightbox_ctrl_btn_pos == 'top') ? 'fa-angle-up' : 'fa-angle-down'); ?>"></i>
        </div>
      </div>
      <?php
      }
      $current_pos = 0;
      if ($enable_image_filmstrip) {
        ?>
        <div class="bwg_filmstrip_container">
          <div class="bwg_filmstrip_left"><i class="fa <?php echo ($filmstrip_direction == 'horizontal'? 'fa-angle-left' : 'fa-angle-up'); ?> "></i></div>
          <div class="bwg_filmstrip">
            <div class="bwg_filmstrip_thumbnails">
              <?php
              foreach ($image_rows as $key => $image_row) {
			  	  		$image_row->thumb_url=htmlspecialchars($image_row->thumb_url);
			  $image_row->image_url=htmlspecialchars($image_row->image_url);
			  			  $image_row->alt=htmlspecialchars($image_row->alt);
			  $image_row->filename=htmlspecialchars($image_row->filename);
 

                if ($image_row->id == $current_image_id) {
                  $current_pos = $key * (($filmstrip_direction == 'horizontal' ? $image_filmstrip_width : $image_filmstrip_height) + $filmstrip_thumb_margin_hor);
                  $current_key = $key;
                }
                $is_video = $image_row->filetype == "YOUTUBE" || $image_row->filetype == "VIMEO";
                if (!$is_video) {
                  list($image_thumb_width, $image_thumb_height) = getimagesize(htmlspecialchars_decode(JPATH_SITE .'/'. WD_BWG_UPLOAD_DIR.'/' . $image_row->thumb_url, ENT_COMPAT | ENT_QUOTES));
                }
                else {
                  $image_thumb_width = $image_filmstrip_width;
                  $image_thumb_height = $image_filmstrip_height;
                }
                $scale = max($image_filmstrip_width / $image_thumb_width, $image_filmstrip_height / $image_thumb_height);
                $image_thumb_width *= $scale;
                $image_thumb_height *= $scale;
                $thumb_left = ($image_filmstrip_width - $image_thumb_width) / 2;
                $thumb_top = ($image_filmstrip_height - $image_thumb_height) / 2;
              ?>
              <div id="bwg_filmstrip_thumbnail_<?php echo $key; ?>" class="bwg_filmstrip_thumbnail <?php echo (($image_row->id == $current_image_id) ? 'bwg_thumb_active' : 'bwg_thumb_deactive'); ?>">
                <img style="width:<?php echo $image_thumb_width; ?>px; height:<?php echo $image_thumb_height; ?>px; margin-left: <?php echo $thumb_left; ?>px; margin-top: <?php echo $thumb_top; ?>px;" class="bwg_filmstrip_thumbnail_img" src="<?php echo ($is_video ? "" : JURI::root()  . WD_BWG_UPLOAD_DIR .'/') . $image_row->thumb_url; ?>" onclick="bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), '<?php echo $key; ?>', data)" ontouchend="bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), '<?php echo $key; ?>', data)" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $key; ?>" alt="<?php echo $image_row->alt; ?>" />
              </div>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="bwg_filmstrip_right"><i class="fa <?php echo ($filmstrip_direction == 'horizontal'? 'fa-angle-right' : 'fa-angle-down'); ?>"></i></div>
        </div>
        <?php
      }
      if ($watermark_type != 'none') {
      ?>
      <div class="bwg_image_container">
        <div class="bwg_watermark_container">
          <div style="display:table; margin:0 auto;">
            <span class="bwg_watermark_spun" id="bwg_watermark_container">
              <?php
              if ($watermark_type == 'image') {
              ?>
              <a href="<?php echo $watermark_link; ?>" target="_blank">
                <img class="bwg_watermark_image bwg_watermark" src="<?php echo $watermark_url; ?>" />
              </a>
              <?php
              }
              elseif ($watermark_type == 'text') {
              ?>
              <a class="bwg_none_selectable bwg_watermark_text bwg_watermark" target="_blank" href="<?php echo $watermark_link; ?>"><?php echo $watermark_text; ?></a>
              <?php
              }
              ?>
            </span>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
      <div id="bwg_image_container" class="bwg_image_container">
        <div class="bwg_image_info_container1">
          <div class="bwg_image_info_container2">
            <span class="bwg_image_info_spun">
              <div class="bwg_image_info">
                <div class="bwg_image_title"><?php echo html_entity_decode($current_image_alt); ?></div>
                <div class="bwg_image_description"><?php echo html_entity_decode($current_image_description); ?></div>
              </div>
            </span>
          </div>
        </div>
        <div class="bwg_image_hit_container1">
          <div class="bwg_image_hit_container2">
            <span class="bwg_image_hit_spun">
              <div class="bwg_image_hit">
                <div class="bwg_image_hits"><?php echo JText::_('HITS '); ?><span><?php echo $current_image_hit_count; ?></span></div>
              </div>
            </span>
          </div>
        </div>
        <div class="bwg_image_rate_container1">
          <div class="bwg_image_rate_container2">
            <span class="bwg_image_rate_spun">
              <span class="bwg_image_rate">
                <form id="bwg_rate_form" method="post" action="<?php echo $popup_url; ?>">
                  <span id="bwg_star" class="bwg_star" data-score="<?php echo $current_avg_rating; ?>"></span>
                  <span id="bwg_rated" class="bwg_rated"><?php echo JText::_('RATED'); ?></span>
                  <span id="bwg_hint" class="bwg_hint"></span>
                  <script>

                    function bwg_rating(current_rate, rate_count, avg_rating, cur_key) {
                      var avg_rating_message = "<?php echo JText::_('NOT_RATED'); ?>";
                      if (avg_rating != 0 && avg_rating != "") {
                        avg_rating_message = parseFloat(avg_rating).toFixed(1) + "\n<?php echo JText::_('VOTES'); ?>" + rate_count;
                      }

					  
                      jQuery("#bwg_star").raty({
                        score: function() {
                          return jQuery(this).attr("data-score");
                        },
                        number : <?php echo $theme_row->lightbox_rate_stars_count; ?>,
                        size : <?php echo $theme_row->lightbox_rate_size; ?>,
                        readOnly : function() {
                          return (current_rate ? true : false);
                        },
                        noRatedMsg : "<?php echo JText::_('NOT_RATED'); ?>",
                        click : function(score, evt) {
                          jQuery("#bwg_star").hide();
                          jQuery("#bwg_rated").show();
                          spider_set_input_value('rate_ajax_task', 'save_rate');
                          spider_rate_ajax_save('bwg_rate_form');
                          data[cur_key]["rate"] = score;
                          ++data[cur_key]["rate_count"];
                          var curr_score = parseFloat(jQuery("#bwg_star").attr("data-score"));
                          data[cur_key]["avg_rating"] = curr_score ? ((curr_score + score) / 2).toFixed(1) : score.toFixed(1);
                        },
                        starHalf : 'fa fa-<?php echo $theme_row->lightbox_rate_icon . (($theme_row->lightbox_rate_icon == 'star') ? '-half' : ''); ?>-o',
                        starOff : 'fa fa-<?php echo $theme_row->lightbox_rate_icon; ?>-o',
                        starOn : 'fa fa-<?php echo $theme_row->lightbox_rate_icon; ?>',
                        cancelOff : 'fa fa-minus-square-o',
                        cancelOn : 'fa fa-minus-square-o',
                        cancel : false,
                        /*target : '#bwg_hint',
                        targetType : 'number',
                        targetKeep : true,*/
                        cancelHint : '<?php echo JText::_('CANCEL_RATEING'); ?>',
                        hints : [avg_rating_message, avg_rating_message, avg_rating_message, avg_rating_message, avg_rating_message],
                        alreadyRatedMsg : parseFloat(avg_rating).toFixed(1) + "\n" + "<?php echo JText::_('ALLREADY_REATED'); ?>\n<?php echo JText::_('VOTES'); ?>" + rate_count,
                      });
                    }
                    bwg_rating("<?php echo $current_rate; ?>", "<?php echo $current_rate_count; ?>", "<?php echo $current_avg_rating; ?>", "<?php echo $current_image_key; ?>");
                  </script>
                  <input id="rate_ajax_task" name="ajax_task" type="hidden" value="" />
                  <input id="rate_image_id" name="image_id" type="hidden" value="<?php echo $image_id; ?>" />
                </form>
              </span>
            </span>
          </div>
        </div>
        <div class="bwg_slide_container">
          <div class="bwg_slide_bg">
            <div class="bwg_slider">
          <?php
          $current_key = -6;
          foreach ($image_rows as $key => $image_row) {
		  	  	  		$image_row->thumb_url=htmlspecialchars($image_row->thumb_url);
			  $image_row->image_url=htmlspecialchars($image_row->image_url);
			  			  $image_row->alt=htmlspecialchars($image_row->alt);
			  $image_row->filename=htmlspecialchars($image_row->filename);

            $is_video = $image_row->filetype == "YOUTUBE" || $image_row->filetype == "VIMEO";
            if ($image_row->id == $current_image_id) {
              $current_key = $key;
              ?>
              <span class="bwg_popup_image_spun" id="bwg_popup_image" image_id="<?php echo $image_row->id; ?>">
                <span class="bwg_popup_image_spun1" style="display: table; width: inherit; height: inherit;">
                  <span class="bwg_popup_image_spun2" style="display: table-cell; vertical-align: middle; text-align: center;">
                    <?php 
                      if (!$is_video) {
                      ?>
                      <img class="bwg_popup_image" src="<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/' . $image_row->image_url; ?>" alt="<?php echo $image_row->alt; ?>" />
                      <?php 
                      }
                      else { ?>
                        <span class="bwg_popup_video">
                          <iframe class="bwg_video_frame" src="<?php echo ($image_row->filetype == "YOUTUBE" ? "//www.youtube.com/embed/" . $image_row->filename . "?enablejsapi=1" : "//player.vimeo.com/video/" . $image_row->filename . "?api=1"); ?>" frameborder="0" allowfullscreen style="width:100%; height:100%;"></iframe>
                        </span>
                      <?php
                      }
                    ?>                    
                  </span>
                </span>
              </span>
              <span class="bwg_popup_image_second_spun">                
              </span>
              <input type="hidden" id="bwg_current_image_key" value="<?php echo $key; ?>" />
              <?php
              if ($key == 0) {?>
                <script>jQuery("#spider_popup_left").hover().css({"display": "none"});</script><?php
              }
              if ($key == (count($image_rows) - 1)) {?>
                <script>jQuery("#spider_popup_right").hover().css({"display": "none"});</script><?php
              }
              break;
            }
          }
          ?>
            </div>
          </div>
        </div>
        <a id="spider_popup_left"><span id="spider_popup_left-ico"><span><i class="bwg_prev_btn fa <?php echo $theme_row->lightbox_rl_btn_style; ?>-left"></i></span></span></a>
        <a id="spider_popup_right"><span id="spider_popup_right-ico"><span><i class="bwg_next_btn fa <?php echo $theme_row->lightbox_rl_btn_style; ?>-right"></i></span></span></a>
      </div>
    </div>
    <?php if ($enable_comment_social) { ?>
    <div class="bwg_comment_wrap">
      <div class="bwg_comment_container bwg_close">
        <div id="ajax_loading" style="position:absolute;">
          <div id="opacity_div" style="display:none; background-color:rgba(255, 255, 255, 0.2); position:absolute; z-index:10150;"></div>
          <span id="loading_div" style="display:none; text-align:center; position:relative; vertical-align:middle; z-index:10170">
            <img src="<?php echo WD_BWG_URL . '/images/ajax_loader.png'; ?>" class="spider_ajax_loading" style="width:50px;">
          </span>
        </div>
        <div class="bwg_comments">
          <?php
          $captcha_error_message = '';
          $email_error_message = '';
          $bwg_name = '';
          $bwg_comment = '';
          $bwg_email = '';
          if (isset($_POST['ajax_task']) && (htmlspecialchars(stripslashes($_POST['ajax_task'])) === 'save_comment')) {
            if ($option_row->popup_enable_captcha) {
              $bwg_captcha_input = (isset($_POST['bwg_captcha_input']) ? htmlspecialchars(stripslashes($_POST['bwg_captcha_input'])) : '');
              @session_start();
              $bwg_captcha_code = (isset($_SESSION['bwg_captcha_code']) ? htmlspecialchars(stripslashes($_SESSION['bwg_captcha_code'])) : '');
              if ($bwg_captcha_input !== $bwg_captcha_code) {
                $captcha_error_message = JText::_('CAPTCHA_ERROR');
                $bwg_name = (isset($_POST['bwg_name']) ? htmlspecialchars(stripslashes($_POST['bwg_name'])) : '');
                $bwg_comment = (isset($_POST['bwg_comment']) ? htmlspecialchars(stripslashes($_POST['bwg_comment'])) : '');
                $bwg_email = (isset($_POST['bwg_email']) ? htmlspecialchars(stripslashes($_POST['bwg_email'])) : '');
              }
            }
            if ($option_row->popup_enable_email && isset($_POST['bwg_email']) && !is_email(stripslashes($_POST['bwg_email']))) {
              $email_error_message = JText::_( 'EMAIL_ERROR' );
              $bwg_name = (isset($_POST['bwg_name']) ? htmlspecialchars(stripslashes($_POST['bwg_name'])) : '');
              $bwg_comment = (isset($_POST['bwg_comment']) ? htmlspecialchars(stripslashes($_POST['bwg_comment'])) : '');
              $bwg_email = (isset($_POST['bwg_email']) ? htmlspecialchars(stripslashes($_POST['bwg_email'])) : '');
            }
          }
          ?>
          <div id="bwg_comments">
            <div title="<?php echo JText::_('HIDE_COMMENTS'); ?>" class="bwg_comments_close">
              <i class="bwg_comments_close_btn fa fa-arrow-<?php echo $theme_row->lightbox_comment_pos; ?>"></i>
            </div>
            <form id="bwg_comment_form" method="post" action="<?php echo $popup_url; ?>">
              <p><label for="bwg_name"><?php echo JText::_('NAME'); ?> * </label></p>
              <p><input type="text" name="bwg_name" id="bwg_name" <?php echo (($user->id != 0) ? 'readonly="readonly"' : ''); ?>
                        value="<?php echo (($user->id != 0) ?  $user->name : $bwg_name); ?>" /></p>
              <?php
              if ($option_row->popup_enable_email) {
              ?>
              <p><label for="bwg_email"><?php echo JText::_('EMAIL'); ?> * </label></p>
              <p><input type="text" name="bwg_email" id="bwg_email"
                        value="<?php echo (($user->id != 0) ?  $user->email : $bwg_email); ?>" /></p>
              <p><span class="bwg_comment_error"><?php echo $email_error_message; ?></span></p>
              <?php
              }
              ?>
              <p><label for="bwg_comment"><?php echo JText::_('COMMENT'); ?> * </label></p>
              <p><textarea class="bwg_comment_textarea" name="bwg_comment" id="bwg_comment"><?php echo $bwg_comment; ?></textarea></p>
              <?php
              if ($option_row->popup_enable_captcha) {
              ?>
              <p><label for="bwg_captcha_input"><?php echo JText::_('VERIFICATION_CODE'); ?></label></p>
              <p>
                <input id="bwg_captcha_input" name="bwg_captcha_input" class="bwg_captcha_input" type="text">
                <img id="bwg_captcha_img" class="bwg_captcha_img" type="captcha" digit="6" src="<?php echo array_to_url(array('view' => 'captcha', 'digit' => 6, 'i' => '')); ?>" onclick="bwg_captcha_refresh('bwg_captcha')" ontouchend="bwg_captcha_refresh('bwg_captcha')" />
                <span id="bwg_captcha_refresh" class="bwg_captcha_refresh" onclick="bwg_captcha_refresh('bwg_captcha')" ontouchend="bwg_captcha_refresh('bwg_captcha')"></span>
              </p>
              <p><span class="bwg_comment_error"><?php echo $captcha_error_message; ?></span></p>
              <?php
              }
              ?>
              <p><input onclick="if (spider_check_required('bwg_name', '<?php echo JText::_('NAME'); ?>') <?php if ($option_row->popup_enable_email) { ?> || spider_check_required('bwg_email', '<?php echo JText::_('EMAIL'); ?>') || spider_check_email('bwg_email') <?php } ?> || spider_check_required('bwg_comment', '<?php echo JText::_('Comment'); ?>')) { return false;}
                                 var cur_image_key = parseInt(jQuery('#bwg_current_image_key').val());
                                 ++data[cur_image_key]['comment_count'];
                                 spider_set_input_value('ajax_task', 'save_comment');
                                 spider_set_input_value('image_id', jQuery('#bwg_popup_image').attr('image_id'));
                                 spider_ajax_save('bwg_comment_form');
                                 return false;"
                        ontouchend="if (spider_check_required('bwg_name', '<?php echo JText::_('NAME'); ?>') <?php if ($option_row->popup_enable_email) { ?> || spider_check_required('bwg_email', '<?php echo JText::_('EMAIL'); ?>') || spider_check_email('bwg_email') <?php } ?> || spider_check_required('bwg_comment', '<?php echo JText::_('COMMENT'); ?>')) {return false;}
                                 var cur_image_key = parseInt(jQuery('#bwg_current_image_key').val());
                                 ++data[cur_image_key]['comment_count'];
                                 spider_set_input_value('ajax_task', 'save_comment');
                                 spider_set_input_value('image_id', jQuery('#bwg_popup_image').attr('image_id'));
                                 spider_ajax_save('bwg_comment_form');
                                 return false;" class="bwg_submit" type="submit" name="bwg_submit" id="bwg_submit" value="<?php echo JText::_('SUBMIT'); ?>" /></p>
              <?php echo (($comment_moderation && (isset($_POST['bwg_comment']) && htmlspecialchars($_POST['bwg_comment'])))) ? JText::_('COMMENT_MODERATION') : ''; ?>
              <input id="ajax_task" name="ajax_task" type="hidden" value="" />
              <input id="image_id" name="image_id" type="hidden" value="<?php echo $image_id; ?>" />
              <input id="comment_id" name="comment_id" type="hidden" value="" />
            </form>
          </div>
          <div id="bwg_added_comments">
            <?php
            foreach ($comment_rows as $comment_row) {
              ?>
              <div class="bwg_single_comment">
                <p class="bwg_comment_header_p">
                  <span class="bwg_comment_header"><?php echo $comment_row->name; ?></span>
                  <?php
                  if ($comment_row->user_id==$user->id) {
                    ?>
                    <i onclick="var cur_image_key = parseInt(jQuery('#bwg_current_image_key').val());
                           --data[cur_image_key]['comment_count'];
                           spider_set_input_value('ajax_task', 'delete');
                           spider_set_input_value('image_id', jQuery('#bwg_popup_image').attr('image_id'));
                           spider_set_input_value('comment_id', '<?php echo $comment_row->id; ?>');
                           spider_ajax_save('bwg_comment_form');
                           return false;"
                       ontouchend="var cur_image_key = parseInt(jQuery('#bwg_current_image_key').val());
                           --data[cur_image_key]['comment_count'];
                           spider_set_input_value('ajax_task', 'delete');
                           spider_set_input_value('image_id', jQuery('#bwg_popup_image').attr('image_id'));
                           spider_set_input_value('comment_id', '<?php echo $comment_row->id; ?>');
                           spider_ajax_save('bwg_comment_form');
                           return false;" title="<?php echo JText::_('DELETE_COMMENT'); ?>" class="bwg_comment_delete_btn fa fa-times"></i>
                    <?php
                  }
                  ?>
                  <span class="bwg_comment_date"><?php echo $comment_row->date; ?></span>
                </p>
                <div class="bwg_comment_body_p">
                  <span class="bwg_comment_body"><?php echo $comment_row->comment; ?></span>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

    <a class="spider_popup_close" onclick="spider_destroypopup(1000); return false;" ontouchend="spider_destroypopup(1000); return false;"><span><i class="bwg_close_btn fa fa-times"></i></span></a>

    <script>

      var bwg_trans_in_progress = false;
      var bwg_transition_duration = <?php echo (($slideshow_interval < 4) && ($slideshow_interval != 0)) ? ($slideshow_interval * 1000) / 4 : 800; ?>;
      var bwg_playInterval;
      if ((jQuery("#spider_popup_wrap").width() >= jQuery(window).width()) || (jQuery("#spider_popup_wrap").height() >= jQuery(window).height())) {
        jQuery(".spider_popup_close").attr("class", "bwg_ctrl_btn spider_popup_close_fullscreen");
      }
      /* Stop autoplay.*/
      window.clearInterval(bwg_playInterval);
      /* Set watermark container size.*/
      function bwg_change_watermark_container() {
        jQuery(".bwg_slider").children().each(function() {
          if (jQuery(this).css("zIndex") == 2) {
            var bwg_current_image_span = jQuery(this).find("img");
            if (!bwg_current_image_span.length) {
              bwg_current_image_span = jQuery(this).find("iframe");
            }
            var width = bwg_current_image_span.width();
            var height = bwg_current_image_span.height();
            jQuery(".bwg_watermark_spun").width(width);
            jQuery(".bwg_watermark_spun").height(height);
            jQuery(".bwg_watermark").css({display: ''});
            /* Set watermark image size.*/
            var comment_container_width = 0;
            if (jQuery(".bwg_comment_container").hasClass("bwg_open")) {
              comment_container_width = <?php echo $theme_row->lightbox_comment_width; ?>;
            }
            if (width <= (jQuery(window).width() - comment_container_width)) {
              jQuery(".bwg_watermark_image").css({
                width: (jQuery(".spider_popup_wrap").width() - comment_container_width) * <?php echo $watermark_width / $image_width; ?>
              });
              jQuery(".bwg_watermark_text, .bwg_watermark_text:hover").css({
                fontSize: (jQuery(".spider_popup_wrap").width() - comment_container_width) * <?php echo $watermark_font_size / $image_width; ?>
              });
            }
          }
        });
      }
      var bwg_current_key = '<?php echo $current_key; ?>';
      var bwg_current_filmstrip_pos = <?php echo $current_pos; ?>;
      /* Set filmstrip initial position.*/
      function bwg_set_filmstrip_pos(filmStripWidth) {
        var selectedImagePos = -bwg_current_filmstrip_pos - (jQuery(".bwg_filmstrip_thumbnail").<?php echo $outerWidth_or_outerHeight; ?>(true)) / 2;
        var imagesContainerLeft = Math.min(0, Math.max(filmStripWidth - jQuery(".bwg_filmstrip_thumbnails").<?php echo $width_or_height; ?>(), selectedImagePos + filmStripWidth / 2));
        jQuery(".bwg_filmstrip_thumbnails").animate({
            <?php echo $left_or_top; ?>: imagesContainerLeft
          }, {
            duration: 500,
            complete: function () { bwg_filmstrip_arrows(); }
          });
      }
      function bwg_move_filmstrip() {
        var image_left = jQuery(".bwg_thumb_active").position().<?php echo $left_or_top; ?>;
        var image_right = jQuery(".bwg_thumb_active").position().<?php echo $left_or_top; ?> + jQuery(".bwg_thumb_active").<?php echo $outerWidth_or_outerHeight; ?>(true);
        var bwg_filmstrip_width = jQuery(".bwg_filmstrip").<?php echo $outerWidth_or_outerHeight; ?>(true);
        var bwg_filmstrip_thumbnails_width = jQuery(".bwg_filmstrip_thumbnails").<?php echo $outerWidth_or_outerHeight; ?>(true);
        var long_filmstrip_cont_left = jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?>;
        var long_filmstrip_cont_right = Math.abs(jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?>) + bwg_filmstrip_width;
        if (bwg_filmstrip_width > bwg_filmstrip_thumbnails_width) {
          return;
        }
        if (image_left < Math.abs(long_filmstrip_cont_left)) {
          jQuery(".bwg_filmstrip_thumbnails").animate({
            <?php echo $left_or_top; ?>: -image_left
          }, {
            duration: 500,
            complete: function () { bwg_filmstrip_arrows(); }
          });
        }
        else if (image_right > long_filmstrip_cont_right) {
          jQuery(".bwg_filmstrip_thumbnails").animate({
            <?php echo $left_or_top; ?>: -(image_right - bwg_filmstrip_width)
          }, {
            duration: 500,
            complete: function () { bwg_filmstrip_arrows(); }
          });
        }
      }
      /* Show/hide filmstrip arrows.*/
      function bwg_filmstrip_arrows() {
        if (jQuery(".bwg_filmstrip_thumbnails").<?php echo $width_or_height; ?>() < jQuery(".bwg_filmstrip").<?php echo $width_or_height; ?>()) {
          jQuery(".bwg_filmstrip_left").hide();
          jQuery(".bwg_filmstrip_right").hide();
        }
        else {
          jQuery(".bwg_filmstrip_left").show();
          jQuery(".bwg_filmstrip_right").show();
        }
      }
      function bwg_testBrowser_cssTransitions() {
        return bwg_testDom('Transition');
      }
      function bwg_testBrowser_cssTransforms3d() {
        return bwg_testDom('Perspective');
      }
      function bwg_testDom(prop) {
        /* Browser vendor CSS prefixes.*/
        var browserVendors = ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'];
        /* Browser vendor DOM prefixes.*/
        var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
        var i = domPrefixes.length;
        while (i--) {
          if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
            return true;
          }
        }
        return false;
      }
      function bwg_cube(tz, ntx, nty, nrx, nry, wrx, wry, current_image_class, next_image_class, direction) {
        /* If browser does not support 3d transforms/CSS transitions.*/
        if (!bwg_testBrowser_cssTransitions()) {
          return bwg_fallback(current_image_class, next_image_class, direction);
        }
        if (!bwg_testBrowser_cssTransforms3d()) {
          return bwg_fallback3d(current_image_class, next_image_class, direction);
        }
        bwg_trans_in_progress = true;
        /* Set active thumbnail.*/
        jQuery(".bwg_filmstrip_thumbnail").removeClass("bwg_thumb_active").addClass("bwg_thumb_deactive");
        jQuery("#bwg_filmstrip_thumbnail_" + bwg_current_key).removeClass("bwg_thumb_deactive").addClass("bwg_thumb_active");
        jQuery(".bwg_slide_bg").css('perspective', 1000);
        jQuery(current_image_class).css({
          transform : 'translateZ(' + tz + 'px)',
          backfaceVisibility : 'hidden'
        });
        jQuery(next_image_class).css({
          opacity : 1,
          filter: 'Alpha(opacity=100)',
          backfaceVisibility : 'hidden',
          transform : 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY('+ nry +'deg) rotateX('+ nrx +'deg)'
        });
        jQuery(".bwg_slider").css({
          transform: 'translateZ(-' + tz + 'px)',
          transformStyle: 'preserve-3d'
        });
        /* Execution steps.*/
        setTimeout(function () {
          jQuery(".bwg_slider").css({
            transition: 'all ' + bwg_transition_duration + 'ms ease-in-out',
            transform: 'translateZ(-' + tz + 'px) rotateX('+ wrx +'deg) rotateY('+ wry +'deg)'
          });
        }, 20);
        /* After transition.*/
        jQuery(".bwg_slider").one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(bwg_after_trans));
        function bwg_after_trans() {
          jQuery(current_image_class).removeAttr('style');
          jQuery(next_image_class).removeAttr('style');
          jQuery(".bwg_slider").removeAttr('style');
          jQuery(current_image_class).css({'opacity' : 0, filter: 'Alpha(opacity=0)', 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, filter: 'Alpha(opacity=100)', 'z-index' : 2});
          
          bwg_trans_in_progress = false;
          if (typeof event_stack !== 'undefined' && event_stack.length > 0) {
            key = event_stack[0].split("-");
            event_stack.shift();
            bwg_change_image(key[0], key[1], data, true);
          }
          bwg_change_watermark_container();
        }
      }
      function bwg_cubeH(current_image_class, next_image_class, direction) {
        /* Set to half of image width.*/
        var dimension = jQuery(current_image_class).width() / 2;
        if (direction == 'right') {
          bwg_cube(dimension, dimension, 0, 0, 90, 0, -90, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
          bwg_cube(dimension, -dimension, 0, 0, -90, 0, 90, current_image_class, next_image_class, direction);
        }
      }
      function bwg_cubeV(current_image_class, next_image_class, direction) {
        /* Set to half of image height.*/
        var dimension = jQuery(current_image_class).height() / 2;
        /* If next slide.*/
        if (direction == 'right') {
          bwg_cube(dimension, 0, -dimension, 90, 0, -90, 0, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
          bwg_cube(dimension, 0, dimension, -90, 0, 90, 0, current_image_class, next_image_class, direction);
        }
      }
      /* For browsers that does not support transitions.*/
      function bwg_fallback(current_image_class, next_image_class, direction) {
        bwg_fade(current_image_class, next_image_class, direction);
      }
      /* For browsers that support transitions, but not 3d transforms (only used if primary transition makes use of 3d-transforms).*/
      function bwg_fallback3d(current_image_class, next_image_class, direction) {
        bwg_sliceV(current_image_class, next_image_class, direction);
      }
      function bwg_none(current_image_class, next_image_class, direction) {
        jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
        jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
        /* Set active thumbnail.*/
        jQuery(".bwg_filmstrip_thumbnail").removeClass("bwg_thumb_active").addClass("bwg_thumb_deactive");
        jQuery("#bwg_filmstrip_thumbnail_" + bwg_current_key).removeClass("bwg_thumb_deactive").addClass("bwg_thumb_active");
      }
      function bwg_fade(current_image_class, next_image_class, direction) {
        /* Set active thumbnail.*/
        jQuery(".bwg_filmstrip_thumbnail").removeClass("bwg_thumb_active").addClass("bwg_thumb_deactive");
        jQuery("#bwg_filmstrip_thumbnail_" + bwg_current_key).removeClass("bwg_thumb_deactive").addClass("bwg_thumb_active");
        if (bwg_testBrowser_cssTransitions()) {
          jQuery(next_image_class).css('transition', 'opacity ' + bwg_transition_duration + 'ms linear');
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
          bwg_change_watermark_container();
        }
        else {
          jQuery(current_image_class).animate({'opacity' : 0, 'z-index' : 1}, bwg_transition_duration);
          jQuery(next_image_class).animate({
              'opacity' : 1,
              'z-index': 2
            }, {
              duration: bwg_transition_duration,
              complete: function () { bwg_change_watermark_container(); }
            });
          /* For IE.*/
          jQuery(current_image_class).fadeTo(bwg_transition_duration, 0);
          jQuery(next_image_class).fadeTo(bwg_transition_duration, 1);
        }
      }
      function bwg_grid(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction) {
        /* If browser does not support CSS transitions.*/
        if (!bwg_testBrowser_cssTransitions()) {
          return bwg_fallback(current_image_class, next_image_class, direction);
        }
        bwg_trans_in_progress = true;
        /* Set active thumbnail.*/
        jQuery(".bwg_filmstrip_thumbnail").removeClass("bwg_thumb_active").addClass("bwg_thumb_deactive");
        jQuery("#bwg_filmstrip_thumbnail_" + bwg_current_key).removeClass("bwg_thumb_deactive").addClass("bwg_thumb_active");
        /* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
        var count = (bwg_transition_duration) / (cols + rows);
        /* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
        function bwg_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {
          var delay = (c + r) * count;
          /* Return a gridlet elem with styles for specific transition.*/
          return jQuery('<div class="bwg_gridlet" />').css({
            width : width,
            height : height,
            top : top,
            left : left,
            backgroundImage : 'url("' + src + '")',
            backgroundColor: jQuery(".spider_popup_wrap").css("background-color"),
            /*backgroundColor: 'rgba(0, 0, 0, 0)',*/
            backgroundRepeat: 'no-repeat',
            backgroundPosition : img_left + 'px ' + img_top + 'px',
            backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
            transition : 'all ' + bwg_transition_duration + 'ms ease-in-out ' + delay + 'ms',
            transform : 'none'
          });
        }
        /* Get the current slide's image.*/
        var cur_img = jQuery(current_image_class).find('img');
        /* Create a grid to hold the gridlets.*/
        var grid = jQuery('<div />').addClass('bwg_grid');
        /* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
        jQuery(current_image_class).prepend(grid);
        /* Vars to calculate positioning/size of gridlets.*/
        var cont = jQuery(".bwg_slide_bg");
        var imgWidth = cur_img.width();
        var imgHeight = cur_img.height();
        var contWidth = cont.width(),
            contHeight = cont.height(),
            imgSrc = cur_img.attr('src'),/*.replace('/thumb', ''),*/
            colWidth = Math.floor(contWidth / cols),
            rowHeight = Math.floor(contHeight / rows),
            colRemainder = contWidth - (cols * colWidth),
            colAdd = Math.ceil(colRemainder / cols),
            rowRemainder = contHeight - (rows * rowHeight),
            rowAdd = Math.ceil(rowRemainder / rows),
            leftDist = 0,
            img_leftDist = Math.ceil((jQuery(".bwg_slide_bg").width() - cur_img.width()) / 2);
        /* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
        tx = tx === 'auto' ? contWidth : tx;
        tx = tx === 'min-auto' ? - contWidth : tx;
        ty = ty === 'auto' ? contHeight : ty;
        ty = ty === 'min-auto' ? - contHeight : ty;
        /* Loop through cols.*/
        for (var i = 0; i < cols; i++) {
          var topDist = 0,
              img_topDst = Math.floor((jQuery(".bwg_slide_bg").height() - cur_img.height()) / 2),
              newColWidth = colWidth;
          /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
          if (colRemainder > 0) {
            var add = colRemainder >= colAdd ? colAdd : colRemainder;
            newColWidth += add;
            colRemainder -= add;
          }
          /* Nested loop to create row gridlets for each col.*/
          for (var j = 0; j < rows; j++)  {
            var newRowHeight = rowHeight,
                newRowRemainder = rowRemainder;
            /* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
            if (newRowRemainder > 0) {
              add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
              newRowHeight += add;
              newRowRemainder -= add;
            }
            /* Create & append gridlet to grid.*/
            grid.append(bwg_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
            topDist += newRowHeight;
            img_topDst -= newRowHeight;
          }
          img_leftDist -= newColWidth;
          leftDist += newColWidth;
        }
        /* Set event listener on last gridlet to finish transitioning.*/
        var last_gridlet = grid.children().last();
        /* Show grid & hide the image it replaces.*/
        grid.show();
        cur_img.css('opacity', 0);
        /* Add identifying classes to corner gridlets (useful if applying border radius).*/
        grid.children().first().addClass('rs-top-left');
        grid.children().last().addClass('rs-bottom-right');
        grid.children().eq(rows - 1).addClass('rs-bottom-left');
        grid.children().eq(- rows).addClass('rs-top-right');
        /* Execution steps.*/
        setTimeout(function () {
          grid.children().css({
            opacity: op,
            transform: 'rotate('+ ro +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
          });
        }, 1);
        jQuery(next_image_class).css('opacity', 1);
        /* After transition.*/
        jQuery(last_gridlet).one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(bwg_after_trans));
        function bwg_after_trans() {
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
          cur_img.css('opacity', 1);
          grid.remove();
          bwg_trans_in_progress = false;
          if (typeof event_stack !== 'undefined' && event_stack.length > 0) {
            key = event_stack[0].split("-");
            event_stack.shift();
            bwg_change_image(key[0], key[1], data, true);
          }
          bwg_change_watermark_container();
        }
      }
      function bwg_sliceH(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateX = 'min-auto';
        }
        else if (direction == 'left') {
          var translateX = 'auto';
        }
        bwg_grid(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function bwg_sliceV(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateY = 'min-auto';
        }
        else if (direction == 'left') {
          var translateY = 'auto';
        }
        bwg_grid(10, 1, 0, 0, translateY, 1, 0, current_image_class, next_image_class, direction);
      }
      function bwg_slideV(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateY = 'auto';
        }
        else if (direction == 'left') {
          var translateY = 'min-auto';
        }
        bwg_grid(1, 1, 0, 0, translateY, 1, 1, current_image_class, next_image_class, direction);
      }
      function bwg_slideH(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateX = 'min-auto';
        }
        else if (direction == 'left') {
          var translateX = 'auto';
        }
        bwg_grid(1, 1, 0, translateX, 0, 1, 1, current_image_class, next_image_class, direction);
      }
      function bwg_scaleOut(current_image_class, next_image_class, direction) {
        bwg_grid(1, 1, 0, 0, 0, 1.5, 0, current_image_class, next_image_class, direction);
      }
      function bwg_scaleIn(current_image_class, next_image_class, direction) {
        bwg_grid(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction);
      }
      function bwg_blockScale(current_image_class, next_image_class, direction) {
        bwg_grid(8, 6, 0, 0, 0, .6, 0, current_image_class, next_image_class, direction);
      }
      function bwg_kaleidoscope(current_image_class, next_image_class, direction) {
        bwg_grid(10, 8, 0, 0, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function bwg_fan(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var rotate = 45;
          var translateX = 100;
        }
        else if (direction == 'left') {
          var rotate = -45;
          var translateX = -100;
        }
        bwg_grid(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function bwg_blindV(current_image_class, next_image_class, direction) {
        bwg_grid(1, 8, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }
      function bwg_blindH(current_image_class, next_image_class, direction) {
        bwg_grid(10, 1, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }
      function bwg_random(current_image_class, next_image_class, direction) {
        var anims = ['sliceH', 'sliceV', 'slideH', 'slideV', 'scaleOut', 'scaleIn', 'blockScale', 'kaleidoscope', 'fan', 'blindH', 'blindV'];
        /* Pick a random transition from the anims array.*/
        this["bwg_" + anims[Math.floor(Math.random() * anims.length)]](current_image_class, next_image_class, direction);
      }
	  
	  
	  
      function bwg_change_image(current_key, key, data, from_effect) {
        /* Pause videos.*/
        jQuery("#bwg_image_container").find("iframe").each(function () {
          jQuery(this)[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
          jQuery(this)[0].contentWindow.postMessage('{ "method": "pause" }', "*");
        });
        if (typeof data[key] != 'undefined' && typeof data[current_key] != 'undefined') {
          if (jQuery('.bwg_ctrl_btn').hasClass('fa-pause')) {
            bwg_play();
          }
          if (!from_effect) {
            /* Change image key.*/
            jQuery("#bwg_current_image_key").val(key);
            /*if (current_key == '-1') {
              current_key = jQuery(".bwg_thumb_active").children("img").attr("image_key");
            }*/
          }
          if (bwg_trans_in_progress) {
            event_stack.push(current_key + '-' + key);
            return;
          }
          var direction = 'right';
          if (bwg_current_key > key) {
            var direction = 'left';
          }
          else if (bwg_current_key == key) {
            return;
          }
          jQuery("#spider_popup_left").hover().css({"display": "inline"});
          jQuery("#spider_popup_right").hover().css({"display": "inline"});
          /* Hide previous/next buttons on first/last images.*/
          if (key == 0) {
            jQuery("#spider_popup_left").hover().css({"display": "none"});
          }
          else if (key == (data.length - 1)) {
            jQuery("#spider_popup_right").hover().css({"display": "none"});
          }
          /* Set filmstrip initial position.*/
          jQuery(".bwg_watermark").css({display: 'none'});
          /* Set active thumbnail position.*/
          bwg_current_filmstrip_pos = key * (jQuery(".bwg_filmstrip_thumbnail").<?php echo $width_or_height; ?>() + 2 + 2 * <?php echo $theme_row->lightbox_filmstrip_thumb_border_width; ?>);
          bwg_current_key = key;
          /* Change hash.*/
          window.location.hash = "bwg<?php echo $gallery_id; ?>/" + data[key]["id"];
          /* Change image id for rating.*/
          <?php if ($popup_enable_rate) { ?>
          jQuery("#bwg_rate_form input[name='image_id']").val(data[key]["id"]);
          jQuery("#bwg_star").attr("data-score", data[key]["avg_rating"]);
          jQuery("#bwg_star").removeAttr("title");
          bwg_rating(data[key]["rate"], data[key]["rate_count"], data[key]["avg_rating"], key);
          <?php } ?>
          /* Increase image hit counter.*/
          spider_set_input_value('rate_ajax_task', 'save_hit_count');
          spider_rate_ajax_save('bwg_rate_form');
          jQuery(".bwg_image_hits span").html(++data[key]["hit_count"]);
          /* Change image id.*/
          jQuery("#bwg_popup_image").attr('image_id', data[key]["id"]);
          /* Change image title, description.*/
          jQuery(".bwg_image_title").html(jQuery('<div />').html(data[key]["alt"]).text());
          jQuery(".bwg_image_description").html(jQuery('<div />').html(data[key]["description"]).text());
          if (jQuery(".bwg_image_info_container1").css("display") != 'none') {
            jQuery(".bwg_image_info_container1").css("display", "table-cell");
          }
          else {
            jQuery(".bwg_image_info_container1").css("display", "none");
          }
          /* Change image rating.*/
          if (jQuery(".bwg_image_rate_container1").css("display") != 'none') {
            jQuery(".bwg_image_rate_container1").css("display", "table-cell");
          }
          else {
            jQuery(".bwg_image_rate_container1").css("display", "none");
          }
          var current_image_class = jQuery(".bwg_popup_image_spun").css("zIndex") == 2 ? ".bwg_popup_image_spun" : ".bwg_popup_image_second_spun";
          var next_image_class = current_image_class == ".bwg_popup_image_second_spun" ? ".bwg_popup_image_spun" : ".bwg_popup_image_second_spun";
          
          var is_video = data[key]['filetype'] == "YOUTUBE" || data[key]['filetype'] == "VIMEO";
          var cur_height = jQuery(current_image_class).height();
          var cur_width = jQuery(current_image_class).width();
          var innhtml = '<span class="bwg_popup_image_spun1" style="display: table; width: inherit; height: inherit;"><span class="bwg_popup_image_spun2" style="display: table-cell; vertical-align: middle; text-align: center;">';
          if (!is_video) {
            innhtml += '<img style="max-height: ' + cur_height + 'px; max-width: ' + cur_width + 'px;" class="bwg_popup_image" src="<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/'; ?>' + data[key]["image_url"] + '" alt="' + data[key]["alt"] + '" />';
          }
          else {
            innhtml += '<span style="height: ' + cur_height + 'px; width: ' + cur_width + 'px;" class="bwg_popup_video"><iframe class="bwg_video_frame" src="'  + (data[key]['filetype'] == "YOUTUBE" ? "//www.youtube.com/embed/" + data[key]['filename'] + "?enablejsapi=1" : "//player.vimeo.com/video/" + data[key]['filename'] + "?api=1") + '" frameborder="0" allowfullscreen style="width:100%; height:100%;"></iframe></span>';
          }
          innhtml += '</span></span>';
          jQuery(next_image_class).html(innhtml);
          
          function bwg_afterload() {
            <?php
            if ($option_row->preload_images) {
              echo 'bwg_preload_images(key);';
            }
            ?>
            bwg_<?php echo $image_effect; ?>(current_image_class, next_image_class, direction);
            jQuery("#bwg_fullsize_image").attr("href", "<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/'; ?>" + data[key]['image_url']);
            jQuery("#bwg_download").attr("href", "<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/'; ?>" + data[key]['image_url']);
            jQuery("#bwg_download").attr("download", data[key]['image_url']);
            /* Change image social networks urls.*/
            var bwg_share_url = encodeURIComponent("<?php echo JURI::root().array_to_url(array('view' => 'Share', 'curr_url' =>   bgw_url_encode($current_url) , 'image_id' => '')); ?>") + data[key]['id'] + encodeURIComponent('#bwg<?php echo $gallery_id; ?>/') + data[key]['id'];
            if (data[key]['filetype'] == "YOUTUBE" || data[key]['filetype'] == "VIMEO") {
              var bwg_share_image_url = encodeURIComponent(data[key]['thumb_url']);
            }
            else {
              var bwg_share_image_url = "<?php echo urlencode(JURI::root()  . WD_BWG_UPLOAD_DIR .'/'); ?>" + data[key]['image_url'];
            }
            jQuery("#bwg_facebook_a").attr("href", "https://www.facebook.com/sharer/sharer.php?sdk=joey&u="+bwg_share_url);
            jQuery("#bwg_twitter_a").attr("href", "https://twitter.com/share?url=" + bwg_share_url);
            jQuery("#bwg_google_a").attr("href", "https://plus.google.com/share?url=" + bwg_share_url);
            jQuery("#bwg_pinterest_a").attr("href", "http://pinterest.com/pin/create/button/?s=100&url=" + bwg_share_url + "&media=" + bwg_share_image_url + "&description=" + data[key]['description']);
            jQuery("#bwg_tumblr_a").attr("href", "https://www.tumblr.com/share/photo?source=" + bwg_share_image_url + "&caption=" + data[key]['alt'] + "&clickthru=" + bwg_share_url);
            /* Load comments.*/
            if (jQuery(".bwg_comment_container").hasClass("bwg_open")) {
              if (data[key]["comment_count"] == 0) {
                jQuery("#bwg_added_comments").hide();
              }
              else {
                jQuery("#bwg_added_comments").show();
                spider_set_input_value('ajax_task', 'display');
                spider_set_input_value('image_id', jQuery('#bwg_popup_image').attr('image_id'));
                spider_ajax_save('bwg_comment_form');
              }
            }
            /* Update custom scroll.*/
            if (typeof jQuery().mCustomScrollbar !== 'undefined' && jQuery.isFunction(jQuery().mCustomScrollbar)) {
              jQuery(".bwg_comments").mCustomScrollbar({
                advanced:{
                  updateOnContentResize: true
                }
              });
            }
            jQuery(".mCSB_scrollTools").hide();
            <?php
            if ($enable_image_filmstrip) {
              ?>
              bwg_move_filmstrip();
              <?php
            }
            ?>
          }          
          
          if (!is_video) {
            var cur_img = jQuery(next_image_class).find('img');
            cur_img.one('load', function() {
              bwg_afterload();
            }).each(function() {
              if(this.complete) jQuery(this).load();
            });
          }
          else {
            bwg_afterload();
          }
        }
      }      
      jQuery(document).on('keydown', function (e) {
        if (jQuery("#bwg_name").is(":focus") || jQuery("#bwg_email").is(":focus") || jQuery("#bwg_comment").is(":focus") || jQuery("#bwg_captcha_input").is(":focus")) {
          return;
        }
        if (e.keyCode === 39) { /* Right arrow.*/
          bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), parseInt(jQuery('#bwg_current_image_key').val()) + 1, data)
        }
        else if (e.keyCode === 37) { /* Left arrow.*/
          bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), parseInt(jQuery('#bwg_current_image_key').val()) - 1, data)
        }
        else if (e.keyCode === 27) { /* Esc.*/
          spider_destroypopup(1000);
        }
        else if (e.keyCode === 32) { /* Space.*/
          jQuery(".bwg_play_pause").trigger('click');
        }
        if (e.preventDefault) {
          e.preventDefault();
        }
        else {
          e.returnValue = false;
        }
      });
      function bwg_preload_images(key) {
        count = <?php echo (int) $option_row->preload_images_count / 2; ?>;
        if (count != 0) {
          for (var i = key - count; i < key + count; i++) {
            jQuery("<img/>").attr("src", (typeof data[i] != "undefined" && !(data[i]['filetype'] == "YOUTUBE" || data[i]['filetype'] == "VIMEO")) ? '<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/'; ?>' + jQuery('<div />').html(data[i]["image_url"]).text() : "");
          }
        }
        else {
          for (var i = 0; i < data.length; i++) {
            jQuery("<img/>").attr("src", (typeof data[i] != "undefined" && !(data[i]['filetype'] == "YOUTUBE" || data[i]['filetype'] == "VIMEO")) ? '<?php echo JURI::root()  . WD_BWG_UPLOAD_DIR .'/'; ?>' + jQuery('<div />').html(data[i]["image_url"]).text() : "");
          }
        }
      }
      function bwg_popup_resize() {
        var comment_container_width = 0;
        if (jQuery(".bwg_comment_container").hasClass("bwg_open")) {
          comment_container_width = <?php echo $theme_row->lightbox_comment_width; ?>;
        }
        if (comment_container_width > jQuery(window).width()) {
          comment_container_width = jQuery(window).width();
          jQuery(".bwg_comment_container").css({
            width: comment_container_width
          });
          jQuery(".spider_popup_close_fullscreen").hide();
        }
        else {
          jQuery(".spider_popup_close_fullscreen").show();
        }
        if (jQuery(window).height() > <?php echo $image_height; ?> && <?php echo $open_with_fullscreen; ?> != 1 ) {
          jQuery("#spider_popup_wrap").css({
            height: <?php echo $image_height; ?>,
            top: '50%',
            marginTop: -<?php echo $image_height / 2; ?>,
            zIndex: 100000
          });
          jQuery(".bwg_image_container").css({height: (<?php echo $image_height - ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>)});
          jQuery(".bwg_popup_image").css({
            maxHeight: <?php echo $image_height - ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
          });
          jQuery(".bwg_popup_video").css({
            height: <?php echo $image_height - ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
          });
          <?php if ($filmstrip_direction == 'vertical') { ?>
          jQuery(".bwg_filmstrip_container").css({height: <?php echo $image_height; ?>});
          jQuery(".bwg_filmstrip").css({height: (<?php echo $image_height; ?> - 40)});
          <?php } ?>
          bwg_popup_current_height = <?php echo $image_height; ?>;
        }
        else {
          jQuery("#spider_popup_wrap").css({
            height: jQuery(window).height(),
            top: 0,
            marginTop: 0,
            zIndex: 100000
          });
          jQuery(".bwg_image_container").css({height: (jQuery(window).height() - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>)});
          jQuery(".bwg_popup_image").css({
            maxHeight: jQuery(window).height() - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
          });
          jQuery(".bwg_popup_video").css({
            height: jQuery(window).height() - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
          });
          <?php if ($filmstrip_direction == 'vertical') { ?>
          jQuery(".bwg_filmstrip_container").css({height: (jQuery(window).height())});
          jQuery(".bwg_filmstrip").css({height: (jQuery(window).height() - 40)});
          <?php } ?>
          bwg_popup_current_height = jQuery(window).height();
        }
        if (jQuery(window).width() >= <?php echo $image_width; ?> && <?php echo $open_with_fullscreen; ?> != 1 ) {  
          jQuery("#spider_popup_wrap").css({
            width: <?php echo $image_width; ?>,
            left: '50%',
            marginLeft: -<?php echo $image_width / 2; ?>,
            zIndex: 100000
          });
          jQuery(".bwg_image_wrap").css({width: <?php echo $image_width; ?> - comment_container_width});
          jQuery(".bwg_image_container").css({width: (<?php echo $image_width - ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?> - comment_container_width)});
          jQuery(".bwg_popup_image").css({
            maxWidth: <?php echo $image_width - ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?> - comment_container_width
          });
          jQuery(".bwg_popup_video").css({
            width: <?php echo $image_width - ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?> - comment_container_width
          });
          <?php if ($filmstrip_direction == 'horizontal') { ?>
          jQuery(".bwg_filmstrip_container").css({width: <?php echo $image_width; ?> - comment_container_width});
          jQuery(".bwg_filmstrip").css({width: (<?php echo $image_width; ?>  - comment_container_width- 40)});
          <?php } ?>
          bwg_popup_current_width = <?php echo $image_width; ?>;
        }
        else {
          jQuery("#spider_popup_wrap").css({
            width: jQuery(window).width(),
            left: 0,
            marginLeft: 0,
            zIndex: 100000
          });
          jQuery(".bwg_image_wrap").css({width: (jQuery(window).width() - comment_container_width)});
          jQuery(".bwg_image_container").css({width: (jQuery(window).width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?> - comment_container_width)});
          jQuery(".bwg_popup_image").css({
            maxWidth: jQuery(window).width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?> - comment_container_width
          });
          jQuery(".bwg_popup_video").css({
            width: jQuery(window).width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?> - comment_container_width
          });
          <?php if ($filmstrip_direction == 'horizontal') { ?>
          jQuery(".bwg_filmstrip_container").css({width: (jQuery(window).width() - comment_container_width)});
          jQuery(".bwg_filmstrip").css({width: (jQuery(window).width() - comment_container_width - 40)});
          <?php } ?>
          bwg_popup_current_width = jQuery(window).width();
        }
        /* Set watermark container size.*/
        bwg_change_watermark_container();
        if (((jQuery(window).height() > <?php echo $image_height - 2 * $theme_row->lightbox_close_btn_top; ?>) && (jQuery(window).width() >= <?php echo $image_width - 2 * $theme_row->lightbox_close_btn_right; ?>)) && (<?php echo $open_with_fullscreen; ?> != 1)) {
          jQuery(".spider_popup_close_fullscreen").attr("class", "spider_popup_close");
        }
        else {
          if ((jQuery("#spider_popup_wrap").width() < jQuery(window).width()) && (jQuery("#spider_popup_wrap").height() < jQuery(window).height())) {
            jQuery(".spider_popup_close").attr("class", "bwg_ctrl_btn spider_popup_close_fullscreen");
          }
        }
      }
      jQuery(window).resize(function() {
        if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen) && !jQuery.fullscreen.isFullScreen()) {
          bwg_popup_resize();
        }
      });
      /* Popup current width/height.*/
      var bwg_popup_current_width = <?php echo $image_width; ?>;
      var bwg_popup_current_height = <?php echo $image_height; ?>;
      /* Open/close comments.*/
      function bwg_comment() {
        jQuery(".bwg_watermark").css({display: 'none'});
        if (jQuery(".bwg_comment_container").hasClass("bwg_open")) {
          /* Close comment.*/
          var border_width = parseInt(jQuery(".bwg_comment_container").css('borderRightWidth'));
          if (!border_width) {
            border_width = 0;
          }
          jQuery(".bwg_comment_container").animate({<?php echo $theme_row->lightbox_comment_pos; ?>: -jQuery(".bwg_comment_container").width() - border_width}, 500);
          jQuery(".bwg_image_wrap").animate({
            <?php echo $theme_row->lightbox_comment_pos; ?>: 0,
            width: jQuery("#spider_popup_wrap").width()
          }, 500);
          jQuery(".bwg_image_container").animate({
            width: jQuery("#spider_popup_wrap").width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>}, 500);
          jQuery(".bwg_popup_image").animate({
              maxWidth: jQuery("#spider_popup_wrap").width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>
            }, {
              duration: 500,
              complete: function () { bwg_change_watermark_container(); }
            });
          jQuery(".bwg_popup_video").animate({
              width: jQuery("#spider_popup_wrap").width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>
            }, {
              duration: 500,
              complete: function () { bwg_change_watermark_container(); }
            });
          jQuery(".bwg_filmstrip_container").animate({<?php echo $width_or_height; ?>: jQuery(".spider_popup_wrap").<?php echo $width_or_height; ?>()}, 500);
          jQuery(".bwg_filmstrip").animate({<?php echo $width_or_height; ?>: jQuery(".spider_popup_wrap").<?php echo $width_or_height; ?>() - 40}, 500);
          /* Set filmstrip initial position.*/
          bwg_set_filmstrip_pos(jQuery(".spider_popup_wrap").width() - 40);
          jQuery(".bwg_comment_container").attr("class", "bwg_comment_container bwg_close");
          jQuery(".bwg_comment").attr("title", "<?php echo JText::_('SHOW_COMMENTS'); ?>");
          jQuery(".spider_popup_close_fullscreen").show();
        }
        else {
          /* Open comment.*/
          var comment_container_width = <?php echo $theme_row->lightbox_comment_width; ?>;
          if (comment_container_width > jQuery(window).width()) {
            comment_container_width = jQuery(window).width();
            jQuery(".bwg_comment_container").css({
              width: comment_container_width
            });
            jQuery(".spider_popup_close_fullscreen").hide();
            if (jQuery(".bwg_ctrl_btn").hasClass("fa-pause")) {
              var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
              jQuery(".bwg_play_pause").trigger(isMobile ? 'touchend' : 'click');
            }
          }
          else {
            jQuery(".spider_popup_close_fullscreen").show();
          }
          jQuery(".bwg_comment_container").animate({<?php echo $theme_row->lightbox_comment_pos; ?>: 0}, 500);
          jQuery(".bwg_image_wrap").animate({
            <?php echo $theme_row->lightbox_comment_pos; ?>: jQuery(".bwg_comment_container").width(),
            width: jQuery("#spider_popup_wrap").width() - jQuery(".bwg_comment_container").width()}, 500);
          jQuery(".bwg_image_container").animate({
            width: jQuery("#spider_popup_wrap").width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?> - jQuery(".bwg_comment_container").width()}, 500);
          jQuery(".bwg_popup_image").animate({
              maxWidth: jQuery("#spider_popup_wrap").width() - jQuery(".bwg_comment_container").width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>
            }, {
              duration: 500,
              complete: function () { bwg_change_watermark_container(); }
            });
          jQuery(".bwg_popup_video").animate({
              width: jQuery("#spider_popup_wrap").width() - jQuery(".bwg_comment_container").width() - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>
            }, {
              duration: 500,
              complete: function () { bwg_change_watermark_container(); }
            });
          jQuery(".bwg_filmstrip_container").css({<?php echo $width_or_height; ?>: jQuery("#spider_popup_wrap").<?php echo $width_or_height; ?>() - <?php echo ($filmstrip_direction == 'vertical' ? 0: 'jQuery(".bwg_comment_container").width()'); ?>});
          jQuery(".bwg_filmstrip").animate({<?php echo $width_or_height; ?>: jQuery(".bwg_filmstrip_container").<?php echo $width_or_height; ?>() - 40}, 500);
          /* Set filmstrip initial position.*/
          bwg_set_filmstrip_pos(jQuery(".bwg_filmstrip_container").<?php echo $width_or_height; ?>() - 40);
          jQuery(".bwg_comment_container").attr("class", "bwg_comment_container bwg_open");
          jQuery(".bwg_comment").attr("title", "<?php echo JText::_('HIDE_COMMENTS'); ?>");
          /* Load comments.*/
          var cur_image_key = parseInt(jQuery("#bwg_current_image_key").val());
          if (data[cur_image_key]["comment_count"] != 0) {
            jQuery("#bwg_added_comments").show();
            spider_set_input_value('ajax_task', 'display');
            spider_set_input_value('image_id', jQuery('#bwg_popup_image').attr('image_id'));
            spider_ajax_save('bwg_comment_form');
          }
        }
      }
      function bwg_reset_zoom() {
        var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        var viewportmeta = document.querySelector('meta[name="viewport"]');
        if (isMobile && viewportmeta) {
          viewportmeta.content = 'width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0';
        }
      }
      jQuery(document).ready(function () {
        /* Increase image hit counter.*/
        spider_set_input_value('rate_ajax_task', 'save_hit_count');
        spider_rate_ajax_save('bwg_rate_form');
        jQuery(".bwg_image_hits span").html(++data["<?php echo $current_image_key; ?>"]["hit_count"]);
        var bwg_hash = window.location.hash;
        if (!bwg_hash || bwg_hash.indexOf("bwg") == "-1") {
          window.location.hash = "bwg<?php echo $gallery_id; ?>/<?php echo $current_image_id; ?>";
        }
      	<?php
        if ($image_right_click) {
          ?>
          /* Disable right click.*/
          jQuery(".bwg_image_wrap").bind("contextmenu", function (e) {
            return false;
          });
          <?php
        }
        ?>
        if (typeof jQuery().swiperight !== 'undefined' && jQuery.isFunction(jQuery().swiperight)) {
          jQuery('#spider_popup_wrap').swiperight(function () {
            bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), parseInt(jQuery('#bwg_current_image_key').val()) - 1, data)
            return false;
          });
        }
        if (typeof jQuery().swipeleft !== 'undefined' && jQuery.isFunction(jQuery().swipeleft)) {
          jQuery('#spider_popup_wrap').swipeleft(function () {
            bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), parseInt(jQuery('#bwg_current_image_key').val()) + 1, data);
            return false;
          });
        }

        bwg_reset_zoom();
        var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        var bwg_click = isMobile ? 'touchend' : 'click';
        jQuery("#spider_popup_left").on(bwg_click, function () {
          bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), parseInt(jQuery('#bwg_current_image_key').val()) - 1, data);
          return false;
        });
        jQuery("#spider_popup_right").on(bwg_click, function () {
          bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), parseInt(jQuery('#bwg_current_image_key').val()) + 1, data);
          return false;
        });
        if (navigator.appVersion.indexOf("MSIE 10") != -1 || navigator.appVersion.indexOf("MSIE 9") != -1) {
          setTimeout(function () {
            bwg_popup_resize();
          }, 1);
        }
        else {
          bwg_popup_resize();
        }
        jQuery(".bwg_watermark").css({display: 'none'});
        setTimeout(function () {
          bwg_change_watermark_container();
        }, 500);
        /* If browser doesn't support Fullscreen API.*/
        if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen) && !jQuery.fullscreen.isNativelySupported()) {
          jQuery(".bwg_fullscreen").hide();
        }
        /* Set image container height.*/
        <?php if ($filmstrip_direction == 'horizontal') { ?>
          jQuery(".bwg_image_container").height(jQuery(".bwg_image_wrap").height() - <?php echo $image_filmstrip_height; ?>);
          jQuery(".bwg_image_container").width(jQuery(".bwg_image_wrap").width());
          <?php }
        else {
          ?>
          jQuery(".bwg_image_container").height(jQuery(".bwg_image_wrap").height());
          jQuery(".bwg_image_container").width(jQuery(".bwg_image_wrap").width() - <?php echo $image_filmstrip_width; ?>);
          <?php
        } ?>
        /* Change default scrollbar in comments.*/
        if (typeof jQuery().mCustomScrollbar !== 'undefined' && jQuery.isFunction(jQuery().mCustomScrollbar)) {
          jQuery(".bwg_comments").mCustomScrollbar({scrollInertia: 150});
        }
        var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel" /*FF doesn't recognize mousewheel as of FF3.x*/
        jQuery('.bwg_filmstrip').on(mousewheelevt, function(e) {
          var evt = window.event || e; /* Equalize event object.*/
          evt = evt.originalEvent ? evt.originalEvent : evt; /* Convert to originalEvent if possible.*/
          var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta; /* Check for detail first, because it is used by Opera and FF.*/
          var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
          if (delta > 0) {
            /* Scroll up.*/
            jQuery(".bwg_filmstrip_left").trigger(isMobile ? 'touchend' : 'click');
          }
          else {
            /* Scroll down.*/
            jQuery(".bwg_filmstrip_right").trigger(isMobile ? 'touchend' : 'click');
          }
        });
        jQuery(".bwg_filmstrip_right").on(bwg_click, function () {
          jQuery( ".bwg_filmstrip_thumbnails" ).stop(true, false);
          if (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> >= -(jQuery(".bwg_filmstrip_thumbnails").<?php echo $width_or_height; ?>() - jQuery(".bwg_filmstrip").<?php echo $width_or_height; ?>())) {
            jQuery(".bwg_filmstrip_left").css({opacity: 1, filter: "Alpha(opacity=100)"});
            if (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> < -(jQuery(".bwg_filmstrip_thumbnails").<?php echo $width_or_height; ?>() - jQuery(".bwg_filmstrip").<?php echo $width_or_height; ?>() - <?php echo $filmstrip_thumb_margin_hor + $image_filmstrip_width; ?>)) {
              jQuery(".bwg_filmstrip_thumbnails").animate({<?php echo $left_or_top; ?>: -(jQuery(".bwg_filmstrip_thumbnails").<?php echo $width_or_height; ?>() - jQuery(".bwg_filmstrip").<?php echo $width_or_height; ?>())}, 500, 'linear');
            }
            else {
              jQuery(".bwg_filmstrip_thumbnails").animate({<?php echo $left_or_top; ?>: (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> - <?php echo $filmstrip_thumb_margin_hor + $image_filmstrip_width; ?>)}, 500, 'linear');
            }
          }
          /* Disable right arrow.*/
          window.setTimeout(function(){
            if (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> == -(jQuery(".bwg_filmstrip_thumbnails").<?php echo $width_or_height; ?>() - jQuery(".bwg_filmstrip").<?php echo $width_or_height; ?>())) {
              jQuery(".bwg_filmstrip_right").css({opacity: 0.3, filter: "Alpha(opacity=30)"});
            }
          }, 500);
        });
        jQuery(".bwg_filmstrip_left").on(bwg_click, function () {
          jQuery( ".bwg_filmstrip_thumbnails" ).stop(true, false);
          if (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> < 0) {
            jQuery(".bwg_filmstrip_right").css({opacity: 1, filter: "Alpha(opacity=100)"});
            if (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> > - <?php echo $filmstrip_thumb_margin_hor + $image_filmstrip_width; ?>) {
              jQuery(".bwg_filmstrip_thumbnails").animate({<?php echo $left_or_top; ?>: 0}, 500, 'linear');
            }
            else {
              jQuery(".bwg_filmstrip_thumbnails").animate({<?php echo $left_or_top; ?>: (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> + <?php echo $image_filmstrip_width + $filmstrip_thumb_margin_hor; ?>)}, 500, 'linear');
            }
          }
          /* Disable left arrow.*/
          window.setTimeout(function(){
            if (jQuery(".bwg_filmstrip_thumbnails").position().<?php echo $left_or_top; ?> == 0) {
              jQuery(".bwg_filmstrip_left").css({opacity: 0.3, filter: "Alpha(opacity=30)"});
            }
          }, 500);
        });
        /* Set filmstrip initial position.*/
        bwg_set_filmstrip_pos(jQuery(".bwg_filmstrip").<?php echo $width_or_height; ?>());
        /* Show/hide image title/description.*/
        jQuery(".bwg_info").on(bwg_click, function() {
          if (jQuery(".bwg_image_info_container1").css("display") == 'none') {
            jQuery(".bwg_image_info_container1").css("display", "table-cell");
            jQuery(".bwg_info").attr("title", "<?php echo JText::_('HIDE_INFO'); ?>");
          }
          else {
            jQuery(".bwg_image_info_container1").css("display", "none");
            jQuery(".bwg_info").attr("title", "<?php echo JText::_('SHOW_INFO'); ?>");
          }
        });
        /* Show/hide image rating.*/
        jQuery(".bwg_rate").on(bwg_click, function() {
          if (jQuery(".bwg_image_rate_container1").css("display") == 'none') {
            jQuery(".bwg_image_rate_container1").css("display", "table-cell");
            jQuery(".bwg_rate").attr("title", "<?php echo JText::_('HIDE_RATING'); ?>");
          }
          else {
            jQuery(".bwg_image_rate_container1").css("display", "none");
            jQuery(".bwg_rate").attr("title", "<?php echo JText::_('SHOW_RATING'); ?>");
          }
        });
        /* Open/close comments.*/
        jQuery(".bwg_comment, .bwg_comments_close_btn").on(bwg_click, function() { bwg_comment()});
        /* Open/close control buttons.*/
        jQuery(".bwg_toggle_container").on(bwg_click, function () {
          var bwg_open_toggle_btn_class = "<?php echo ($theme_row->lightbox_ctrl_btn_pos == 'top') ? 'fa-angle-up' : 'fa-angle-down'; ?>";
          var bwg_close_toggle_btn_class = "<?php echo ($theme_row->lightbox_ctrl_btn_pos == 'top') ? 'fa-angle-down' : 'fa-angle-up'; ?>";
          if (jQuery(".bwg_toggle_container i").hasClass(bwg_open_toggle_btn_class)) {
            /* Close controll buttons.*/
            <?php
              if ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_info_pos == 'bottom') {
                ?>
                jQuery(".bwg_image_info").animate({bottom: 0}, 500);
                <?php
              }
              elseif ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_info_pos == 'top') {
                ?>
                jQuery(".bwg_image_info").animate({top: 0}, 500);
                <?php
              }
              if ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_rate_pos == 'bottom') {
                ?>
                jQuery(".bwg_image_rate").animate({bottom: 0}, 500);
                <?php
              }
              elseif ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_rate_pos == 'top') {
                ?>
                jQuery(".bwg_image_rate").animate({top: 0}, 500);
                <?php
              }
              if ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_hit_pos == 'bottom') {
                ?>
                jQuery(".bwg_image_hit").animate({bottom: 0}, 500);
                <?php
              }
              elseif ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_hit_pos == 'top') {
                ?>
                jQuery(".bwg_image_hit").animate({top: 0}, 500);
                <?php
              }
            ?>
            jQuery(".bwg_ctrl_btn_container").animate({<?php echo $theme_row->lightbox_ctrl_btn_pos; ?>: '-' + jQuery(".bwg_ctrl_btn_container").height()}, 500);
            jQuery(".bwg_toggle_container").animate({
                <?php echo $theme_row->lightbox_ctrl_btn_pos; ?>: 0
              }, {
                duration: 500,
                complete: function () { jQuery(".bwg_toggle_container i").attr("class", "bwg_toggle_btn fa " + bwg_close_toggle_btn_class) }
              });
          }
          else {
            /* Open controll buttons.*/
            <?php
              if ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_info_pos == 'bottom') {
                ?>
                jQuery(".bwg_image_info").animate({bottom: jQuery(".bwg_ctrl_btn_container").height()}, 500);
                <?php
              }
              elseif ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_info_pos == 'top') {
                ?>
                jQuery(".bwg_image_info").animate({top: jQuery(".bwg_ctrl_btn_container").height()}, 500);
                <?php
              }
              if ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_rate_pos == 'bottom') {
                ?>
                jQuery(".bwg_image_rate").animate({bottom: jQuery(".bwg_ctrl_btn_container").height()}, 500);
                <?php
              }
              elseif ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_rate_pos == 'top') {
                ?>
                jQuery(".bwg_image_rate").animate({top: jQuery(".bwg_ctrl_btn_container").height()}, 500);
                <?php
              }
              if ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'bottom') && $theme_row->lightbox_ctrl_btn_pos == 'bottom' && $theme_row->lightbox_hit_pos == 'bottom') {
                ?>
                jQuery(".bwg_image_hit").animate({bottom: jQuery(".bwg_ctrl_btn_container").height()}, 500);
                <?php
              }
              elseif ((!$enable_image_filmstrip || $theme_row->lightbox_filmstrip_pos != 'top') && $theme_row->lightbox_ctrl_btn_pos == 'top' && $theme_row->lightbox_hit_pos == 'top') {
                ?>
                jQuery(".bwg_image_hit").animate({top: jQuery(".bwg_ctrl_btn_container").height()}, 500);
                <?php
              }
            ?>
            jQuery(".bwg_ctrl_btn_container").animate({<?php echo $theme_row->lightbox_ctrl_btn_pos; ?>: 0}, 500);
            jQuery(".bwg_toggle_container").animate({
                <?php echo $theme_row->lightbox_ctrl_btn_pos; ?>: jQuery(".bwg_ctrl_btn_container").height()
              }, {
                duration: 500,
                complete: function () { jQuery(".bwg_toggle_container i").attr("class", "bwg_toggle_btn fa " + bwg_open_toggle_btn_class) }
              });
          }
        });
        /* Maximize/minimize.*/
        jQuery(".bwg_resize-full").on(bwg_click, function () {
          jQuery(".bwg_watermark").css({display: 'none'});
          var comment_container_width = 0;
          if (jQuery(".bwg_comment_container").hasClass("bwg_open")) {
            comment_container_width = jQuery(".bwg_comment_container").width();
          }
          if (jQuery(".bwg_resize-full").hasClass("fa-resize-small")) {
            if (jQuery(window).width() > <?php echo $image_width; ?>) {
              bwg_popup_current_width = <?php echo $image_width; ?>;
            }
            if (jQuery(window).height() > <?php echo $image_height; ?>) {
              bwg_popup_current_height = <?php echo $image_height; ?>;
            }
            /* Minimize.*/
            jQuery("#spider_popup_wrap").animate({
              width: bwg_popup_current_width,
              height: bwg_popup_current_height,
              left: '50%',
              top: '50%',
              marginLeft: -bwg_popup_current_width / 2,
              marginTop: -bwg_popup_current_height / 2,
              zIndex: 100000
            }, 500);
            jQuery(".bwg_image_wrap").animate({width: bwg_popup_current_width - comment_container_width}, 500);
            jQuery(".bwg_image_container").animate({height: bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>, width: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>}, 500);
			

			
			
			
            jQuery(".bwg_popup_image").animate({
                maxWidth: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
                maxHeight: bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
              }, {
                duration: 500,
                complete: function () {
                  bwg_change_watermark_container();
                  if ((jQuery("#spider_popup_wrap").width() < jQuery(window).width()) && (jQuery("#spider_popup_wrap").height() < jQuery(window).height())) {
                    jQuery(".spider_popup_close_fullscreen").attr("class", "spider_popup_close");
                  }
                }
              });
            jQuery(".bwg_popup_video").animate({
                width: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
                height: bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
              }, {
                duration: 500,
                complete: function () {
                  bwg_change_watermark_container();
                  if ((jQuery("#spider_popup_wrap").width() < jQuery(window).width()) && (jQuery("#spider_popup_wrap").height() < jQuery(window).height())) {
                    jQuery(".spider_popup_close_fullscreen").attr("class", "spider_popup_close");
                  }
                }
              });
            jQuery(".bwg_filmstrip_container").animate({<?php echo $width_or_height; ?>: bwg_popup_current_<?php echo $width_or_height; ?> - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?>}, 500);
            jQuery(".bwg_filmstrip").animate({<?php echo $width_or_height; ?>: bwg_popup_current_<?php echo $width_or_height; ?> - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?> - 40}, 500);
            /* Set filmstrip initial position.*/
            bwg_set_filmstrip_pos(bwg_popup_current_<?php echo $width_or_height; ?> - 40);
            jQuery(".bwg_resize-full").attr("class", "bwg_ctrl_btn bwg_resize-full fa fa-resize-full");
            jQuery(".bwg_resize-full").attr("title", "<?php echo JText::_('MAXIMIZE'); ?>");
          }
          else {
            bwg_popup_current_width = jQuery(window).width();
            bwg_popup_current_height = jQuery(window).height();
            /* Maximize.*/
            jQuery("#spider_popup_wrap").animate({
              width: jQuery(window).width(),
              height: jQuery(window).height(),
              left: 0,
              top: 0,
              margin: 0,
              zIndex: 100000
            }, 500);
            jQuery(".bwg_image_wrap").animate({width: (jQuery(window).width() - comment_container_width)}, 500);
            jQuery(".bwg_image_container").animate({height: (bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>), width: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>}, 500);
			
						
		
			
			
            jQuery(".bwg_popup_image").animate({
                maxWidth: jQuery(window).width() - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
                maxHeight: jQuery(window).height() - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
              }, {
                duration: 500,
                complete: function () { bwg_change_watermark_container(); }
              });
            jQuery(".bwg_popup_video").animate({
                width: jQuery(window).width() - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
                height: jQuery(window).height() - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
              }, {
                duration: 500,
                complete: function () { bwg_change_watermark_container(); }
              });
            jQuery(".bwg_filmstrip_container").animate({<?php echo $width_or_height; ?>: jQuery(window).<?php echo $width_or_height; ?>() - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?>}, 500);
            jQuery(".bwg_filmstrip").animate({<?php echo $width_or_height; ?>: jQuery(window).<?php echo $width_or_height; ?>() - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?> - 40}, 500);
            /* Set filmstrip initial position.*/
            bwg_set_filmstrip_pos(jQuery(window).<?php echo $width_or_height; ?>() - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?> - 40);
            jQuery(".bwg_resize-full").attr("class", "bwg_ctrl_btn bwg_resize-full fa fa-resize-small");
            jQuery(".bwg_resize-full").attr("title", "<?php echo JText::_('RESTORE'); ?>");
            jQuery(".spider_popup_close").attr("class", "bwg_ctrl_btn spider_popup_close_fullscreen");
          }
        });
        /* Fullscreen.*/
        jQuery(".bwg_fullscreen").on(bwg_click, function () {
          jQuery(".bwg_watermark").css({display: 'none'});
          var comment_container_width = 0;
          if (jQuery(".bwg_comment_container").hasClass("bwg_open")) {
            comment_container_width = jQuery(".bwg_comment_container").width();
          }
          jQuery(document).on("fscreenchange", function () {
            if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen) && jQuery.fullscreen.isFullScreen()) {
              bwg_exit_fullscreen();
            }
          });
          function bwg_exit_fullscreen() {
            if (jQuery(window).width() > <?php echo $image_width; ?>) {
              bwg_popup_current_width = <?php echo $image_width; ?>;
            }
            if (jQuery(window).height() > <?php echo $image_height; ?>) {
              bwg_popup_current_height = <?php echo $image_height; ?>;
            }
            <?php
            /* "Full width lightbox" sets yes.*/
            if ($open_with_fullscreen) {
              ?>
            bwg_popup_current_width = jQuery(window).width();
            bwg_popup_current_height = jQuery(window).height();
              <?php
            }
            ?>
            jQuery("#spider_popup_wrap").on("fscreenclose", function() {
			
              jQuery("#spider_popup_wrap").css({
                width: bwg_popup_current_width,
                height: bwg_popup_current_height,
                left: '50%',
                top: '50%',
                marginLeft: -bwg_popup_current_width / 2,
                marginTop: -bwg_popup_current_height / 2,
                zIndex: 100000
              });
              jQuery(".bwg_image_wrap").css({width: bwg_popup_current_width - comment_container_width});
              jQuery(".bwg_image_container").css({height: bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>, width: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>});
              /*jQuery(".bwg_slide_bg").css({height: bwg_popup_current_height - <?php echo $image_filmstrip_height; ?>});
              jQuery(".bwg_popup_image_spun1").css({height: bwg_popup_current_height - <?php echo $image_filmstrip_height; ?>});*/
              jQuery(".bwg_popup_image").css({
                maxWidth: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
                maxHeight: bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
              });
              jQuery(".bwg_popup_video").css({
                width: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
                height: bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
              });
              /* Set watermark container size.*/
              bwg_change_watermark_container();
              jQuery(".bwg_filmstrip_container").css({<?php echo $width_or_height; ?>: bwg_popup_current_<?php echo $width_or_height; ?> - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?>});
              jQuery(".bwg_filmstrip").css({<?php echo $width_or_height; ?>: bwg_popup_current_<?php echo $width_or_height; ?> - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?>- 40});
              /* Set filmstrip initial position.*/
              bwg_set_filmstrip_pos(bwg_popup_current_<?php echo $width_or_height; ?> - 40);
              jQuery(".bwg_resize-full").show();
              jQuery(".bwg_resize-full").attr("class", "bwg_ctrl_btn bwg_resize-full fa fa-resize-full");
              jQuery(".bwg_resize-full").attr("title", "<?php echo JText::_('MAXIMIZE'); ?>");
              jQuery(".bwg_fullscreen").attr("class", "bwg_ctrl_btn bwg_fullscreen fa fa-fullscreen");
              jQuery(".bwg_fullscreen").attr("title", "<?php echo JText::_('FULLSCREEN'); ?>");
			  
              if ((jQuery("#spider_popup_wrap").width() < jQuery(window).width()) && (jQuery("#spider_popup_wrap").height() < jQuery(window).height())) {
                jQuery(".spider_popup_close_fullscreen").attr("class", "spider_popup_close");
              }
            });
          }
		  
		  
		  		  if(!jQuery.fullscreen)
		 jQuery=$;
		 
          if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen)) {
            if (jQuery.fullscreen.isFullScreen()) {
              /* Exit Fullscreen.*/
              jQuery.fullscreen.exit();
              bwg_exit_fullscreen();
			  jQuery(".bwg_resize-full").show();
              jQuery(".bwg_resize-full").attr("class", "bwg_ctrl_btn bwg_resize-full fa fa-resize-full");
              jQuery(".bwg_resize-full").attr("title", "<?php echo JText::_('MAXIMIZE'); ?>");
              jQuery(".bwg_fullscreen").attr("class", "bwg_ctrl_btn bwg_fullscreen fa fa-fullscreen");
              jQuery(".bwg_fullscreen").attr("title", "<?php echo JText::_('FULLSCREEN'); ?>");

            }
            else {
              /* Fullscreen.*/
              jQuery("#spider_popup_wrap").fullscreen();
              /*jQuery("#spider_popup_wrap").on("fscreenopen", function() {
              if (jQuery.fullscreen.isFullScreen()) {*/
                var screen_width = screen.width;
                var screen_height = screen.height;
                jQuery("#spider_popup_wrap").css({
                  width: screen_width,
                  height: screen_height,
                  left: 0,
                  top: 0,
                  margin: 0,
                  zIndex: 100000
                });
                jQuery(".bwg_image_wrap").css({width: screen_width - comment_container_width});
                jQuery(".bwg_image_container").css({height: (screen_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>), width: screen_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>});
                /* jQuery(".bwg_slide_bg").css({height: screen_height - <?php echo $image_filmstrip_height; ?>});*/
                jQuery(".bwg_popup_image").css({
                  maxWidth: (screen_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>),
                  maxHeight: (screen_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>)
                });
                jQuery(".bwg_popup_video").css({
                  width: (screen_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>),
                  height: (screen_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>)
                });
                /* Set watermark container size.*/
                bwg_change_watermark_container();
                jQuery(".bwg_filmstrip_container").css({<?php echo $width_or_height; ?>: (screen_<?php echo $width_or_height; ?> - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?>)});
                jQuery(".bwg_filmstrip").css({<?php echo $width_or_height; ?>: (screen_<?php echo $width_or_height; ?> - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?> - 40)});
                /* Set filmstrip initial position.*/
                bwg_set_filmstrip_pos(screen_<?php echo $width_or_height; ?> - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?> - 40);
                jQuery(".bwg_resize-full").hide();
                jQuery(".bwg_fullscreen").attr("class", "bwg_ctrl_btn bwg_fullscreen fa fa-resize-small");
                jQuery(".bwg_fullscreen").attr("title", "<?php echo JText::_('EXIT_FULLSCREEN'); ?>");
                jQuery(".spider_popup_close").attr("class", "bwg_ctrl_btn spider_popup_close_fullscreen");
              /*});
              }*/
            }
          }
          return false;
        });
        /* Play/pause.*/
        jQuery(".bwg_play_pause, .bwg_popup_image").on(bwg_click, function () {
          if (jQuery(".bwg_ctrl_btn").hasClass("fa-play")) {
            /* PLay.*/
            bwg_play();
            jQuery(".bwg_play_pause").attr("title", "<?php echo JText::_('PAUSE'); ?>");
            jQuery(".bwg_play_pause").attr("class", "bwg_ctrl_btn bwg_play_pause fa fa-pause");
          }
          else {
            /* Pause.*/
            window.clearInterval(bwg_playInterval);
            jQuery(".bwg_play_pause").attr("title", "<?php echo JText::_('PLAY'); ?>");
            jQuery(".bwg_play_pause").attr("class", "bwg_ctrl_btn bwg_play_pause fa fa-play");
          }
        });
        /* Open with autoplay.*/
        <?php
        if ($open_with_autoplay) {
          ?>
          bwg_play();
          jQuery(".bwg_play_pause").attr("title", "<?php echo JText::_('PAUSE'); ?>");
          jQuery(".bwg_play_pause").attr("class", "bwg_ctrl_btn bwg_play_pause fa fa-pause");
          <?php
        }
        ?>
        /* Open with fullscreen.*/
        <?php
        if ($open_with_fullscreen) {
          ?>
          bwg_open_with_fullscreen();
          <?php
        }
        ?>
        <?php
        if ($option_row->preload_images) {
          echo "bwg_preload_images(parseInt(jQuery('#bwg_current_image_key').val()));";
        }
        ?>        
      });
      /* Open with fullscreen.*/
      function bwg_open_with_fullscreen() {
        jQuery(".bwg_watermark").css({display: 'none'});
        var comment_container_width = 0;
        if (jQuery(".bwg_comment_container").hasClass("bwg_open")) {
          comment_container_width = jQuery(".bwg_comment_container").width();
        }
        bwg_popup_current_width = jQuery(window).width();
        bwg_popup_current_height = jQuery(window).height();
        jQuery("#spider_popup_wrap").css({
          width: jQuery(window).width(),
          height: jQuery(window).height(),
          left: 0,
          top: 0,
          margin: 0,
          zIndex: 100000
        });
        jQuery(".bwg_image_wrap").css({width: (jQuery(window).width() - comment_container_width)});
        jQuery(".bwg_image_container").css({height: (bwg_popup_current_height - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>), width: bwg_popup_current_width - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>});
        jQuery(".bwg_popup_image").css({
         maxWidth: jQuery(window).width() - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
         maxHeight: jQuery(window).height() - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
        },  {
          complete: function () { bwg_change_watermark_container(); }
         });
        jQuery(".bwg_popup_video").css({
         width: jQuery(window).width() - comment_container_width - <?php echo ($filmstrip_direction == 'vertical' ? $image_filmstrip_width : 0); ?>,
         height: jQuery(window).height() - <?php echo ($filmstrip_direction == 'horizontal' ? $image_filmstrip_height : 0); ?>
        },  {
          complete: function () { bwg_change_watermark_container(); }
         });
        jQuery(".bwg_filmstrip_container").css({<?php echo $width_or_height; ?>: jQuery(window).<?php echo $width_or_height; ?>() - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?>});
        jQuery(".bwg_filmstrip").css({<?php echo $width_or_height; ?>: jQuery(window).<?php echo $width_or_height; ?>() - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?> - 40});        
        /* Set filmstrip initial position.*/
        bwg_set_filmstrip_pos(jQuery(window).<?php echo $width_or_height; ?>() - <?php echo ($filmstrip_direction == 'horizontal' ? 'comment_container_width' : 0); ?> - 40);

        jQuery(".bwg_resize-full").attr("class", "bwg_ctrl_btn bwg_resize-full fa fa-resize-small");
        jQuery(".bwg_resize-full").attr("title", "<?php echo JText::_('RESTORE'); ?>");
        jQuery(".spider_popup_close").attr("class", "bwg_ctrl_btn spider_popup_close_fullscreen");         
      }

      function bwg_play() {
        window.clearInterval(bwg_playInterval);
        bwg_playInterval = setInterval(function () {
          if (!data[parseInt(jQuery('#bwg_current_image_key').val()) + 1]) {
            /* Wrap around.*/
            bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), 0, data);
            return;
          }
          bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), parseInt(jQuery('#bwg_current_image_key').val()) + 1, data)
        }, '<?php echo $slideshow_interval * 1000; ?>');
      }
      jQuery(window).focus(function() {
        /* event_stack = [];*/
        if (!jQuery(".bwg_ctrl_btn").hasClass("fa-play")) {
          bwg_play();
        }
        /*var i = 0;
        jQuery(".bwg_slider").children("span").each(function () {
          if (jQuery(this).css('opacity') == 1) {
            jQuery("#bwg_current_image_key").val(i);
          }
          i++;
        });*/
      });
      jQuery(window).blur(function() {
        event_stack = [];
        window.clearInterval(bwg_playInterval);
      });
    </script>
	
<?php

	function array_to_url($array)
	{
	$url='index.php?option=com_gallery_wd&';
	foreach($array as $key=>$params_value)
	{
	if($key!='watermark_position')
	$url.=$key.'='.$params_value.'&';
	}
	
	return (substr($url,0,-1));
	}
	
 function get_userdata($id)
 {
     $db =JFactory::getDBO();
	 $query="SELECT * FROM #__users WHERE id=".$db->escape($id);
	 $db->setQuery($query);
	 $row=$db->loadObject();
 }
 
function is_Email($mail)
 {
 if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
      return false;
    }
 
 }
 
 
 
  function bgw_url_decode($url)
{
$url=str_replace('bwg_dots',':',$url);
$url=str_replace('bwg_slash','/',$url);
$url=str_replace('bwg_equal','=',$url);
$url=str_replace('bwg_amp','&',$url);
$url=str_replace('bwg_sharp','#',$url);
$url=str_replace('bwg_quest','?',$url);
return $url;

}

function bgw_url_encode($url)
{
$url=str_replace(':','bwg_dots',$url);
$url=str_replace('/','bwg_slash',$url);
$url=str_replace('=','bwg_equal',$url);
$url=str_replace('&','bwg_amp',$url);
$url=str_replace('#','bwg_sharp',$url);
$url=str_replace('?','bwg_quest',$url);
return $url;

}

 exit;
