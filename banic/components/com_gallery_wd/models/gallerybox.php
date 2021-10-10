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


class gallery_wdModelGalleryBox extends JModelLegacy
{
	/**
	 * @var string msg
	 */
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */

	/**
	 * Get the message
	 * @return string The message to be displayed to the user
	 */
 public function get_theme_row_data($id) {
    $db =JFactory::getDBO();
    if ($id) {
	$query="SELECT * FROM #__bwg_theme WHERE id=".$db->escape((int)$id);
     
    }
    else {   
$query="SELECT * FROM #__bwg_theme WHERE default_theme=1"	;
  
    }
	$db->setQuery($query);
	
	 $row=$db->loadObject();
    return $row;
  }

  public function get_option_row_data() {
    $db =JFactory::getDBO();
	$query="SELECT * FROM #__bwg_option WHERE id=1";
	$db->setQuery($query);
    $row=$db->loadObject();    
    return $row;
  }

  public function get_comment_rows_data($image_id) {
    $db =JFactory::getDBO();
	$query="SELECT * FROM #__bwg_image_comment WHERE image_id=".$db->escape((int)$image_id)." AND published=1 ORDER BY `id` DESC";
	$db->setQuery($query);
    $row = $db->loadObjectList();
    return $row;
  }

  public function get_image_rows_data($gallery_id, $sort_by,$order_by="asc") {
    $db =JFactory::getDBO();
    if ($sort_by == 'size' || $sort_by == 'resolution') {
      $sort_by = ' CAST(t1.' . $sort_by . ' AS SIGNED) ';
    }
    elseif (($sort_by != 'alt') && ($sort_by != 'date') && ($sort_by != 'filetype')) {
      $sort_by = 't1.`order`';
	  }
	  

	  
	$query='SELECT t1.*,t2.rate FROM #__bwg_image as t1 LEFT JOIN (SELECT rate, image_id FROM #__bwg_image_rate WHERE ip="'.$_SERVER['REMOTE_ADDR'].'") as t2 ON t1.id=t2.image_id WHERE t1.published=1 AND t1.gallery_id='.$db->escape((int)$gallery_id).' ORDER BY ' . $sort_by . ' ' . $order_by;
    
	
	$db->setQuery($query);
    $row = $db->loadObjectList();
    return $row;
  }

  public function get_image_rows_data_tag($tag_id, $sort_by ,$order_by = 'asc') {
    $db =JFactory::getDBO();
	
	    if ($sort_by == 'size' || $sort_by == 'resolution') {
      $sort_by = ' CAST(' . $sort_by . ' AS SIGNED) ';
    }
    elseif (($sort_by != 'alt') && ($sort_by != 'date') && ($sort_by != 'filetype')) {
      $sort_by = '`order`';
    }
	
	
	$query='SELECT t1.*,t2.rate FROM (SELECT image.* FROM #__bwg_image as image INNER JOIN #__bwg_image_tag as tag ON image.id=tag.image_id WHERE image.published=1 AND tag.tag_id='.$db->escape((int)$tag_id).' ORDER BY ' . $sort_by . ' ' . $order_by . ') as t1 LEFT JOIN (SELECT rate, image_id FROM #__bwg_image_rate WHERE ip="'.$_SERVER['REMOTE_ADDR'].'") as t2 ON t1.id=t2.image_id ';
	
	
	
	
	$db->setQuery($query);
    $row = $db->loadObjectList();
    return $row;
  }
}
