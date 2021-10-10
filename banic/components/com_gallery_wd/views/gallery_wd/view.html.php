<?php

 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');


class gallery_wdViewgallery_wd extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Assign data to the view
	 $bwg=0;

			$model = $this->getModel();
			$from=JRequest::getVar('from');
			if($from!='module')
			{
			$app = JFactory::getApplication('site');
			$componentParams = $app->getParams();
			
			  $values= explode('**PARAM**',JRequest::getVar('param',$componentParams->get('params')));
   
				   $params=array();
				   foreach($values as $param)
				   {
				   $par_s=explode('=',$param);
				   $params[$par_s[0]]=$par_s[1];
				   }
		
		if (isset($params['type'])) {
			  $type = $params['type'];
			}
			else {
			  $type = "";
			}
			  if (isset($params['type'])) {
			  $images_per_page = $params['images_per_page'];
			}
			else {
			  $images_per_page = "";
			}
			
			
		if($params['gallery_type']=='slideshow' OR $params['gallery_type']=='image_browser' OR $params['gallery_type']=='blog_style')
			{
			  $images_per_page = '';
			}
			else {
			  $images_per_page = $params['images_per_page'];
			}
			
			
			
			
			if($params['gallery_type']=='image_browser')
			$images_per_page=1;
			if($params['gallery_type']=='blog_style')
			$images_per_page=$params['blog_style_images_per_page'];
			

			$this->params=$params;
			switch($params['gallery_type'])
			{
			case 'thumbnails':
			case 'thumbnails_masonry':
			case 'slideshow':
			case 'image_browser':
			case 'blog_style':
			$this->get_gallery_row_data=$model->get_gallery_row_data($params['gallery_id']);
			$this->get_image_rows_data=$model->get_image_rows_data($params['gallery_id'],  $images_per_page, $params['sort_by'], 0,$type,$params['order_by']);
			$this->page_nav=$model->page_nav($params['gallery_id'],  $images_per_page, 0,$type);
			break;
			
			
			case 'album_compact_preview':
			case 'album_extended_preview':
			$type_compat = (isset($_POST['type_' . $bwg]) ? htmlspecialchars($_POST['type_' . $bwg]) : (isset($params['type']) ? $params['type'] : 'album'));
			if ($type_compat == 'gallery') {
			  $items_per_page = $params['images_per_page'];
			  }
			else
			{
			      $items_per_page = $params['albums_per_page'];
			}
			$album_gallery_id = (isset($_POST['album_gallery_id_' . $bwg]) ? htmlspecialchars($_POST['album_gallery_id_' . $bwg]) : $params['album_id']);
			$this->get_image_rows_data=$model->get_image_rows_data($album_gallery_id, $items_per_page, $params['sort_by'], 0);
			$this->gallery_page_nav=$model->gallery_page_nav($album_gallery_id, $items_per_page, 0);
			$this->get_alb_gals_row=$model->get_alb_gals_row($album_gallery_id, $items_per_page, 'order', 0);
			$this->album_page_nav=$model->album_page_nav($album_gallery_id, $items_per_page, 0);
		    break;
			}
			
			
			$this->get_theme_row_data=$model->get_theme_row_data($params['theme_id']);
			$this->get_options_row_data=$model->get_options_row_data();
			$this->_layout=$params['gallery_type'];
			}
			else
			{
			
			$gal_id=JRequest::getVar('gallery_id');
			$theme_id=JRequest::getVar('theme_id');
			$this->get_gallery_row_data=$model->get_gallery_row_data($gal_id);
			$this->get_image_rows_data=$model->get_image_rows_data($gal_id,  '', 'order', 0,'',$params['order_by']);
			$this->page_nav=$model->page_nav($gal_id,  '', 0,'');
			$this->get_theme_row_data=$model->get_theme_row_data($theme_id);
			$this->get_options_row_data=$model->get_options_row_data();
			$this->_layout='thumbnails';
			}
			
		// Display the view
		parent::display($tpl);
	}
	
	
	

	
	
}
