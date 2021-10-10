<?php
 /**
 * @package Gallery WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
 
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class gallery_wdModelComments extends JModelLegacy
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */

    public function get_option_row_data() {
    $db =JFactory::getDBO();
	$query="SELECT * FROM #__bwg_option WHERE id=1";
	$db->setQuery($query);
    $row = $db->loadObject();
    return $row;
  }

  
  public function get_rows_data() {
   
    $db =JFactory::getDBO();
	
		$mainframe = JFactory::getApplication();;
$option=JRequest::getVar('option');
	$view=JRequest::getVar('view');	

   
   	$filter_order= $mainframe-> getUserStateFromRequest( $option.$view.'filter_order', 'filter_order','id','cmd' );
	//$filter_order='id';
	$filter_order_Dir= $mainframe-> getUserStateFromRequest( $option.$view.'filter_order_Dir', 'filter_order_Dir','desc','word' );
	$search = $mainframe-> getUserStateFromRequest( $option.$view.'search', 'search','','string' );
	$search = JString::strtolower( $search );
	$limit= $mainframe-> getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe-> getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
	$where = array();
  
  $lists['search_select_value']=JRequest::getVar('search_select_value');
  
   	if ( $search ) {
		$where[] = 'name LIKE "%'.$db->escape($search).'%"';
	}	
	
	if($lists['search_select_value']!='' AND $lists['search_select_value']!=0)
	{
	$where[] = 'image_id=' . $db->escape($lists['search_select_value']); 
	}
	

	
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	

	
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id '.$filter_order_Dir.'';
	} else {
		$orderby 	= ' ORDER BY '. 
         $filter_order .' '. $filter_order_Dir .', id';
	}	
   
   

    
	
    $query = "SELECT COUNT(*) FROM #__bwg_image_comment " . $where;
	
	$db->setQuery( $query );
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );	

    $query = "SELECT * FROM #__bwg_image_comment " . $where . $orderby ;
  
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit );
	$rows=$db->loadObjectList();
	
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
		
	// search_calendar filter	
    $lists['search']= $search;	
	
	
    return array($rows,$pageNav,$lists);
	
  }
  
    
	public function get_images_for_comments_table (){
    $db =JFactory::getDBO();    
	$query = "SELECT * FROM #__bwg_image WHERE published=1";
	$db->setQuery($query);
    $rows_object = $db->loadObjectList();
    $rows[0] = 'Select  image';
    if ($rows_object) {
      foreach ($rows_object as $row_object) {
        $rows[$row_object->id] = $row_object->filename;
      }
    }
    return $rows;
  }
  

}