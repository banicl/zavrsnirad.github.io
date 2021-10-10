<?php

/*
 * @version		$Id: default_responsive.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); ?>

<p class="yendif-muted"><?php echo JText::_('YENDIF_VIDEO_SHARE_RESPONSIVE_CSS_DESCRIPTION'); ?></p>
<textarea name="responsive_css" class="responsive_css" rows="3" cols="50"><?php echo $this->item->responsive_css; ?></textarea>