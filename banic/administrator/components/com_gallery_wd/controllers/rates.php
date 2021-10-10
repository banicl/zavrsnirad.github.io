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


class gallery_wdControllerRates extends JControllerForm
{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$input = JFactory::getApplication()->input;
        $input->set('view', 'rates');
		
	}

			
  public function delete($id) {
   $db=JFactory::getDBO();

	
	$query="SELECT image_id FROM #__bwg_image_rate WHERE id=".$id;
	$db->setQuery($query);
	$image_id=$db->loadResult();
	
    $query = 'DELETE FROM #__bwg_image_rate WHERE id='.$id;
	$db->setQuery($query);
	
    if ($db->query()) {
	
      $rates = $wpdb->get_row($wpdb->prepare('SELECT AVG(`rate`) as `average`, COUNT(`rate`) as `rate_count` FROM #__bwg_image_rate WHERE image_id="%d"', $image_id));
      
	  $query='SELECT AVG(`rate`) as `average`, COUNT(`rate`) as `rate_count` FROM #__bwg_image_rate WHERE image_id='.$image_id;
	  $db->setQuery($query);
	  $rates=$db->loadObject();
	  
	  
	  $query="UPDATE #__bwg_image SET avg_rating=".$rates->average.",rate_count=".$rates->rate_count." WHERE id=".$image_id;
$db->setQuery( $query)      ;
$db->query();
	  
	  echo WDWLibrary::message('Item Succesfully Deleted.', 'updated');
	  
    }
    else {
      echo WDWLibrary::message('Error. Please install plugin again.', 'error');
    }
    
	parent::display();
  }
  
  public function delete_all() {
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
	

    foreach ($cid as $id) {
          
        $flag = TRUE;
        $query="SELECT image_id FROM #__bwg_image_rate WHERE id=".$id;
	$db->setQuery($query);
	$image_id=$db->loadResult();
    $query = 'DELETE FROM #__bwg_image_rate WHERE id='.$id;
	$db->setQuery($query);
	
    if ($db->query()) {
	
      
	  $query='SELECT AVG(`rate`) as `average`, COUNT(`rate`) as `rate_count` FROM #__bwg_image_rate WHERE image_id='.$image_id;
	  $db->setQuery($query);
	  $rates=$db->loadObject();
	
	  
	  $query="UPDATE #__bwg_image SET avg_rating=".(int)$rates->average.",rate_count=".$rates->rate_count." WHERE id=".$image_id;
$db->setQuery( $query)      ;
$db->query();
      
    }
    
  }
  
  if ($flag) {

	    $mainframe->redirect( "index.php?option=com_gallery_wd&view=rates",'Items Succesfully Deleted.','message');
    }
    else {
	  $mainframe->redirect( "index.php?option=com_gallery_wd&view=rates",'You must select at least one item.','error');

    }
    $this->display();
  
 }
	}	
		
}