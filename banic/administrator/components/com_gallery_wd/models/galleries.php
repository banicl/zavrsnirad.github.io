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

class gallery_wdModelGalleries extends JModelLegacy
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */

	 
	 public function get_option_rows_data() {
	  $db =JFactory::getDBO();
   $query="SELECT * FROM #__bwg_option WHERE id=1";
   $db->setQuery($query);
 $row=$db->loadObject();
 return $row;
	 }
	 
	 
	 
	 
	 public function get_image_rows_data($gallery_id) {
       $db =JFactory::getDBO();
   $query="SELECT image_role FROM #__bwg_option";
   $db->setQuery($query);
 $author=$db->loadResult();
      $user = JFactory::getUser();
   //!current_user_can('manage_options') &&
    if ( $author) {
      $where = " WHERE author=" . (int)$db->escape($user->id);
    }
    else {
      $where = " WHERE author>=0 ";
    }
	$search_value=JRequest::getVar('search_value');
	
    $where .= (($search_value!='') ? ' AND filename LIKE "%' . $db->escape(htmlspecialchars(stripslashes($search_value))) . '%"' : '');
    $asc_or_desc = JRequest::getVar('asc_or_desc','asc');
    $image_order_by = ' ORDER BY `' .$db->escape(JRequest::getVar('image_order_by','order')) . '` ' . $db->escape($asc_or_desc);
    if (JRequest::getVar('page_number')!='') {
      $limit = ((int) JRequest::getVar('page_number') - 1) * 20;
    }
    else {
      $limit = 0;
    }
   
     $query="SELECT * FROM #__bwg_image " . $where . " AND gallery_id='" . (int)$db->escape($gallery_id) . "' " . $image_order_by . " LIMIT " . (int)$limit . ",20";


	$db->setQuery($query);
	$row = $db->loadObjectList();
    return $row;
  }
  

  
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
      $where[] = "  table1.author=" . $db->escape($user->id);
    }
    else {
      $where[] = "  table1.author>=0 ";
	
	}
	
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY table1.id '.$filter_order_Dir;
	} else {
		$orderby 	= ' ORDER BY table1.`'. 
         $filter_order .'` '. $filter_order_Dir .', id';
	}	
   
   

    
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

$query = "SELECT count(*),table2.name as display_name FROM #__bwg_gallery as table1 LEFT JOIN #__users as table2 ON table1.author=table2.id " . $where ;
	
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );	

    $query = "SELECT table1.*,table2.name as display_name FROM #__bwg_gallery as table1 LEFT JOIN #__users as table2 ON table1.author=table2.id " . $where . $orderby . "";
  
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
        $where = " WHERE author=" . $db->escape($user->id);
      }
      else {
        $where = " WHERE author>=0 ";
      }
      
	  $query = 'SELECT * FROM #__bwg_gallery ' . $where . ' AND id='.$db->escape($id);
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
  
  
  public function page_nav() {
  
        $db =JFactory::getDBO();
   $query="SELECT gallery_role FROM #__bwg_option";
   $db->setQuery($query);
   $author=$db->loadResult();
      $user = JFactory::getUser();
  //!current_user_can('manage_options') &&
    if ( $author) {
      $where = " WHERE author=" . $db->escape($user->id);
    }
    else {
      $where = " WHERE author>=0 ";
    }
    $where .= ((isset($_POST['search_value']) && (htmlspecialchars(stripslashes($_POST['search_value'])) != '')) ? ' AND name LIKE "%' . $db->escape(htmlspecialchars(stripslashes($_POST['search_value']))) . '%"'  : '');
    $query = "SELECT COUNT(*) FROM #__bwg_gallery " . $where;
	$db->setQuery($query);
    $total = $db->loadResult($query);
    $page_nav['total'] = $total;
    if (isset($_POST['page_number']) && $_POST['page_number']) {
      $limit = ((int) $_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
    $page_nav['limit'] = (int) ($limit / 20 + 1);
    return $page_nav;
  }
  
  public function image_page_nav($gallery_id,$page_num) {
           $db =JFactory::getDBO();
   $query="SELECT image_role FROM #__bwg_option";
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
    $where .= ((isset($_POST['search_value']) && (htmlspecialchars(stripslashes($_POST['search_value'])) != '')) ? ' AND filename LIKE "%' . $db->escape(htmlspecialchars(stripslashes($_POST['search_value']))) . '%"'  : '');
   
   $query = "SELECT COUNT(*) FROM #__bwg_image WHERE gallery_id='" . $db->escape($gallery_id) . "' " . $where;
	$db->setQuery($query);
    $total = $db->loadResult();

    $page_nav['total'] = $total;

	
    if (JRequest::getVar('page_number')!='') {
      $limit = ((int) JRequest::getVar('page_number') - 1) * 20;
    }
    else {
      $limit = 0;
    }
    $page_nav['limit'] = (int) ($limit / 20 + 1);
	

    return $page_nav;
  }
  
  

}