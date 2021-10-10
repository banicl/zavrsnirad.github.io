<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

	
?>



    <div style="clear: both; float: left; width: 99%;">
      <div style="float:left; font-size: 14px; font-weight: bold;">
        This section allows you to create, edit and delete themes.
        <a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/joomla-gallery-guide-step-6/6-1.html">Read More in User Manual</a>

          <br />
          This feature is disabled for the non-commercial version.

      </div>
	      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/products/joomla-gallery.html">
          <img width="215" border="0" alt="https://web-dorado.com" src="<?php echo WD_BWG_URL . '/images/logo.png'; ?>" />
        </a>
      </div>
    </div>

      <div style="clear: both; float: left; width: 97%;">
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_thumbnails.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_masonry.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_slideshow.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_image_browser.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_compact_album.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_extended_album.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_blog_style.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_lightbox.png'; ?>" />
        <img style="max-width: 100%;" src="<?php echo WD_BWG_URL . '/images/theme_page_navigation.png'; ?>" />
      </div>
