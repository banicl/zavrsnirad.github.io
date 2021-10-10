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


class gallery_wdControllerThemes extends JControllerForm
{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$input = JFactory::getApplication()->input;
        $input->set('view', 'themes');

	}


			public function getModel($name = 'themes', $prefix = 'gallery_wdModel', $config = array('ignore_request' => true))
			{
				$model = parent::getModel($name, $prefix, $config);

				return $model;
			}
			
	public	function add()
		{

			$input = JFactory::getApplication()->input;
			$input->set('view', $input->get('view', 'themes'));
			parent::display();
		}	

	public	function edit($key = null, $urlVar = null)
		{
			$input = JFactory::getApplication()->input;
			$input->set('view', $input->get('view', 'themes'));
			parent::display();
		}		

    public function cancel($key = null) 
		{
		$mainframe = JFactory::getApplication();
		$mainframe->redirect('index.php?option=com_gallery_wd&view=themes');
		}
		

	  public function reset() {
		JRequest::setVar('reset',1);
		JRequest::setVar('task','edit');
		JRequest::setVar('id',JRequest::getVar('id'));
		JRequest::setVar('current_type',JRequest::getVar('current_type'));
			parent::display();
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

foreach($cid as $key=>$id)
{
$query="SELECT default_theme FROM #__bwg_theme where id=".$db->escape($id);
$db->setQuery($query);
$default_theme=$db->loadResult();

if($default_theme==1)
{
unset($cid[$key]);
break;
}

}
 // If any item selected
  if (count( $cid )) {
    // Prepare sql statement, if cid array more than one, 
    // will be "cid1, cid2, ..."
    $cids = implode( ',', $cid );
    // Create sql statement

if($cids=='')
$query = 'DELETE FROM #__bwg_theme  WHERE id = '.$db->escape(JRequest::getVar('current_id'));
else
$query = 'DELETE FROM #__bwg_theme  WHERE id IN ( '. $db->escape($cids) .' )';


    $db->setQuery( $query );
    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";  
    }
  }
  
  
  // After all, redirect again to frontpage
  $mainframe->redirect( "index.php?option=com_gallery_wd&view=themes",'','message');
	
}

public function setdefault() {
  $db =JFactory::getDBO();
  $id=JRequest::getVar('current_id');
  $query="UPDATE #__bwg_theme SET default_theme=0 WHERE default_theme=1";
  $db->setQuery($query);
  $db->query();
  
    $query="UPDATE #__bwg_theme SET default_theme=1 WHERE id=".$db->escape($id);
  $db->setQuery($query);
  $db->query();
  

	parent::display();
  }


	
	
	
	
	public function save_theme()
	{
	 $db =JFactory::getDBO();
	$this->save_db();

   JFactory::getApplication()->enqueueMessage('Item Succesfully Saved.');
   JRequest::setVar('view','themes');
	parent::display();
	}	
		
	public function apply_theme() 	
	{
	  $mainframe = JFactory::getApplication();
	 $db =JFactory::getDBO();
	$this->save_db();
    $id=JRequest::getVar('id');
    if ($id=='') {
      $query="SELECT MAX(`id`) FROM #__bwg_theme";
	  $db->setQuery($query);
	  $id = $db->loadResult();
	  JRequest::setVar('id',$id);
    }

   $mainframe->redirect( 'index.php?option=com_gallery_wd&view=themes&task=edit&cid[]='.$id.'&current_type='.JRequest::getVar('current_type'),'','message' );
   
	}

	
  public function save_db() {

	$row =JTable::getInstance('themes', 'gallery_wdTable');
	
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	
	
	
	
	
	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}


	
 }
  

		
}