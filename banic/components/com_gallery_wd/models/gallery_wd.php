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

class gallery_wdModelgallery_wd extends JModelLegacy
{
	
 public function get_theme_row_data($id) {
	$db =JFactory::getDBO();
	   if ($id) {
	$query="SELECT * FROM #__bwg_theme WHERE id=".$db->escape((int)$id);
	}
	else
	{
	$query="SELECT * FROM #__bwg_theme WHERE default_theme=1";

	}
	$db->setQuery($query);
    $row = $db->loadObject();
    return $row;
  }

  public function get_gallery_row_data($id) {
     $db =JFactory::getDBO(); 
	 $query="SELECT * FROM #__bwg_gallery WHERE published=1 AND id=".$db->escape((int)$id);
	 $db->setQuery($query);
     $row = $db->loadObject();

    return $row;
  }
  
  
    public function get_alb_gals_row($id, $albums_per_page, $sort_by, $bwg) {
     $db =JFactory::getDBO(); 
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $albums_per_page;
    }
    else {
      $limit = 0;
    }
    if ($albums_per_page) {
      $limit_str = 'LIMIT ' . $limit . ',' . $albums_per_page;
    }
    else {
      $limit_str = '';
    }
	 $query='SELECT #__bwg_album_gallery.*,#__bwg_gallery.published as published FROM #__bwg_album_gallery LEFT JOIN #__bwg_gallery ON #__bwg_album_gallery.alb_gal_id=#__bwg_gallery.id WHERE album_id='.$db->escape((int)$id).'  ORDER BY ' . ($sort_by == "RAND()" ? '' : '`') . $sort_by . ($sort_by == "RAND()" ? '' : '`') . ' ASC ' . $limit_str;
    $db->setQuery($query);
	$row = $db->loadObjectList();
    return $row;
  }
  
    
	public function get_album_row_data($id) {
     $db =JFactory::getDBO(); 
	 
	 $query="SELECT * FROM #__bwg_album WHERE published=1 AND id=".$db->escape((int)$id);
	 $db->setQuery($query);
    $row =$db->loadObject();
    //$row->permalink = $this->bwg_create_post($row->name, $row->slug, "album", $id);
    return $row;
  }
  
  
  

  public function get_image_rows_data($id, $images_per_page, $sort_by, $bwg, $type='',$order_by="ASC") {
     $db =JFactory::getDBO();   
	 $bwg_search = ((isset($_POST['bwg_search_' . $bwg]) && htmlspecialchars($_POST['bwg_search_' . $bwg]) != '') ? htmlspecialchars($_POST['bwg_search_' . $bwg]) : '');	 
    if ($bwg_search != '') {
      $where = 'AND alt LIKE "%%' . $bwg_search . '%%"';  
      }
    else {
      $where = '';
    }
	
	 
	 if ($sort_by == 'size' || $sort_by == 'resolution') {
      $sort_by = ' CAST(' . $sort_by . ' AS SIGNED) ';
    }
    elseif (($sort_by != 'alt') && ($sort_by != 'date') && ($sort_by != 'filetype') && ($sort_by != 'RAND()') && ($sort_by != 'filename')) {
      $sort_by = '`order`';
    }
	
	if($sort_by == 'date')
	$sort_by="dateandtime";
	
	if($sort_by == 'random')
	$sort_by = 'RAND()';
	
	
	
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $images_per_page;
    }
    else {
      $limit = 0;
    }
    if ($images_per_page) {
      $limit_str = 'LIMIT ' . $limit . ',' . $images_per_page;
    }
    else {
      $limit_str = '';
    }
	
	
	if($type == 'tag') {
      $query = 'SELECT image.* FROM #__bwg_image as image INNER JOIN #__bwg_image_tag as tag ON image.id=tag.image_id WHERE image.published=1 AND tag.tag_id='.$db->escape((int)$id).' ORDER BY ' . $sort_by . ' ASC';      
    }
	else
	{
	$query='SELECT *,STR_TO_DATE(date, "%d %M %Y,%H:%i") as dateandtime  FROM #__bwg_image WHERE published=1 ' . $where . ' AND gallery_id='.$db->escape((int)$id).' ORDER BY ' . $sort_by . ' '.$order_by.' ' . $limit_str;
	}
	$db->setQuery($query);
    $row = $db->loadObjectList();
    return $row;
  }
  
 
    public function gallery_page_nav($id, $images_per_page, $bwg) {
    $db =JFactory::getDBO(); 
	$query="SELECT COUNT(*) FROM #__bwg_image WHERE published=1 AND gallery_id=".$db->escape((int)$id);
	$db->setQuery($query);
	$total=$db->loadResult();
    $page_nav['total'] = $total;
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $images_per_page;
    }
    else {
      $limit = 0;
    }
    if ($images_per_page) {
      $page_nav['limit'] = (int) ($limit / $images_per_page + 1);
    }
    return $page_nav;
  }
  
  
    public function album_page_nav($id, $albums_per_page, $bwg) {
    $db =JFactory::getDBO(); 
	$query="SELECT COUNT(*) FROM #__bwg_album_gallery LEFT JOIN #__bwg_gallery ON #__bwg_album_gallery.alb_gal_id=#__bwg_gallery.id WHERE  album_id=".$db->escape((int)$id)." AND published=1";
	$db->setQuery($query);
	$total=$db->loadResult();
    $page_nav['total'] = $total;
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $albums_per_page;
    }
    else {
      $limit = 0;
    }
    if ($albums_per_page) {
      $page_nav['limit'] = (int) ($limit / $albums_per_page + 1);
    }
    return $page_nav;
  }
  
  

  public function page_nav($id, $images_per_page, $bwg, $type='') {
     $db =JFactory::getDBO();  
	$bwg_search = ((isset($_POST['bwg_search_' . $bwg]) && htmlspecialchars($_POST['bwg_search_' . $bwg]) != '') ? htmlspecialchars($_POST['bwg_search_' . $bwg]) : '');
    if ($bwg_search != '') {
      $where = 'AND alt LIKE "%%' . $bwg_search . '%%"';  
    }
    else {
      $where = '';
	 }
	if ($type == 'tag') {
      $query = 'SELECT COUNT(*) FROM #__bwg_image as image INNER JOIN #__bwg_image_tag as tag ON image.id=tag.image_id WHERE image.published=1 '. $where .' AND tag.tag_id='.$db->escape((int)$id) ;
    }
	else
	{
    $query="SELECT COUNT(*) FROM #__bwg_image WHERE published=1 ". $where ." AND gallery_id=".$db->escape((int)$id) ;
	}
	$db->setQuery($query);
	$total = $db->loadResult();
    $page_nav['total'] = $total;
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $images_per_page;
    }
    else {
      $limit = 0;
    }
    if ($images_per_page) {
      $page_nav['limit'] = (int) ($limit / $images_per_page + 1);
    }
    return $page_nav;
  }
  
  
    
  public function get_options_row_data() {
     $db =JFactory::getDBO();
	 $query="SELECT * FROM #__bwg_option WHERE id=1";
	 $db->setQuery($query);
	$row = $db->loadObject();
	return $row;
  }
  
}
