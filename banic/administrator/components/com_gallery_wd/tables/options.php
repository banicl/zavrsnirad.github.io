<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');


class gallery_wdTableOptions extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 var $id = null;
	 var $images_directory = null;
	 var $masonry = null;
	 var $image_column_number = null;
	 var $images_per_page = null;
	 var $thumb_width = null;
	 var $thumb_height = null;
	 var $upload_thumb_width = null;
	 var $upload_thumb_height = null;
	 var $image_enable_page = null;
	 var $image_title_show_hover = null;
	 var $album_column_number = null;
	 var $albums_per_page = null;
	 var $album_title_show_hover = null;
	 var $album_thumb_width = null;
	 var $album_thumb_height = null;
	 var $album_enable_page = null;
	 var $extended_album_height = null;
	 var $extended_album_description_enable = null;
	 var $image_browser_width = null;
	 var $image_browser_title_enable = null;
	 var $image_browser_description_enable = null;
	 var $blog_style_width = null;
	 var $blog_style_title_enable = null;
	 var $blog_style_images_per_page = null;
	 var $blog_style_enable_page = null;
	 var $slideshow_type = null;
	 var $slideshow_interval = null;
	 var $slideshow_width = null;
	 var $slideshow_height = null;
	 var $slideshow_enable_autoplay = null;
	 var $slideshow_enable_shuffle = null;
	 var $slideshow_enable_ctrl = null;
	 var $slideshow_enable_filmstrip = null;
	 var $slideshow_filmstrip_height = null;
	 var $slideshow_enable_title = null;
	 var $slideshow_title_position = null;
	 var $slideshow_enable_description = null;
	 var $slideshow_description_position = null;
	 var $slideshow_enable_music = null;
	 var $slideshow_audio_url = null;
	 var $popup_width = null;
	 var $popup_height = null;
	 var $popup_type = null;
	var $popup_interval = null;
	var $popup_enable_filmstrip = null;
	var $popup_filmstrip_height = null;
	var $popup_enable_ctrl_btn = null;
	var $popup_enable_fullscreen = null;
	var $popup_enable_comment = null;
	var $popup_enable_email = null;
	var $popup_enable_captcha = null;
	var $popup_enable_download = null;
	var $popup_enable_fullsize_image = null;
	var $popup_enable_facebook = null;
	var $popup_enable_twitter = null;
	var $popup_enable_google = null;
	var $watermark_type = null;
	var $watermark_position = null;
	var $watermark_width = null;
	var $watermark_height = null;
	var $watermark_url = null;
	var $watermark_text = null;
	var $watermark_link = null;
	var $watermark_font_size = null;
	var $watermark_font = null;
	var $watermark_color = null;
	var $watermark_opacity = null;
	var $built_in_watermark_type = null;
	var $built_in_watermark_position = null;
	var $built_in_watermark_size = null;
	var $built_in_watermark_url = null;
	var $built_in_watermark_text = null;
	var $built_in_watermark_font_size = null;
	var $built_in_watermark_font = null;
	var $built_in_watermark_color = null;
	var $built_in_watermark_opacity = null;
	var $gallery_role = null;
	var $album_role = null;
	var $image_role = null;
	var $preload_images = null;
	var $preload_images_count = null;




	 
	function __construct(&$db)
	{
		parent::__construct('#__bwg_option', 'id', $db);
	}
}