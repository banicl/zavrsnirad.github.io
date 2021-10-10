<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Restricted access');

require_once 'components/com_gallery_wd/controller.php';
require_once WD_BWG_DIR . '/framework/WDWLibrary.php';
class gallery_wdControllerOptions extends gallery_wdController {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    public $uploads_dir;
    public $uploads_url;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function __construct() {
        parent::__construct();
		$input = JFactory::getApplication()->input;
        $input->set('view', 'options');


    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
	



    public function display($cachable = false, $urlparams = array()) {
        parent::display();
    }

	
	
	public function reset()
	{
	 		JSession::checkToken() or die( 'Invalid Token' );
	
	JRequest::setVar('reset',1);
	 parent::display();
	
	}
	
	public function save_option()
	{
	 		JSession::checkToken() or die( 'Invalid Token' );
	
	$mainframe = JFactory::getApplication();
	
	$msg='';
	$row =JTable::getInstance('options', 'gallery_wdTable');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
	

	if (JRequest::getVar('old_images_directory')!='') {
      $old_images_directory = htmlspecialchars(stripslashes(JRequest::getVar('old_images_directory')));
    }
    if (JRequest::getVar('images_directory')!='') {
      $images_directory = htmlspecialchars(stripslashes(JRequest::getVar('images_directory')));
      if (!is_dir(JPATH_ROOT.'/' . $images_directory)) {
        $msg='Uploads directory doesn\'t exist. Old value is restored.';
		$msg_type='error';
		
		if ($old_images_directory) {
          $images_directory = $old_images_directory;
        }
        else {
          $upload_dir = JPATH_ROOT.'/administrator/components/com_gallery_wd/uploads';
          if (!is_dir($upload_dir . '/com_gallery_wd')) {
            mkdir($upload_dir . '/com_gallery_wd', 0777);
          }
          $images_directory = str_replace(JPATH_ROOT, '', $upload_dir);
        }
      }
    }
    else {
      $upload_dir = JPATH_ROOT.'/administrator/components/com_gallery_wd/uploads';
      if (!is_dir($upload_dir . '/com_gallery_wd')) {
        mkdir($upload_dir . '/com_gallery_wd', 0777);
      }
      $images_directory = str_replace(JPATH_ROOT, '', $upload_dir);
    }
	
	
	
	$row->images_directory=$images_directory;
	$row->gallery_role=0;
	$row->album_role=0;
	$row->image_role=0;
	
	
	
	$row->id=1;
		if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	else
	{
	 if ($old_images_directory && $old_images_directory != $images_directory) {
        rename(JPATH_ROOT.'/' . $old_images_directory . '/com_gallery_wd', JPATH_ROOT.'/' . $images_directory . '/com_gallery_wd');
      }
      if (!is_dir(JPATH_ROOT.'/' . $images_directory . '/com_gallery_wd')) {
        mkdir(JPATH_ROOT.'/' . $images_directory . '/com_gallery_wd', 0777);
      }
        
		if($msg=='')
		{
	    $msg='Item Succesfully Saved.';
		$msg_type='message';
		}
	  
	}
	
	
	$mainframe->redirect('index.php?option=com_gallery_wd&view=options&type='.JRequest::getVar('type'), $msg,$msg_type);
	 parent::display();
	}
 
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}