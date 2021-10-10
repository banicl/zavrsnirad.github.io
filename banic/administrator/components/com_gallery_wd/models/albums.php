<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
 
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class gallery_wdModelAlbums extends JModelLegacy
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */

  

  
  public function get_rows_data() {
   
    $db =JFactory::getDBO();
	
		$mainframe = JFactory::getApplication();;
$option=JRequest::getVar('option');
$view=JRequest::getVar('view');	
	
   $query="SELECT gallery_role FROM #__bwg_option";
   $db->setQuery($query);
   $author=$db->loadResult();
      $user = JFactory::getUser();
   	$filter_order= $mainframe-> getUserStateFromRequest( $option.$view.'filter_order', 'filter_order','id','cmd' );
	//$filter_order='id';
	$filter_order_Dir= $mainframe-> getUserStateFromRequest( $option.$view.'filter_order_Dir', 'filter_order_Dir','desc','word' );
	$search = $mainframe-> getUserStateFromRequest( $option.$view.'search', 'search','','string' );
	$search = JString::strtolower( $search );
	$limit= $mainframe-> getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe-> getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
	$where = array();
  
   	if ( $search ) {
		$where[] = 'table1.name LIKE "%'.$db->escape($search).'%"';
	}	
	
	    if ( $author ) {
      $where[] = "  author=" . $db->escape($user->id);
    }
    else {
      $where[] = "  author>=0 ";
	
    }
	
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	

	
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY table1.id '.$filter_order_Dir.'';
	} else {
		$orderby 	= ' ORDER BY table1.`'. 
         $filter_order .'` '. $filter_order_Dir .', id';
	}	
   
   

	
    $query = "SELECT count(*),table2.name as display_name FROM #__bwg_album as table1 LEFT JOIN #__users as table2 ON table2.id=table1.author  " . $where;
	
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );	

    $query = "SELECT table1.*,table2.name as display_name FROM #__bwg_album as table1 LEFT JOIN #__users as table2 ON table2.id=table1.author  " . $where . $orderby . "";
  
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit );
	$rows=$db->loadObjectList();
	
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
		
	// search_calendar filter	
    $lists['search']= $search;	
	
	
    return array($rows,$pageNav,$lists);
  }
  
  
  
  
  
  public function get_row_data($id) {

  
      $db =JFactory::getDBO();
   $query="SELECT gallery_role FROM #__bwg_option";
   $db->setQuery($query);
   $author=$db->loadResult();
   $user = JFactory::getUser();
   //!current_user_can('manage_options') && 
    if ($id != 0) {
      if ($author) {
        $where = " WHERE author=" . (int)$db->escape($user->id);
      }
      else {
        $where = " WHERE author>=0 ";
      }
      
	  $query = 'SELECT * FROM #__bwg_album ' . $where . ' AND id='.(int)$db->escape($id);
   $db->setQuery($query);
	$row=$db->loadObject();


   }
    else {
      $row = new stdClass();
      $row->id ='';
      $row->name = '';
      $row->slug = '';
      $row->description = '';
      $row->preview_image = '';
      $row->order = 0;
      $row->author = $user->id;
      $row->published = 1;
    }

    return $row;
  }
  
    public function get_albums_galleries_rows_data($album_id) {
  
      $db =JFactory::getDBO();
	     $query="SELECT gallery_role FROM #__bwg_option";
   $db->setQuery($query);
   $author=$db->loadResult();
   $user = JFactory::getUser();
   //!current_user_can('manage_options') &&
    if ( $author) {
      $where = " AND author=" . $db->escape($user->id);
    }
    else {
      $where = " AND author>=0 ";
    }
    
	$query="SELECT t1.id, t2.name, t2.slug, t1.is_album, t1.alb_gal_id, t1.order FROM #__bwg_album_gallery as t1 INNER JOIN #__bwg_album as t2 on t1.alb_gal_id = t2.id where t1.is_album='1'" . $where . " AND t1.album_id='" . (int)$db->escape($album_id) . "' union SELECT t1.id, t2.name, t2.slug, t1.is_album, t1.alb_gal_id, t1.order FROM #__bwg_album_gallery as t1 INNER JOIN #__bwg_gallery as t2 on t1.alb_gal_id = t2.id where t1.is_album='0'" . $where . " AND t1.album_id='" . (int)$db->escape($album_id) . "' ORDER BY `order`";
	
	$db->setQuery($query);
	
	$row = $db->loadObjectList();
    return $row;
  }
  

  
 
  
  

}