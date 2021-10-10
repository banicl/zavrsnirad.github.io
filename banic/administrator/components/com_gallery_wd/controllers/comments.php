<?php
 /**
 * @package Gallery WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');


class gallery_wdControllerComments extends JControllerForm
{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$input = JFactory::getApplication()->input;
        $input->set('view', 'comments');
		
	}


			public function getModel($name = 'comments', $prefix = 'gallery_wdModel', $config = array('ignore_request' => true))
			{
				$model = parent::getModel($name, $prefix, $config);

				return $model;
			}
			
	

	
	public function publish()
	{
		$this->change_state(1);
	}	

	public function unpublish()
	{
	$this->change_state(0);
	}	

	
	public function delete()
	{
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

	

	
    $query = 'DELETE FROM #__bwg_image_comment  WHERE id IN ( '. $db->escape($cids) .' )';
    $db->setQuery( $query );
    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";  
    }

	
  }
  // After all, redirect again to frontpage
  $mainframe->redirect( "index.php?option=com_gallery_wd&view=comments",'','message');
	
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
  $query = 'UPDATE #__bwg_image_comment  SET published = '.(int) $db->escape($state) .' WHERE id IN ( '. $db->escape($cids) .' )'  ;
  // Execute query
  $db->setQuery( $query );
  if (!$db->query()) {
    JError::raiseError(500, $db->getErrorMsg() );
  }
  if (count( $cid ) == 1) {
    $row =JTable::getInstance('comment', 'gallery_wdTable');
    $row->checkin( intval( $cid[0] ) );
  }
  }
  // After all, redirect to front page
  $mainframe->redirect( 'index.php?option=com_gallery_wd&view=comments','','message' );
}
	
		
}