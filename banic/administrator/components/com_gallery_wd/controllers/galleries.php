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


class gallery_wdControllerGalleries extends JControllerForm
{

	public function __construct($config = array())
	{
		parent::__construct($config);
		
		
	}


			public function getModel($name = 'galleries', $prefix = 'gallery_wdModel', $config = array('ignore_request' => true))
			{
				$model = parent::getModel($name, $prefix, $config);

				return $model;
			}
			
	public	function add()
		{

			$input = JFactory::getApplication()->input;
			$input->set('view', $input->get('view', 'galleries'));
			parent::display();
		}	

	public	function edit($key = null, $urlVar = null)
		{

			$input = JFactory::getApplication()->input;
			$input->set('view', $input->get('view', 'galleries'));
			parent::display();
		}		

    public function cancel($key = null) 
		{
		$mainframe = JFactory::getApplication();
		$mainframe->redirect('index.php?option=com_gallery_wd&view=galleries');
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

	

	
    $query = 'DELETE FROM #__bwg_gallery  WHERE id IN ( '. $db->escape($cids) .' )';
    $db->setQuery( $query );
    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";  
    }
  
  $query = 'DELETE FROM #__bwg_image  WHERE gallery_id IN ( '. $db->escape($cids) .' )';
      $db->setQuery( $query );
	    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";  
    }

  $query = 'DELETE FROM #__bwg_album_gallery  WHERE alb_gal_id IN ( '. $db->escape($cids) .' ) AND is_album=0';
    $db->setQuery( $query );
	    if (!$db->query()) {
      echo "<script> alert('".$db->getErrorMsg(true)."'); 
      window.history.go(-1); </script>\n";  
    }
	
  }
  // After all, redirect again to frontpage
  $mainframe->redirect( "index.php?option=com_gallery_wd",'','message');
	
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
  $query = 'UPDATE #__bwg_gallery' . ' SET published = '.(int) $db->escape($state) .' WHERE id IN ( '. $db->escape($cids) .' )'  ;
  // Execute query
  $db->setQuery( $query );
  if (!$db->query()) {
    JError::raiseError(500, $db->getErrorMsg() );
  }
  if (count( $cid ) == 1) {
    $row =JTable::getInstance('galleries', 'gallery_wdTable');
    $row->checkin( intval( $cid[0] ) );
  }
  }
  // After all, redirect to front page
  $mainframe->redirect( 'index.php?option=com_gallery_wd','','message' );
}
	
	public function ajax_save()
	{
	/*$db =JFactory::getDBO();
	//$this->save_db();

    $id=JRequest::getVar('id');
    if ($id=='') {
      $query="SELECT MAX(`id`) FROM #__bwg_gallery";
	  $db->setQuery($query);
	

	  $id = $db->loadResult();
	    JRequest::setVar('id',$id);
    }
   //$this->save_image_db();*/
   JFactory::getApplication()->enqueueMessage('Item Succesfully Saved.');
   JRequest::setVar('view','galleries');
	parent::display();
	}	
		
	public function apply_gallery() 	
	{

	  $mainframe = JFactory::getApplication();
	 $db =JFactory::getDBO();

	//$this->save_db();

    $id=JRequest::getVar('id');
    if ($id=='') {
      $query="SELECT MAX(`id`) FROM #__bwg_gallery";
	  $db->setQuery($query);
	

	  $id = $db->loadResult();
	    JRequest::setVar('id',$id);
    }

	
    /*$this->save_image_db();
   echo $id;
exit; */  
   $mainframe->redirect( 'index.php?option=com_gallery_wd&task=edit&cid[]='.$id,'','message' );
   
	}
		
	public function save_order()
		{
		    $db =JFactory::getDBO();
			
			$query="SELECT id FROM #__bwg_gallery";
			$db->setQuery($query);
			$gallery_ids_col=$db->loadColumn();

    if ($gallery_ids_col) {
      foreach ($gallery_ids_col as $gallery_id) {
        if (isset($_POST['order_input_' . $gallery_id])) {
          $order_values[$gallery_id] = (int) $_POST['order_input_' . $gallery_id];
        }
        else {
		$query="SELECT `order` FROM #__bwg_gallery WHERE `id`=".(int)$db->escape($gallery_id);
		$db->setQuery($query);
		$order_values[$gallery_id]=$db->loadResult();
        }
      }
      asort($order_values);
      $i = 1;
      foreach ($order_values as $key => $order_value) {
	  $query="UPDATE #__bwg_gallery SET `order`=".(int)$db->escape($i)." WHERE id=".(int)$db->escape($key);
     $db->setQuery($query);
	 $db->query();
        $i++;
      }
	   JFactory::getApplication()->enqueueMessage('Ordering Succesfully updated.');
    }
	

   JRequest::setVar('view','galleries');
	parent::display();
			
		}
	
  public function save_db() {
     $user = JFactory::getUser();
    $db =JFactory::getDBO();
	$id = JRequest::getVar('current_id',0);     
	$row =JTable::getInstance('galleries', 'gallery_wdTable');
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}

	if($row->order==0)
	{
	$query="SELECT MAX(`order`) FROM #__bwg_gallery";
	$db->setQuery($query);
	$max_order=$db->loadResult();
	$row->order=$max_order+1;
	}
 
	
	if($row->name=='')
	$row->name=$this->bwg_get_unique_name('Gallery', $id);
	else
	$row->name=$this->bwg_get_unique_name($row->name, $id);
	
	if($row->slug=='')
	$row->slug=$this->bwg_get_unique_slug($row->name, $id);
	
	if($row->preview_image=='')
    {
      if ($id != 0) {
        $query="SELECT random_preview_image FROM #__bwg_gallery WHERE id=".(int)$db->escape($id);
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
	
  }



  public function bwg_get_unique_name($name, $id) {
   
    $db =JFactory::getDBO();
	
    if ($id != 0) {
      $query = "SELECT name FROM #__bwg_gallery WHERE name = '".$db->escape($name)."' AND id != ".(int)$db->escape($id);
    }
    else {
      $query = "SELECT name FROM #__bwg_gallery WHERE name ='".$db->escape($name)."'";
    }
	$db->setQuery($query);
    
	if ($db->loadResult()) {
      $num = 2;
      do {
        $alt_name = $name . "-$num";
        $num++;
		$query_slug="SELECT name FROM #__bwg_gallery WHERE name ='".$db->escape($alt_name)."'";
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
      $query = "SELECT slug FROM #__bwg_gallery WHERE slug = '". $db->escape($slug)."' AND id != ".(int)$db->escape($id);
    }
    else {
      $query = "SELECT slug FROM #__bwg_gallery WHERE slug ='".$db->escape($slug)."'" ;
    }
	$db->setQuery($query);
    
	if ($db->loadResult()) {
      $num = 2;
      do {
        $alt_slug = $slug . "-$num";
        $num++;
		$query_slug="SELECT slug FROM #__bwg_gallery WHERE slug ='".$db->escape($alt_slug)."'";
		$db->setQuery($query_slug);
        $slug_check = $db->loadResult;
      } while ($slug_check);
      $slug = $alt_slug;
    }
    return $slug;
  }  
	
	
	  public function save_image_db() {
    $db =JFactory::getDBO();
	     $user = JFactory::getUser();
		$mainframe = JFactory::getApplication();
	
 
 	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));
	$gal_id 	= $cid[0];
 
	$gal_id=JRequest::getVar('id',0);

	if($gal_id=='')
	$gal_id=0;
    $image_ids =JRequest::getVar('ids_string');

    $image_id_array = explode(',', $image_ids);
	

    foreach ($image_id_array as $key=>$image_id) {
      if ($image_id) {

	  
	  $row =JTable::getInstance('image', 'gallery_wdTable');
	  
	if(!$row->bind(JRequest::get('post')))
	{
		JError::raiseError(500, $row->getError() );
	}

	if(substr($image_id,0,3)=='pr_')
	{

	$row->id='';
	$id='-1';
	}
	else
	{
	$row->id=$image_id;
	$id=$image_id;
	}
	 
	 $query="SELECT published FROM #__bwg_image WHERE id=".(int)$db->escape($id);
	 $db->setQuery($query);
	 $published=$db->loadResult();
	 
	 if( $published=='')
	  $published=1;
	 
	 $row->gallery_id=$gal_id;
	  $row->filename=JRequest::getVar('input_filename_' . $image_id);
	  $row->image_url=JRequest::getVar('image_url_' . $image_id);
	  $row->thumb_url=JRequest::getVar('thumb_url_' . $image_id);
	  $row->description=JRequest::getVar('image_description_' . $image_id);
	  $row->alt=JRequest::getVar('image_alt_text_' . $image_id);
	  $row->date=JRequest::getVar('input_date_modified_' . $image_id);
	  $row->size=JRequest::getVar('input_size_' . $image_id);
	  $row->filetype=JRequest::getVar('input_filetype_' . $image_id);
	  $row->resolution=JRequest::getVar('input_resolution_' . $image_id);
	  $row->order=JRequest::getVar('order_input_' . $image_id);
	  $row->redirect_url=JRequest::getVar('redirect_url_' . $image_id);
	  $row->published= $published;

	  $row->author=$user->id;
	  $row->slug=$row->alt;


        $tags_ids =JRequest::getVar('tags_' . $image_id);

	   	if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	}
      
	  $query="SELECT MAX(`id`) FROM #__bwg_image";
	  $db->setQuery($query);
	  $new_image_id=$db->loadResult();
	  
	  if(substr($image_id,0,3)=='pr_')
	{
  if (JRequest::getVar('check_' . $image_id)!="") {
            JRequest::setVar('check_' . $new_image_id,'on');
          }
	  

		 $image_current_id= JRequest::getVar('image_current_id');
        if ($image_current_id ==$image_id AND substr($image_current_id,0,3) =='pr_') {
            JRequest::setVar('image_current_id', $new_image_id) ; 
		}
		$image_id= $new_image_id;
}
		///////TAGS START

		$query="SELECT tag_id FROM #__bwg_image_tag WHERE image_id=".$db->escape($row->id)." AND gallery_id=".(int)$db->escape($gal_id);
		$db->setQuery($query);
		$deleted_tag=$db->loadResult();

		$query="DELETE FROM #__bwg_image_tag WHERE image_id=".(int)$db->escape($row->id)." AND gallery_id=".(int)$db->escape($gal_id);

		$db->setQuery($query);
		$db->query();
 
 if($deleted_tag)
 {
        $query="SELECT COUNT(image_id) FROM #__bwg_image_tag WHERE tag_id=".(int)$db->escape($deleted_tag);
	    $db->setQuery($query);
	 $image_count=$db->loadResult();
			  
	 $query="UPDATE #__bwg_tags SET count=".(int)$image_count." WHERE id=".(int)$db->escape($deleted_tag);
	$db->setQuery($query);
	 $db->query();
			  
 }
 
 
          $tag_id_array = explode(',', $tags_ids);
		  
          foreach ($tag_id_array as $tag_id) {
            if ($tag_id) {
              if (substr($tag_id,0,3)=='pr_') {
                $tag_id = substr($tag_id, 3);
              }
			  

			  $query="INSERT INTO #__bwg_image_tag VALUES ('','".$db->escape($tag_id)."','".$db->escape($row->id)."','".$db->escape($gal_id)."')";
			  $db->setQuery($query);
			  $db->query();

              // Increase tag count in term_taxonomy table.
			  $query="SELECT COUNT(image_id) FROM #__bwg_image_tag WHERE tag_id=".(int)$db->escape($tag_id);
			  $db->setQuery($query);
			  $image_count=$db->loadResult();
			  
			  $query="UPDATE #__bwg_tags SET count=".(int)$db->escape($image_count)." WHERE id=".(int)$db->escape($tag_id);
			  $db->setQuery($query);
			  $db->query();
			  
             /*$wpdb->query($wpdb->prepare('UPDATE ' . $wpdb->prefix . 'term_taxonomy SET count="%d" WHERE term_id="%d"', $wpdb->get_var($wpdb->prepare('SELECT COUNT(image_id) FROM ' . $wpdb->prefix . 'bwg_image_tag WHERE tag_id="%d"', $tag_id)), $tag_id));*/
            }
          }
        
      //////////////TAGS END
	  
	  }
    }
  }
	

   public function save_order_images($gallery_id) {
    $db =JFactory::getDBO();
	$query="SELECT id FROM #__bwg_image WHERE `gallery_id`=".(int)$db->escape($gallery_id);
	$db->setQuery($query);
	$p='';
    $imageids_col = $db->loadColumn();
    if ($imageids_col) {
      foreach ($imageids_col as $imageid) {
        if (isset($_POST['order_input_' . $imageid])) {
          $order_values[$imageid] = (int) $_POST['order_input_' . $imageid];
	
        }
        else {
		$query="SELECT `order` FROM #__bwg_image WHERE `id`=".(int)$db->escape($imageid);
		$db->setQuery($query);
        $order_values[$imageid] = $db->loadResult();
        }
		
		
      }
      asort($order_values);
	 
      $i = 1;
      foreach ($order_values as $key => $order_value) {
	  $query="UPDATE #__bwg_image SET `order`=".(int)$db->escape($i)." WHERE `id`=".(int)$db->escape($key);
$db->setQuery($query);
$db->query();
        $i++;
      }

    }
  }	
	
	
	
	
  public function ajax_search() {
  
 		JSession::checkToken() or die( 'Invalid Token' );
 
   $db =JFactory::getDBO();
  	$mainframe = JFactory::getApplication();
    $gallery_id = JRequest::getVar('current_id',0);	
	JRequest::setVar('id',$gallery_id);
	    if ((JRequest::getVar('ajax_task') == 'ajax_apply') || (JRequest::getVar('ajax_task') == 'ajax_save')) {
      // Save gallery on "apply" and "save".
      $this->save_db();
         $id=JRequest::getVar('id');
if($id=='' or $id==0)
{
		  $query="SELECT MAX(`id`) FROM #__bwg_gallery";
		  $db->setQuery($query);
		

		  $id = $db->loadResult();
			JRequest::setVar('id',$id);
			JRequest::setVar('cid[]',$id);
			$gallery_id=$id;
			
			}
    }
	
	if($gallery_id=='')
	$gallery_id=0;
   $this->save_image_db();
    $this->save_order_images($gallery_id);

	$ajax_task = JRequest::getVar('ajax_task');
	//////image ordering start
	$asc_or_desc = JRequest::getVar('asc_or_desc','asc');
    $image_order_by=JRequest::getVar('image_order_by','order');
	if($image_order_by=='')
	$image_order_by='order';
	$page_num=JRequest::getVar('page_number');
	$search_value=JRequest::getVar('search_value');
	///////image ordering end

   if ($ajax_task != '' and $ajax_task !="ajax_apply") {


      $this->$ajax_task();
    }
  	$mainframe->redirect( 'index.php?option=com_gallery_wd&search_value='.$search_value.'&page_number='.$page_num.'&image_order_by='.$image_order_by.'&asc_or_desc='.$asc_or_desc.'&task=edit&cid[]='.$gallery_id,'','message' );
  }	
  

  

  public function image_delete() {

    $db =JFactory::getDBO();
	  $mainframe = JFactory::getApplication();
	  
	  
    $id =JRequest::getVar('image_current_id'); 
	$gal_id=JRequest::getVar('current_id',0); 
	$query='DELETE FROM #__bwg_image WHERE id="'.(int)$db->escape($id).'"';
	$db->setQuery($query);
	$db->query();
	
	$query='DELETE FROM #__bwg_image_comment WHERE image_id="'.(int)$db->escape($id).'"';
	$db->setQuery($query);
	$db->query();
	
	$query="SELECT tag_id FROM #__bwg_image_tag WHERE image_id=".(int)$db->escape($id);
	$db->setQuery($query);
	$tag_ids = $db->loadColumn();
	
	$query='DELETE FROM #__bwg_image_tag WHERE image_id="'.(int)$db->escape($id).'"';
	$db->setQuery($query);
	$db->query();

	if ($tag_ids) {
      foreach ($tag_ids as $tag_id) {
	  $query="SELECT COUNT(image_id) FROM #__bwg_image_tag WHERE tag_id=".(int)$db->escape($tag_id);
	  $db->setQuery($query);
	  $count=$db->loadResult();
	  
	  $query="UPDATE #__bwg_tags SET count='".$count."' WHERE id=".(int)$db->escape($tag_id);
		$db->setQuery($query);
		$db->query();	  
      }
    }
  }
  
  
  public function image_delete_all() {
 $db =JFactory::getDBO();
    $gallery_id = JRequest::getVar('current_id',0);
	if($gallery_id=='')
	$gallery_id=0;
	$query="SELECT id FROM #__bwg_image WHERE gallery_id=".(int)$db->escape($gallery_id);
	$db->setQuery($query);
	$image_ids_col=$db->loadColumn();

	$p='';

    foreach ($image_ids_col as $image_id) {
      if (JRequest::getVar('check_' . $image_id)!='' || JRequest::getVar('check_all_items')!='') {
        $p.=$image_id.' ' ;
		
	$query='DELETE FROM #__bwg_image WHERE id="'.(int)$db->escape($image_id).'"';
	$db->setQuery($query);
	
	$db->query();
	
	$query='DELETE FROM #__bwg_image_comment WHERE image_id="'.(int)$db->escape($image_id).'"';
	$db->setQuery($query);
	$db->query();
	
	$query="SELECT tag_id FROM #__bwg_image_tag WHERE image_id=".(int)$db->escape($image_id);
	$db->setQuery($query);
	$tag_ids = $db->loadColumn();
	
	$query='DELETE FROM #__bwg_image_tag WHERE image_id="'.(int)$db->escape($image_id).'"';
	$db->setQuery($query);
	$db->query();

	if ($tag_ids) {
      foreach ($tag_ids as $tag_id) {
	  $query="SELECT COUNT(image_id) FROM #__bwg_image_tag WHERE tag_id=".(int)$db->escape($tag_id);
	  $db->setQuery($query);
	  $count=$db->loadResult();
	  
	  $query="UPDATE #__bwg_tags SET count='".(int)$db->escape($count)."' WHERE id=".(int)$db->escape($tag_id);
		$db->setQuery($query);
		$db->query();	  
      }
    }
		
		
      }
    }

  }
  
  
  
  
    public function image_publish() {
	    $db =JFactory::getDBO();
    $id =JRequest::getVar('image_current_id') ;
    $query="UPDATE #__bwg_image SET published=1 WHERE id=".(int)$db->escape($id);

    $db->setQuery($query);
	$db->Query();
  }
  
    public function image_publish_all() {
    	    $db =JFactory::getDBO();
    $gallery_id = JRequest::getVar('current_id',0) ;
    if (JRequest::getVar('check_all_items')!='') {
	 $query="UPDATE #__bwg_image SET published=1 WHERE gallery_id=".(int)$db->escape($gallery_id);
    $db->setQuery($query);
	$db->Query();
    }
    else {
		$query="SELECT id FROM #__bwg_image WHERE gallery_id=".(int)$db->escape($gallery_id);
	$db->setQuery($query);

    $image_ids_col = $db->loadObjectList();

      foreach ($image_ids_col as $image_id) {
        if (JRequest::getVar('check_' . $image_id->id)!="") {
		      $query="UPDATE #__bwg_image SET published=1 WHERE id=".(int)$db->escape($image_id->id);

			$db->setQuery($query);
			$db->Query();

        }
      }
    }
  }
  
  public function image_unpublish_all() {
        	    $db =JFactory::getDBO();
    $gallery_id = JRequest::getVar('current_id',0) ;
    if (JRequest::getVar('check_all_items')!='') {
	$query="UPDATE #__bwg_image SET published=0 WHERE gallery_id=".(int)$db->escape($gallery_id);
    $db->setQuery($query);
	$db->Query();
    }
    else {
		$query="SELECT id FROM #__bwg_image WHERE gallery_id=".(int)$db->escape($gallery_id);
	$db->setQuery($query);

    $image_ids_col = $db->loadObjectList();

      foreach ($image_ids_col as $image_id) {
        if (JRequest::getVar('check_' . $image_id->id)!="") {
		      $query="UPDATE #__bwg_image SET published=0 WHERE id=".(int)$db->escape($image_id->id);

			$db->setQuery($query);

			$db->Query();

        }
      }
    }
  }
  
    public function image_unpublish() {
	    $db =JFactory::getDBO();
		$id =JRequest::getVar('image_current_id') ;
		$query="UPDATE #__bwg_image SET published='0' WHERE id='".(int)$db->escape($id)."'";

		$db->setQuery($query);
		$db->Query();
  }
  
  
  public function recover() {
    $db =JFactory::getDBO();
	$gal_id=JRequest::getVar('current_id');
    $id = JRequest::getVar('image_current_id',0);
	$query="SELECT * FROM #__bwg_option WHERE id=1";
    $db->setQuery($query);
    $options=$db->loadObject();
    $thumb_width = $options->thumb_width;
    $thumb_height = $options->thumb_height;    
    $this->recover_image($id, $thumb_width, $thumb_height);
	

  }
  
  
    public function image_recover_all() {
		$db =JFactory::getDBO();
    $gallery_id = JRequest::getVar('current_id');	

	if($gallery_id=='')
	$gallery_id=0;
    $query="SELECT * FROM #__bwg_option WHERE id=1";
  $db->setQuery($query);
	 $options=$db->loadObject();
    $thumb_width = $options->thumb_width;
    $thumb_height = $options->thumb_height;    
    $query="SELECT id FROM #__bwg_image WHERE gallery_id=".(int)$db->escape($gallery_id);

	$db->setQuery($query);
	$image_ids_col=$db->loadColumn();

	
    foreach($image_ids_col as $image_id) {

      if (JRequest::getVar('check_' . $image_id)!='' || JRequest::getVar('check_all_items')!='') {
        $this->recover_image($image_id, $thumb_width, $thumb_height);
      }
    }
	


	
  }
  
  

  public function recover_image($id, $thumb_width, $thumb_height) {
	$db =JFactory::getDBO();
    $query="SELECT * FROM #__bwg_image WHERE id=".(int)$db->escape($id);

  $db->setQuery($query);

  $image_data=$db->loadObject();
    
	$filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->image_url;
    $thumb_filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->thumb_url;
    copy(str_replace('/thumb/', '/.original/', JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->thumb_url), JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->image_url);    
    
	list($width_orig, $height_orig, $type_orig) = getimagesize($filename);
    $percent = $width_orig / $thumb_width;
    $thumb_height = $height_orig / $percent;
	

    ini_set('memory_limit', '-1');
    if ($type_orig == 2) {
      $img_r = imagecreatefromjpeg($filename);
      $dst_r = ImageCreateTrueColor($thumb_width, $thumb_height);
      imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
      imagejpeg($dst_r, $thumb_filename, 100);
      imagedestroy($img_r);
      imagedestroy($dst_r);
    }
    else if ($type_orig == 3) {
      $img_r = imagecreatefrompng($filename);
      $dst_r = ImageCreateTrueColor($thumb_width, $thumb_height);
      imageColorAllocateAlpha($dst_r, 0, 0, 0, 127);
      imagealphablending($dst_r, FALSE);
      imagesavealpha($dst_r, TRUE);
      imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
      imagealphablending($dst_r, FALSE);
      imagesavealpha($dst_r, TRUE);
      imagepng($dst_r, $thumb_filename, 9);
      imagedestroy($img_r);
      imagedestroy($dst_r);
    }
    else if ($type_orig == 1) {
      $img_r = imagecreatefromgif($filename);
      $dst_r = ImageCreateTrueColor($thumb_width, $thumb_height);
      imageColorAllocateAlpha($dst_r, 0, 0, 0, 127);
      imagealphablending($dst_r, FALSE);
      imagesavealpha($dst_r, TRUE);
      imagecopyresampled($dst_r, $img_r, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
      imagealphablending($dst_r, FALSE);
      imagesavealpha($dst_r, TRUE);
      imagegif($dst_r, $thumb_filename);
      imagedestroy($img_r);
      imagedestroy($dst_r);
    }

    ini_restore('memory_limit');
    ?>
    <script language="javascript">
      var image_src = window.parent.document.getElementById("image_thumb_<?php echo $id; ?>").src;
      document.getElementById("image_thumb_<?php echo $id; ?>").src = image_src + "?date=<?php echo date('Y-m-y H:i:s'); ?>";
    </script>
    <?php
  }


  public function image_set_watermark() {
	$db =JFactory::getDBO();
    $query="SELECT * FROM #__bwg_option WHERE id=1";
  $db->setQuery($query);
    
    $options = $db->loadObject();
    $gallery_id = JRequest::getVar('current_id',0);
    if($gallery_id=='')
	$gallery_id=0;
	
	    $query="SELECT * FROM #__bwg_image WHERE gallery_id=".(int)$db->escape($gallery_id);
  $db->setQuery($query);
  
	$images = $db->loadObjectList();

   switch ($options->built_in_watermark_type) {
      case 'text':
        foreach ($images as $image) {

          if (JRequest::getVar('check_' . $image->id)!='' || JRequest::getVar('check_all_items' )!='') {

            $this->set_text_watermark(JPATH_SITE . '/'.WD_BWG_UPLOAD_DIR . $image->image_url, JPATH_SITE . '/'.WD_BWG_UPLOAD_DIR . $image->image_url, $options->built_in_watermark_text, $options->built_in_watermark_font, $options->built_in_watermark_font_size, '#' . $options->built_in_watermark_color, $options->built_in_watermark_opacity, $options->built_in_watermark_position);
          }
        }
        break;
      case 'image':
        foreach ($images as $image) {
          if (JRequest::getVar('check_' . $image->id)!='' || JRequest::getVar('check_all_items' )!='') {
            $this->set_image_watermark (JPATH_SITE . '/'.WD_BWG_UPLOAD_DIR . $image->image_url, JPATH_SITE . '/'.WD_BWG_UPLOAD_DIR . $image->image_url, $options->built_in_watermark_url, $options->built_in_watermark_size, $options->built_in_watermark_size, $options->built_in_watermark_position);
          }
        }
        break;
    }   

	
  }
  
   function bwg_hex2rgb($hex) {

    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    return $rgb;
  }
  
  function bwg_imagettfbboxdimensions($font_size, $font_angle, $font, $text) {

    $box = @ImageTTFBBox($font_size, $font_angle, $font, $text) or die;

    $max_x = max(array($box[0], $box[2], $box[4], $box[6]));
    $max_y = max(array($box[1], $box[3], $box[5], $box[7]));
    $min_x = min(array($box[0], $box[2], $box[4], $box[6]));
    $min_y = min(array($box[1], $box[3], $box[5], $box[7]));

    return array(
      "width"  => ($max_x - $min_x),
      "height" => ($max_y - $min_y)
    );

  }
  
  
  function set_text_watermark($original_filename, $dest_filename, $watermark_text, $watermark_font, $watermark_font_size, $watermark_color, $watermark_transparency, $watermark_position) {

    $watermark_transparency = 127 - ($watermark_transparency * 1.27);
    list($width, $height, $type) = getimagesize($original_filename);
    $watermark_image = imagecreatetruecolor($width, $height);

    $watermark_color = $this->bwg_hex2rgb($watermark_color);
    $watermark_color = imagecolorallocatealpha($watermark_image, $watermark_color[0], $watermark_color[1], $watermark_color[2], $watermark_transparency);

    $watermark_font = WD_BWG_DIR . '/fonts/' . $watermark_font;

    $watermark_font_size = ($height * $watermark_font_size / 500) . 'px';

    $watermark_position = explode('-', $watermark_position);

    $watermark_sizes = $this->bwg_imagettfbboxdimensions($watermark_font_size, 0, $watermark_font, $watermark_text);

    $top = $height - 5;
    $left = $width - $watermark_sizes['width'] - 5;
    switch ($watermark_position[0]) {
      case 'top':
        $top = $watermark_sizes['height'] + 5;
        break;
      case 'middle':
        $top = ($height + $watermark_sizes['height']) / 2;
        break;
    }
    switch ($watermark_position[1]) {
      case 'left':
        $left = 5;
        break;
      case 'center':
        $left = ($width - $watermark_sizes['width']) / 2;
        break;
    }
    ini_set('memory_limit', '-1');
    if ($type == 2) {
      $image = imagecreatefromjpeg($original_filename);
      imagettftext($image, $watermark_font_size, 0, $left, $top, $watermark_color, $watermark_font, $watermark_text);
      imagejpeg ($image, $dest_filename, 100);
      imagedestroy($image);  
    }
    elseif ($type == 3) {
      $image = imagecreatefrompng($original_filename);
      imagettftext($image, $watermark_font_size, 0, $left, $top, $watermark_color, $watermark_font, $watermark_text);
      imageColorAllocateAlpha($image, 0, 0, 0, 127);
      imagealphablending($image, FALSE);
      imagesavealpha($image, TRUE);
      imagepng($image, $dest_filename, 9);
      imagedestroy($image);
    }
    elseif ($type == 1) {
      $image = imagecreatefromgif($original_filename);
      imageColorAllocateAlpha($watermark_image, 0, 0, 0, 127);
      imagecopy($watermark_image, $image, 0, 0, 0, 0, $width, $height);
      imagettftext($watermark_image, $watermark_font_size, 0, $left, $top, $watermark_color, $watermark_font, $watermark_text);
      imagealphablending($watermark_image, FALSE);
      imagesavealpha($watermark_image, TRUE);
      imagegif($watermark_image, $dest_filename);
      imagedestroy($image);
    }
    imagedestroy($watermark_image);
    ini_restore('memory_limit');
	

  }
  
  
  function set_image_watermark($original_filename, $dest_filename, $watermark_url, $watermark_height, $watermark_width, $watermark_position) {
  
    $watermark_url=str_replace(JURI::root(),JPATH_SITE.'/',$watermark_url);

    list($width, $height, $type) = getimagesize($original_filename);
    list($width_watermark, $height_watermark, $type_watermark) = getimagesize($watermark_url);

    $watermark_width = $width * $watermark_width / 100;
    $watermark_height = $height_watermark * $watermark_width / $width_watermark;


    $watermark_position = explode('-', $watermark_position);
    $top = $height - $watermark_height - 5;
    $left = $width - $watermark_width - 5;
    switch ($watermark_position[0]) {
      case 'top':
        $top = 5;
        break;
      case 'middle':
        $top = ($height - $watermark_height) / 2;
        break;
    }
    switch ($watermark_position[1]) {
      case 'left':
        $left = 5;
        break;
      case 'center':
        $left = ($width - $watermark_width) / 2;
        break;
    }
    ini_set('memory_limit', '-1');
    if ($type_watermark == 2) {
      $watermark_image = imagecreatefromjpeg($watermark_url);        
    }
    elseif ($type_watermark == 3) {
      $watermark_image = imagecreatefrompng($watermark_url);
    }
    elseif ($type_watermark == 1) {
      $watermark_image = imagecreatefromgif($watermark_url);      
    }
    else {
      return false;
    }
    
    $watermark_image_resized = imagecreatetruecolor($watermark_width, $watermark_height);
    imagecolorallocatealpha($watermark_image_resized, 255, 255, 255, 127);
    imagealphablending($watermark_image_resized, FALSE);
    imagesavealpha($watermark_image_resized, TRUE);
    imagecopyresampled ($watermark_image_resized, $watermark_image, 0, 0, 0, 0, $watermark_width, $watermark_height, $width_watermark, $height_watermark);
        
    if ($type == 2) {
      $image = imagecreatefromjpeg($original_filename);
      imagecopy($image, $watermark_image_resized, $left, $top, 0, 0, $watermark_width, $watermark_height);
      if ($dest_filename <> '') {
        imagejpeg ($image, $dest_filename, 100); 
      } else {
        header('Content-Type: image/jpeg');
        imagejpeg($image, null, 100);
      };
      imagedestroy($image);  
    }
    elseif ($type == 3) {
      $image = imagecreatefrompng($original_filename);
      imagecopy($image, $watermark_image_resized, $left, $top, 0, 0, $watermark_width, $watermark_height);
      imagealphablending($image, FALSE);
      imagesavealpha($image, TRUE);
      imagepng($image, $dest_filename, 9);
      imagedestroy($image);
    }
    elseif ($type == 1) {
      $image = imagecreatefromgif($original_filename);
      $tempimage = imagecreatetruecolor($width, $height);
      imagecopy($tempimage, $image, 0, 0, 0, 0, $width, $height);
      imagecopy($tempimage, $watermark_image_resized, $left, $top, 0, 0, $watermark_width, $watermark_height);
      imagegif($tempimage, $dest_filename);
      imagedestroy($image);
      imagedestroy($tempimage);
    }
    imagedestroy($watermark_image);
    ini_restore('memory_limit');
  }
  
  
  
  public function image_resize() {
$db=JFactory::getDBO();

    $gallery_id = JRequest::getVar('current_id',0);
    $image_width = JRequest::getVar('image_width',1600);
    $image_height =JRequest::getVar('image_height',1200);
	$query='SELECT * FROM #__bwg_image WHERE gallery_id='.(int)$db->escape($gallery_id);
	$db->setQuery($query);
	$images =$db->loadObjectList();
    foreach ($images as $image) {
      if (JRequest::getVar('check_'. $image->id)!='' ||JRequest::getVar('check_all_items')!='') {

        $this->bwg_scaled_image(JPATH_SITE .'/'. WD_BWG_UPLOAD_DIR .'/'. $image->image_url, $image_width, $image_height);
      }
    }
  }

  function bwg_scaled_image($file_path, $max_width = 0, $max_height = 0, $crop = FALSE) {
    $file_path = htmlspecialchars_decode($file_path, ENT_COMPAT | ENT_QUOTES);
    if (!function_exists('getimagesize')) {
      error_log('Function not found: getimagesize');
      return FALSE;
    }
    list($img_width, $img_height, $type) = @getimagesize($file_path);
    if (!$img_width || !$img_height) {
      return FALSE;
    }
    $scale = min(
      $max_width / $img_width,
      $max_height / $img_height
    );
    ini_set('memory_limit', '-1');
    if (($scale >= 1) || (($max_width === 0) && ($max_height === 0))) {
      // if ($file_path !== $new_file_path) {
        // return copy($file_path, $new_file_path);
      // }
      return TRUE;
    }
    
    if (!function_exists('imagecreatetruecolor')) {
      error_log('Function not found: imagecreatetruecolor');
      return FALSE;
    }
    if (!$crop) {
      $new_width = $img_width * $scale;
      $new_height = $img_height * $scale;
      $dst_x = 0;
      $dst_y = 0;
      $new_img = @imagecreatetruecolor($new_width, $new_height);
    }
    else {
      if (($img_width / $img_height) >= ($max_width / $max_height)) {
        $new_width = $img_width / ($img_height / $max_height);
        $new_height = $max_height;
      }
      else {
        $new_width = $max_width;
        $new_height = $img_height / ($img_width / $max_width);
      }
      $dst_x = 0 - ($new_width - $max_width) / 2;
      $dst_y = 0 - ($new_height - $max_height) / 2;
      $new_img = @imagecreatetruecolor($max_width, $max_height);
    }
    switch ($type) {
      case 2:
        $src_img = @imagecreatefromjpeg($file_path);
        $write_image = 'imagejpeg';
        $image_quality = 90;
        break;
      case 1:
        @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
        $src_img = @imagecreatefromgif($file_path);
        $write_image = 'imagegif';
        $image_quality = NULL;
        break;
      case 3:
        @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
        @imagealphablending($new_img, FALSE);
        @imagesavealpha($new_img, TRUE);
        $src_img = @imagecreatefrompng($file_path);
        $write_image = 'imagepng';
        $image_quality = 9;
        break;
      default:
        $src_img = NULL;
    }
    $success = $src_img && @imagecopyresampled(
      $new_img,
      $src_img,
      $dst_x,
      $dst_y,
      0,
      0,
      $new_width,
      $new_height,
      $img_width,
      $img_height
    ) && $write_image($new_img, $file_path, $image_quality);
    // Free up memory (imagedestroy does not delete files):
    @imagedestroy($src_img);
    @imagedestroy($new_img);
    ini_restore('memory_limit');
    return $success;
  }	
	
	
 
		
		
}