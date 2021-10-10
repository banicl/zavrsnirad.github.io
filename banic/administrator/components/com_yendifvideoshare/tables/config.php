<?php

/*
 * @version		$Id: config.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareTableConfig extends JTable {

	var $id                        = null;	
	var $allow_guest_like          = null;
	var $allow_guest_rating        = null;
	var $allow_rtmp_upload         = null;
	var $allow_upload              = null;
	var $allow_youtube_upload      = null;
	var $allowed_extensions        = null;
	var $analytics                 = null;
	var $autoplay                  = null;
	var $autoplaylist              = null;
	var $autopublish               = null;
	var $bootstrap_version         = null;
	var $can_skip_adverts          = null;
	var $comments                  = null;
	var $controlbar                = null;
	var $currenttime               = null;
	var $default_image             = null;
	var $download                  = null;
	var $duration                  = null;
	var $embed                     = null;
	var $enable_adverts            = null;
	var $enable_popup              = null;
    var $engine                    = null;
	var $fb_app_id                 = null;
	var $fb_color_scheme           = null;
	var $fb_post_count             = null;
	var $fb_show_count             = null;
	var $feed_icon                 = null;
	var $feed_limit                = null;
	var $feed_name                 = null;		
	var $feed_search               = null;	
	var $fullscreen                = null;
	var $gallery_thumb_height      = null;
	var $gallery_thumb_width       = null;
	var $google_api_key            = null;
	var $ignored_extensions        = null;
	var $illegal_mime_types        = null;	
	var $jcomments_show_count      = null;
	var $jquery                    = null;
	var $keyboard                  = null;	
	var $komento_show_count        = null;
	var $legal_mime_types          = null;
	var $license                   = null;	
	var $logo                      = null;
	var $loop                      = null;
	var $max_upload_size           = null;	
	var $no_of_cols                = null;
	var $no_of_rows                = null;
	var $playbtn                   = null;
	var $player_height             = null;
	var $player_width              = null;
	var $playlist_desc_limit       = null;
	var $playlist_height           = null;
	var $playlist_position         = null;
	var $playlist_title_limit      = null;
	var $playlist_width            = null;
	var $playpause                 = null;
	var $poster_image_height       = null;
	var $poster_image_width        = null;		
	var $progress                  = null;			
	var $ratio                     = null;
	var $resize_method             = null;
    var $responsive                = null;
	var $responsive_css            = null;
	var $schedule_video_publishing = null;
	var $sef_cat                   = null;
	var $sef_position              = null;	
	var $sef_sptr                  = null;
	var $sef_video                 = null;
	var $sef_video_prefix          = null;
	var $share                     = null;
	var $share_script              = null;	
	var $show_adverts_timeframe    = null;
	var $show_category             = null;
	var $show_date                 = null;
	var $show_description          = null;
	var $show_excerpt              = null;
	var $show_feed                 = null;
	var $show_likes                = null;
	var $show_media_count          = null;
	var $show_rating               = null;
	var $show_related              = null;
	var $show_search               = null;
	var $show_skip_adverts_on      = null;
	var $show_title                = null;
	var $show_user                 = null;
	var $show_views                = null;			
	var $theme                     = null;
	var $thumb_height              = null;
	var $thumb_width               = null;
	var $video_desc_limit          = null;
	var $volume                    = null;				
	var $volumebtn                 = null;

	public function __construct( &$db ) {
		parent::__construct( '#__yendifvideoshare_config', 'id', $db );
	}

	public function check() {
		return true;
	}
	
}