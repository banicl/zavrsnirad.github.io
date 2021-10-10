<?php
 /**
 * @package Image Gallery
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');


class gallery_wdControllerAlbums extends JControllerForm
{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$input = JFactory::getApplication()->input;
        $input->set('view', 'albums');
		
	}


			public function getModel($name = 'albums', $prefix = 'gallery_wdModel', $config = array('ignore_request' => true))
			{
				$model = parent::getModel($name, $prefix, $config);

				return $model;
			}
			
	public	function add()
		{

			$input = JFactory::getApplication()->input;
			$input->set('view', $input->get('view', 'albums'));
			parent::display();
		}	

	public	function edit($key = null, $urlVar = null)
		{
			$input = JFactory::getApplication()->input;
			$input->set('view', $input->get('view', 'albums'));
			parent::display();
		}		

    public function cancel($key = null) 
		{
		$mainframe = JFactory::getApplication();
		$mainframe->redirect('index.php?option=com_gallery_wd&view=albums');
		}
		

	
	public function publish()
	{
	 		JSession::checkToken() or die( 'Invalid Token' );

		$this->change_state(1);
	}	

	public function unpublish()
	{
	 		JSession::checkToken() or die( 'Invalid Token' );

	$this->change_state(0);
	}	

	
	public function delete()
	{
	 		JSession::checkToken() or die( 'Invalid Token' );

	$mainframe = JFactory::getApplication();
  // Initialize variables	
  $db =JFactory::getDBO();
  // Define cid array variable
  $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );
  // Make sure cid array variable content integer format
  JArrayHelper::toInteger($cid);
  
  // If any item selected
  if (count( $cid )) {
    // Prepare sql statement, if cid array more than one, 
    // will be "cid1, cid2, ..."
    $cids = implode( ',', $cid );
    // Create sql statement

	

	
    $query = 'DELETE FROM #__bwg_album  WHERE id IN ( '. $db->escape($cids) .' )';
    $db->setQuery( $query );
    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";  
    }

  $query = 'DELETE FROM #__bwg_album_gallery  WHERE id IN ( '. $db->escape($cids) .' ) OR ( alb_gal_id IN ( '. $db->escape($cids) .' ) AND is_album)';
    $db->setQuery( $query );
	    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";  
    }
	
  }
  // After all, redirect again to frontpage
  $mainframe->redirect( "index.php?option=com_gallery_wd&view=albums",'','message');
	
	}
	
	
	public function change_state($state=0){
  $mainframe = JFactory::getApplication();;
  // Initialize variables
  $db 	=JFactory::getDBO();
  // define variable $cid from GET
  $cid = JRequest::getVar( 'cid' , array() , '' , 'array' );	
  JArrayHelper::toInteger($cid);
  // Check there is/are item that will be changed. 
  //If not, show the error.
  if (count( $cid ) < 1) {
    $action = $state ? 'publish' : 'unpublish';
    JError::raiseError(500, JText::_( 'Select an item to ' .$action, true ) );
  }
  // Prepare sql statement, if cid more than one, 
  // it will be "cid1, cid2, cid3, ..."
  $cids = implode( ',', $cid );
  if($cids)
  {
  $query = 'UPDATE #__bwg_album' . ' SET published = '.(int) $state .' WHERE id IN ( '. $db->escape($cids) .' )'  ;
  // Execute query
  $db->setQuery( $query );
  if (!$db->query()) {
    JError::raiseError(500, $db->getErrorMsg() );
  }
  if (count( $cid ) == 1) {
    $row =JTable::getInstance('albums', 'gallery_wdTable');
    $row->checkin( intval( $cid[0] ) );
  }
  }
  // After all, redirect to front page
  $mainframe->redirect( 'index.php?option=com_gallery_wd&view=albums','','message' );
}
	
	public function save_album()
	{
	 		JSession::checkToken() or die( 'Invalid Token' );

	 $db =JFactory::getDBO();
	$this->save_db();

   JFactory::getApplication()->enqueueMessage('Item Succesfully Saved.');
   JRequest::setVar('view','albums');
	parent::display();
	}	
		
	public function apply_album() 	
	{
 		JSession::checkToken() or die( 'Invalid Token' );
	
	  $mainframe = JFactory::getApplication();
	 $db =JFactory::getDBO();
	$this->save_db();
    $id=JRequest::getVar('id');
    if ($id=='') {
      $query="SELECT MAX(`id`) FROM #__bwg_album";
	  $db->setQuery($query);
	

	  $id = $db->loadResult();
	    JRequest::setVar('id',$id);
    }

   $mainframe->redirect( 'index.php?option=com_gallery_wd&view=albums&task=edit&cid[]='.$id,'','message' );
   
	}
		
	public function save_order()
		{
	 		JSession::checkToken() or die( 'Invalid Token' );
	
		    $db =JFactory::getDBO();
			
			$query="SELECT id FROM #__bwg_album";
			$db->setQuery($query);
			$album_ids_col=$db->loadColumn();

    if ($album_ids_col) {
      foreach ($album_ids_col as $album_id) {
        if (isset($_POST['order_input_' . $album_id])) {
          $order_values[$album_id] = (int) $_POST['order_input_' . $album_id];
        }
        else {
		$query="SELECT `order` FROM #__bwg_album WHERE `id`=".(int)$db->escape($album_id);
		$db->setQuery($query);
		$order_values[$album_id]=$db->loadResult();
        }
      }
      asort($order_values);
      $i = 1;
      foreach ($order_values as $key => $order_value) {
	  $query="UPDATE #__bwg_album SET `order`=".(int)$db->escape($i)." WHERE id=".(int)$db->escape($key);
     $db->setQuery($query);
	 $db->query();
        $i++;
      }
	   JFactory::getApplication()->enqueueMessage('Ordering Succesfully updated.');
    }
	

   JRequest::setVar('view','albums');
	parent::display();
			
		}
	
  public function save_db() {
     $user = JFactory::getUser();
    $db =JFactory::getDBO();
	$id = JRequest::getVar('current_id',0);     
	$row =JTable::getInstance('albums', 'gallery_wdTable');
	
	$albums_galleries=JRequest::getVar('albums_galleries');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}

	
if($row->order==0)
	{
	$query="SELECT MAX(`order`) FROM #__bwg_album";
	$db->setQuery($query);
	$max_order=$db->loadResult();
	$row->order=$max_order+1;
	}
	
	
	if($row->name=='')
	$row->name=$this->bwg_get_unique_name('Gallery', $id);
	else
	$row->name=$this->bwg_get_unique_name($row->name, $id);
	
	if($row->slug=='')
	$row->slug=$this->bwg_get_unique_name($row->name, $id);
	
	if($row->preview_image=='')
    {
      if ($id != 0) {
        $query="SELECT random_preview_image FROM #__bwg_album WHERE id=".(int)$db->escape($id);
		$db->setQuery($query);
		
		$random_preview_image =$db->loadResult();
        
		if ($random_preview_image == '') {
		 $query="SELECT thumb_url FROM #__bwg_image WHERE gallery_id=".(int)$db->escape($id)." ORDER BY `order`";
		$db->setQuery($query);
        $random_preview_image =$db->loadResult();
        }
      }
      else {
        $random_preview_image =JRequest::getVar('thumb_url_pr_0');
      }
	  
	  $row->preview_image=$random_preview_image;
    }
	
	$row->author=$user->id;
	$row->description=JRequest::getVar( 'description', '','post', 'string', JREQUEST_ALLOWRAW );

	
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}

	
$this->save_alb_gal($row->id, $albums_galleries);

 


 }
  
  
    public function save_alb_gal($id, $alb_gal_str) {
    $db =JFactory::getDBO();

    $query = 'DELETE FROM #__bwg_album_gallery WHERE album_id='.(int)$db->escape($id);
    $db->setQuery($query);
	$db->Query();
    $alb_gals = explode(",", $alb_gal_str);

	$row =JTable::getInstance('albumgallery', 'gallery_wdTable');
    for ($i = 0; $i < count($alb_gals)-1; $i++) {
      $params = explode(":", $alb_gals[$i]);  



	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
 if (count($params) == 3) {
 $row->id='';
	$row->album_id=$id;
	$row->is_album=$params[1];
	$row->alb_gal_id=$params[2];
	$row->order=$i+1;
	  }

	  	
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );

	}
    }
	

  }
  
  



  public function bwg_get_unique_name($name, $id) {
   
    $db =JFactory::getDBO();
	
    if ($id != 0) {
      $query = "SELECT name FROM #__bwg_album WHERE name = '".$db->escape($name)."' AND id != ".(int)$db->escape($id);
    }
    else {
      $query = "SELECT name FROM #__bwg_album WHERE name ='".$db->escape($name)."'";
    }
	$db->setQuery($query);
    
	if ($db->loadResult()) {
      $num = 2;
      do {
        $alt_name = $name . "-$num";
        $num++;
		$query_slug="SELECT name FROM #__bwg_album WHERE name ='".$db->escape($alt_name)."'";
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
      $query = "SELECT slug FROM #__bwg_album WHERE slug = '". $db->escape($slug)."' AND id != ".(int)$db->escape($id);
    }
    else {
      $query = "SELECT slug FROM #__bwg_album WHERE slug ='".$db->escape($slug)."'" ;
    }
	$db->setQuery($query);
    
	if ($db->loadResult()) {
      $num = 2;
      do {
        $alt_slug = $slug . "-$num";
        $num++;
		$query_slug="SELECT slug FROM #__bwg_album WHERE slug ='".$db->escape($alt_slug)."'";
		$db->setQuery($query_slug);
        $slug_check = $db->loadResult;
      } while ($slug_check);
      $slug = $alt_slug;
    }
    return $slug;
  }  

	
	
	
 
		
		
}