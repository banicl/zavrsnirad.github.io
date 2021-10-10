<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');


class gallery_wdControllerTags extends JControllerForm
{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$input = JFactory::getApplication()->input;
        $input->set('view', 'tags');
		
	}

			
public function save_tag() {
	 		JSession::checkToken() or die( 'Invalid Token' );

    $this->edit_tags();
   JRequest::setVar('view','tags');
	parent::display();
  } 

 public function save_tag_db() {

	//  $slug = sanitize_title($slug);
   
   $row =JTable::getInstance('tags', 'gallery_wdTable');

   	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	
			if($row->name=='')
	$row->name=$this->bwg_get_unique_name('tag', 0);
	else
	$row->name=$this->bwg_get_unique_name($row->name, 0);

	
		if($row->slug=='')
	$row->slug=$this->bwg_get_unique_slug($row->name, 0);
	

	
		if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
}	
	
	
	public function edit_tags() {
	 $db =JFactory::getDBO();
    $flag = FALSE;
	$query="SELECT * FROM #__bwg_tags ORDER BY id";
	$db->setQuery($query);
	
    $rows = $db->loadObjectList();
	 $row =JTable::getInstance('tags', 'gallery_wdTable');
    $name = JRequest::getVar('name');;
    if ($name!='') {
      $this->save_tag_db();
    }
    foreach ($rows as $row_data) {
      $id = $row_data->id;
      $count = JRequest::getVar('count' . $row_data->id);
      $name = JRequest::getVar('tagname' . $row_data->id);
      $name = $this->bwg_get_unique_name($name,  $id);
      if ($name) {
        $slug = JRequest::getVar('slug' . $row_data->id,$name);
        $slug = $this->bwg_get_unique_slug($slug, $id);

		$row->id=$id;
        $row->name=$name;
		$row->slug=$slug;
		$row->count=$count;
		if(!$row->store()){
		JError::raiseError(500, $row->getError() );
		
		
			}
			else
			$flag = TRUE;
      }
    }
   JRequest::setVar('view','tags');
//	parent::display();
  }
	
	
	
	public function edit_tag() {
	 		JSession::checkToken() or die( 'Invalid Token' );

	//  $slug = sanitize_title($slug);
   	 $db =JFactory::getDBO();
   $row =JTable::getInstance('tags', 'gallery_wdTable');
$flag = FALSE;
$id=JRequest::getVar('id');
$query="SELECT count FROM #__bwg_tags WHERE id=".$db->escape($id);
$db->setQuery($query);
$count=$db->loadResult();
   	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}

	if($row->name=='')
	$row->name=$this->bwg_get_unique_name('tag', 0);


	
		if($row->slug=='')
	$row->slug=$this->bwg_get_unique_slug($row->name, 0);
	

	
		if(!$row->store()){
		JError::raiseError(500, $row->getError() );
		
		
	}
	else
	$flag = TRUE;
   
 if ($flag) {
      echo $row->name . '.' . $row->slug .'.'. $count ;//$count;
    }
    die();
      
}

	public function bwg_get_unique_name($name, $id) {
   
    $db =JFactory::getDBO();
	
    if ($id != 0) {
      $query = "SELECT name FROM #__bwg_tags WHERE name = '".$db->escape($name)."' AND id != ".$db->escape($id);
    }
    else {
      $query = "SELECT name FROM #__bwg_tags WHERE name ='".$db->escape($name)."'";
    }
	$db->setQuery($query);
    
	if ($db->loadResult()) {
      $num = 2;
      do {
        $alt_name = $name . "-$num";
        $num++;
		$query_slug="SELECT name FROM #__bwg_tags WHERE name ='".$db->escape($alt_name)."'";
		$db->setQuery($query_slug);
        $slug_check = $db->loadResult();
      } while ($slug_check);
      $name = $alt_name;
    }
    return $name;
  }   
  

  
  public function bwg_get_unique_slug($slug, $id) {
   
    $db =JFactory::getDBO();
	// $slug = sanitize_title($slug);
    if ($id != 0) {
      $query = "SELECT slug FROM #__bwg_tags WHERE slug = '". $db->escape($slug)."' AND id != ".$db->escape($id);
    }
    else {
      $query = "SELECT slug FROM #__bwg_tags WHERE slug ='".$db->escape($slug)."'" ;
    }
	$db->setQuery($query);
    
	if ($db->loadResult()) {
      $num = 2;
      do {
        $alt_slug = $slug . "-$num";
        $num++;
		$query_slug="SELECT slug FROM #__bwg_tags WHERE slug ='".$db->escape($alt_slug)."'";
		$db->setQuery($query_slug);
        $slug_check = $db->loadResult;
      } while ($slug_check);
      $slug = $alt_slug;
    }
    return $slug;
  }  

  
  
  
  
  
  
  

    public function delete() {
	 		JSession::checkToken() or die( 'Invalid Token' );
	
    $db =JFactory::getDBO();
	$id=JRequest::getVar('current_id',0);
	$query="DELETE FROM #__bwg_tags WHERE id=".$db->escape($id);
	$db->setQuery($query);
    $db->query();
	
	$query="DELETE FROM #__bwg_image_tag WHERE tag_id=".$db->escape($id);
	$db->setQuery($query);
    $db->query();
	
   JRequest::setVar('view','tags');
	parent::display();
  }

  public function delete_all() {
 	 		JSession::checkToken() or die( 'Invalid Token' );
 
    $db =JFactory::getDBO();
	$mainframe = JFactory::getApplication();
	$cid = JRequest::getVar( 'cid' , array() , '' , 'array' );
	
	 JArrayHelper::toInteger($cid);
  
  // If any item selected
  if (count( $cid )) {
    // Prepare sql statement, if cid array more than one, 
    // will be "cid1, cid2, ..."
    $cids = implode( ',', $cid );
    // Create sql statement
	


       $query="DELETE FROM #__bwg_tags WHERE id IN ( ". $db->escape($cids) ." )";
		$db->setQuery($query);
		$db->query();
		
		$query="DELETE FROM #__bwg_image_tag WHERE tag_id IN ( ". $db->escape($cids) ." )";
		$db->setQuery($query);
		$db->query();
      
	  
	  
    }
 
   JRequest::setVar('view','tags');
	parent::display();
  }
 
		
		
}