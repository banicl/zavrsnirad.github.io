<?php
 /**
 * @package Gallery WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/ 
 
 defined('_JEXEC') or die('Restricted access');


require_once 'components/com_gallery_wd/controller.php';
class gallery_wdControllerGallerybox extends gallery_wdController {
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
        $input->set('view', 'gallerybox');
        $input->set('format', 'row');

    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
	



    public function display() {
        parent::display();
    }

	
	
	public function ajax_search() {
    $ajax_task = JRequest::getVar('ajax_task');

    if ($ajax_task!='') {
      $this->$ajax_task();
    }
    else {
      $this->display();
    }
  }
	
public function delete() {
	$db =JFactory::getDBO();
	$user = JFactory::getUser();
    $comment_id =(int)$db->escape(JRequest::getVar('comment_id',0));
    $image_id = (int)$db->escape(JRequest::getVar('image_id',0));
	$query="DELETE FROM #__bwg_image_comment WHERE id=".$db->escape($comment_id)." AND user_id=".(int)$db->escape($user->id);
	$db->setQuery($query);
	$db->query();
	
	$query="UPDATE #__bwg_image SET comment_count=comment_count-1 WHERE id=".(int)$db->escape($image_id);
	$db->setQuery($query);
	$db->query();  
    $this->display();
  }
	
	public function save_comment()
	{
	    $db =JFactory::getDBO();
	$query="SELECT * FROM #__bwg_option WHERE id=1";
    $db->setQuery($query);
    $option_row=$db->loadObject();
$user = JFactory::getUser();
$user_id=$user->id;
if($user->id==0)
$user_id='-1';


    if ($option_row->popup_enable_email) {
      // Email validation.
      $email = (isset($_POST['bwg_email']) ? $this->is_email(stripslashes($_POST['bwg_email'])) : FALSE);
    }
    else {
      $email = TRUE;
    }
    if ($option_row->popup_enable_captcha) {
      $bwg_captcha_input = (isset($_POST['bwg_captcha_input']) ? htmlspecialchars(stripslashes($_POST['bwg_captcha_input'])) : '');
      @session_start();
      $bwg_captcha_code = (isset($_SESSION['bwg_captcha_code']) ? htmlspecialchars(stripslashes($_SESSION['bwg_captcha_code'])) : '');
      if ($bwg_captcha_input === $bwg_captcha_code) {
        $captcha = TRUE;
      }
      else {
        $captcha = FALSE;
      }
    }
    else {
      $captcha = TRUE;
    }

    if ($email && $captcha) {

	$row =JTable::getInstance('comment', 'gallery_wdTable');
if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}
      $name = $db->escape(JRequest::getVar('bwg_name'));
      $bwg_comment = $db->escape(JRequest::getVar('bwg_comment'));
      $bwg_email = $db->escape(JRequest::getVar('bwg_email'));
	  $image_id = (int)$db->escape(JRequest::getVar('image_id',0));
	  $row->image_id=$image_id;
	  $row->name=$name;
	  $row->date=date('Y-m-d H:i');
	  $row->comment=$bwg_comment;
	  $row->mail=$bwg_email;
	  $row->published=(!$option_row->comment_moderation) ? 1 : 0;
	  $row->user_id=$user_id;
	  
	  
	  $query="UPDATE #__bwg_image SET comment_count=comment_count+1 WHERE id=".(int)$db->escape($row->image_id);
	  $db->setQuery( $query);
	  $db->query();
      
	 if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
    }
    $this->display();
	
	
	}

	
	function is_Email($mail)
 {
 if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
      return false;
    }
 
 }
 
 
   public function save_rate() {
   $db=JFactory::getDBO();
	$row =JTable::getInstance('rate', 'gallery_wdTable');
	
	
    $image_id = $db->escape(JRequest::getVar('image_id',0));
    $rate = $db->escape(JRequest::getVar('rate',''));
    
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}

	$row->image_id=$image_id;
	$row->rate=$rate;
	$row->ip=$_SERVER['REMOTE_ADDR'];
	$row->date=date('Y-m-d H:i:s');
	
	
	
 if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
	
	$query="SELECT AVG(`rate`) as `average`, COUNT(`rate`) as `rate_count` FROM #__bwg_image_rate WHERE image_id=".(int)$image_id;
	$db->setQuery($query);
	$rates=$db->loadObject();
      
	  
	  $query="UPDATE #__bwg_image SET avg_rating= ".$rates->average." , rate_count=".$rates->rate_count." WHERE id=".(int)$image_id;
	  $db->setQuery($query);
	  $db->query();
     
    
    $this->display();
  }

  public function save_hit_count() {
  $db=JFactory::getDBO();
 $image_id = $db->escape(JRequest::getVar('image_id',0));
 $query='UPDATE #__bwg_image SET hit_count = hit_count + 1 WHERE id='.(int)$image_id;
 	  $db->setQuery($query);
	  $db->query();
  }
 
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}