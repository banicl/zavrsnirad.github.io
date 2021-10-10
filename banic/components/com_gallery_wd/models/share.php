<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

class gallery_wdModelshare extends JModelLegacy
{
	
   public function get_image_row_data($image_id) {
    $db=JFactory::getDBO();
	$query='SELECT * FROM #__bwg_image WHERE published=1 AND id='.(int)$image_id;
	$db->setQuery($query);
    $row = 	$db->loadObject();

    return $row;
  }

}
