<?php

/*
 * @version		$Id: default_user.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); ?>

<fieldset class="form-horizontal">
	<div class="control-group">
    	<label class="control-label" for="autopublish"><?php echo JText::_('YENDIF_VIDEO_SHARE_AUTOPUBLISH'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('autopublish', $this->item->autopublish); ?>
        	<span class="help-inline"><?php echo JText::_('YENDIF_VIDEO_SHARE_AUTOPUBLISH_DESCRIPTION'); ?></span>
    	</div>
  	</div>
    
    <div class="control-group">
    	<label class="control-label" for="schedule_video_publishing"><?php echo JText::_('YENDIF_VIDEO_SHARE_ADD_START_END_PUBLISHING'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('schedule_video_publishing', $this->item->schedule_video_publishing); ?> 
            <span class="help-inline"><?php echo JText::_('YENDIF_VIDEO_SHARE_ADD_START_END_PUBLISHING_DESC'); ?></span>
    	</div>
  	</div>
    
    <div class="control-group">
    	<label class="control-label" for="allow_upload"><?php echo JText::_('YENDIF_VIDEO_SHARE_RESTRICT_GEN_UPLOAD'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('allow_upload', $this->item->allow_upload); ?>
    	</div>
  	</div>
    
    <div class="control-group">
    	<label class="control-label" for="allow_youtube_upload"><?php echo JText::_('YENDIF_VIDEO_SHARE_RESTRICT_YOUTUBE_UPLOAD'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('allow_youtube_upload', $this->item->allow_youtube_upload); ?>
    	</div>
  	</div>
    
    <div class="control-group">
    	<label class="control-label" for="allow_rtmp_upload"><?php echo JText::_('YENDIF_VIDEO_SHARE_RESTRICT_RTMP_UPLOAD'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('allow_rtmp_upload', $this->item->allow_rtmp_upload); ?>
    	</div>
  	</div>
    
    <div class="control-group">
    	<label class="control-label" for="allow_subtitle"><?php echo JText::_('YENDIF_VIDEO_SHARE_RESTRICT_SUBTITLE'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('allow_subtitle', $this->item->allow_subtitle); ?>
    	</div>
  	</div>
    
    <div class="control-group">
    	<label class="control-label" for="allow_guest_like"><?php echo JText::_('YENDIF_VIDEO_SHARE_ALLOW_GUEST_USER_TO_LIKE_DISLIKE'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('allow_guest_like', $this->item->allow_guest_like); ?>
    	</div>
  	</div>
    
    <div class="control-group">
    	<label class="control-label" for="allow_guest_rating"><?php echo JText::_('YENDIF_VIDEO_SHARE_ALLOW_GUEST_USER_TO_RATING'); ?></label>
    	<div class="controls">
        	<?php echo YendifVideoShareFields::ListBoolean('allow_guest_rating', $this->item->allow_guest_rating); ?>
    	</div>
  	</div>
</fieldset>