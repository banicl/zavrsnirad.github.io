<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal', 'a.modal', array('onClose'=>'\function() {jQuery(\'#no_selection\').remove();	jQuery(\'#sbox-content\').css(\'display\',\'\');}'));


		JRequest::setVar( 'hidemainmenu', 1 );
		JRequest::setVar( 'hidemainmenu', 1 );
	$editor	=JFactory::getEditor();
$row = $this->row;
	$row->preview_image=htmlspecialchars($row->preview_image);

	    $rows_data = $this->rows_data;
    $page_nav = $this->page_nav;
	$option_row=$this->get_option_rows_data;
$id=JRequest::getVar('id');
    $page_title = (($id != 0) ? 'Edit gallery ' . $row->name : 'Create new gallery');
    require_once(WD_BWG_DIR . '/framework/WDWLibrary.php');

    ?>
    <div style="font-size: 14px; font-weight: bold;">
      This section allows you to add/edit gallery.
      <a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/joomla-gallery-guide-step-2.html">Read More in User Manual</a>
    </div>
		      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/products/joomla-gallery.html">
          <img width="215" border="0" alt="https://web-dorado.com" src="<?php echo WD_BWG_URL . '/images/logo.png'; ?>" />
        </a>
      </div>
    <script>
     

	 	
	 Joomla.submitbutton=function(pressbutton) 
	{
		var form = document.adminForm;

		if (pressbutton == 'galleries.apply_gallery') 
		{
         if (spider_check_required('name', 'Name')) {return false;};
             spider_set_input_value('page_number', '1');
            spider_set_input_value('ajax_task', 'ajax_apply');
           spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
		   return false;
		}
		if (pressbutton == 'galleries.save_gallery') 
		{
         if (spider_check_required('name', 'Name')) {return false;};
             spider_set_input_value('page_number', '1');
            spider_set_input_value('ajax_task', 'ajax_save');
           spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
		   return false;
		}
		submitform( pressbutton );
	}
	 

	 function spider_set_href(a, number, type) {
        var image_url = document.getElementById("image_url_" + number).value;
        var thumb_url = document.getElementById("thumb_url_" + number).value;
        a.href='index.php?option=com_gallery_wd&view=editThumb&width=800&height=500&type=' + type + '&image_id=' + number + '&image_url=' + image_url + '&thumb_url=' + thumb_url;

      }
      function bwg_add_preview_image(files) {
	
        document.getElementById("preview_image").value = files[0]['thumb_url'];
        document.getElementById("button_preview_image").style.display = "none";
        document.getElementById("delete_preview_image").style.display = "inline-block";
        if (document.getElementById("img_preview_image")) {
          document.getElementById("img_preview_image").src = files[0]['reliative_url'];
          document.getElementById("img_preview_image").style.display = "inline-block";
        }
      }
	  
	  function add_modal()
	  {
	  window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});
	  }
	  
	  
      var j_int = 0;
      var j = 'pr_' + j_int;
      function bwg_add_image(files) {
	
        var tbody = document.getElementById('tbody_arr');
        for (var i=0; i<files.length;i++) {
          var is_video = files[i]['filetype'] == 'YOUTUBE' || files[i]['filetype'] == 'VIMEO';

          var tr = document.createElement('tr');
          tr.setAttribute('id', "tr_" + j);
          if (tbody.firstChild) {
            tbody.insertBefore(tr, tbody.firstChild);
          }
          else {
            tbody.appendChild(tr);
          }
          // Handle TD.
          var td_handle = document.createElement('td');
          td_handle.setAttribute('class', "connectedSortable table_small_col");
          td_handle.setAttribute('title', "Drag to re-order");
          tr.appendChild(td_handle);
          var div_handle = document.createElement('div');
          div_handle.setAttribute('class', "handle connectedSortable");
          div_handle.setAttribute('style', "margin: 5px auto 0px;");
          td_handle.appendChild(div_handle);
          // Checkbox TD.
          var td_checkbox = document.createElement('td');
          td_checkbox.setAttribute('class', "table_small_col check-column");
          tr.appendChild(td_checkbox);
          var input_checkbox = document.createElement('input');
          input_checkbox.setAttribute('id', "check_" + j);
          input_checkbox.setAttribute('name', "check_" + j);
          input_checkbox.setAttribute('type', "checkbox");
          td_checkbox.appendChild(input_checkbox);
          // Thumb TD.
          var td_thumb = document.createElement('td');
          td_thumb.setAttribute('class', "table_extra_large_col");
          tr.appendChild(td_thumb);
          var a_thumb = document.createElement('a');
          a_thumb.setAttribute('class', "modal"); 
		  a_thumb.setAttribute('rel', "{handler: 'iframe', size: {x: 650, y: 500}}");
          a_thumb.setAttribute('href', "index.php?option=com_gallery_wd&view=editThumb&type=display&width=650&height=500&image_id=" + j + "&TB_iframe=1");
          a_thumb.setAttribute('title', files[i]['name']);
          td_thumb.appendChild(a_thumb);
          var img_thumb = document.createElement('img');
          img_thumb.setAttribute('id', "image_thumb_" + j);
          img_thumb.setAttribute('class', "thumb");
		  if(!is_video)
          img_thumb.setAttribute('src', '<?php echo JURI::root() .'/'.WD_BWG_UPLOAD_DIR ?>/'+files[i]['thumb_url']);
		  else
		    img_thumb.setAttribute('src', files[i]['thumb_url']);
          a_thumb.appendChild(img_thumb);
          // Filename TD.
          var td_filename = document.createElement('td');
          td_filename.setAttribute('class', "table_extra_large_col");
          tr.appendChild(td_filename);
          var div_filename = document.createElement('div');
          div_filename.setAttribute('class', "filename");
          div_filename.setAttribute('id', "filename_" + j);
          td_filename.appendChild(div_filename);
          var strong_filename = document.createElement('strong');
          div_filename.appendChild(strong_filename);
          var a_filename = document.createElement('a');
		  a_filename.setAttribute('class', "modal"); 
		  a_filename.setAttribute('rel', "{handler: 'iframe', size: {x: 800, y: 500}}");
          a_filename.setAttribute('href', "index.php?option=com_gallery_wd&view=editThumb&type=display&width=800&height=500&image_id=" + j);
          a_filename.setAttribute('class', "spider_word_wrap modal");
          a_filename.setAttribute('title', files[i]['filename']);
          a_filename.innerHTML = files[i]['filename'];
          strong_filename.appendChild(a_filename);
          var div_date_modified = document.createElement('div');
          div_date_modified.setAttribute('class', "fileDescription");
          div_date_modified.setAttribute('title', "Date modified");
          div_date_modified.setAttribute('id', "date_modified_" + j);
          div_date_modified.innerHTML = files[i]['date_modified'];
          td_filename.appendChild(div_date_modified);
          var div_fileresolution = document.createElement('div');
          div_fileresolution.setAttribute('class', "fileDescription");
          div_fileresolution.setAttribute('title', "Image Resolution");
          div_fileresolution.setAttribute('id', "fileresolution" + j);
          div_fileresolution.innerHTML = files[i]['resolution'];
          td_filename.appendChild(div_fileresolution);
          var div_filesize = document.createElement('div');
          div_filesize.setAttribute('class', "fileDescription");
          div_filesize.setAttribute('title', (!is_video) ? "Image size" : "Duration");
          div_filesize.setAttribute('id', "filesize" + j);
          div_filesize.innerHTML = files[i]['size'];
          td_filename.appendChild(div_filesize);
          var div_filetype = document.createElement('div');
          div_filetype.setAttribute('class', "fileDescription");
          div_filetype.setAttribute('title', "Image type");
          div_filetype.setAttribute('id', "filetype" + j);
          div_filetype.innerHTML = files[i]['filetype'];
          td_filename.appendChild(div_filetype);
		  
		if (!is_video) {
          var div_edit = document.createElement('div');
          td_filename.appendChild(div_edit);
          var span_edit_crop = document.createElement('span');
          span_edit_crop.setAttribute('class', "edit_thumb");
          div_edit.appendChild(span_edit_crop);
          var a_crop = document.createElement('a');
		  a_crop.setAttribute('class', "modal");
		  a_crop.setAttribute('rel', "{handler: 'iframe', size: {x: 800, y: 500}}");
          a_crop.setAttribute('onclick', "spider_set_href(this, '" + j + "', 'crop');");
          a_crop.innerHTML = "Crop";
          span_edit_crop.appendChild(a_crop);
          div_edit.innerHTML += " | ";
          var span_edit_rotate = document.createElement('span');
          span_edit_rotate.setAttribute('class', "edit_thumb");
          div_edit.appendChild(span_edit_rotate);
          var a_rotate = document.createElement('a');
          a_rotate.setAttribute('class', "modal");
		  a_rotate.setAttribute('rel', "{handler: 'iframe', size: {x: 800, y: 500}}");
          a_rotate.setAttribute('onclick', "spider_set_href(this, '" + j + "', 'rotate');");
          a_rotate.innerHTML = "Rotate";
          span_edit_rotate.appendChild(a_rotate);
          div_edit.innerHTML += " | "
          var span_edit_recover = document.createElement('span');
          span_edit_recover.setAttribute('class', "edit_thumb");
          div_edit.appendChild(span_edit_recover);
          var a_recover = document.createElement('a');
          a_recover.setAttribute('onclick', 'if (confirm("Do you want to reset the image?")) { spider_set_input_value("ajax_task", "recover"); spider_set_input_value("image_current_id", "' + j + '"); spider_ajax_save("adminForm","","<?php echo JSession::getFormToken() ?>");} return false;');
          a_recover.innerHTML = "Reset";
          span_edit_recover.appendChild(a_recover);
		  }
		  
          var input_image_url = document.createElement('input');
          input_image_url.setAttribute('id', "image_url_" + j);
          input_image_url.setAttribute('name', "image_url_" + j);
          input_image_url.setAttribute('type', "hidden");
          input_image_url.setAttribute('value', files[i]['url']);
          td_filename.appendChild(input_image_url);
          var input_thumb_url = document.createElement('input');
          input_thumb_url.setAttribute('id', "thumb_url_" + j);
          input_thumb_url.setAttribute('name', "thumb_url_" + j);
          input_thumb_url.setAttribute('type', "hidden");
          input_thumb_url.setAttribute('value', files[i]['thumb_url']);
          td_filename.appendChild(input_thumb_url);
          var input_filename = document.createElement('input');
          input_filename.setAttribute('id', "input_filename_" + j);
          input_filename.setAttribute('name', "input_filename_" + j);
          input_filename.setAttribute('type', "hidden");
          input_filename.setAttribute('value', files[i]['filename']);
          td_filename.appendChild(input_filename);
          var input_date_modified = document.createElement('input');
          input_date_modified.setAttribute('id', "input_date_modified_" + j);
          input_date_modified.setAttribute('name', "input_date_modified_" + j);
          input_date_modified.setAttribute('type', "hidden");
          input_date_modified.setAttribute('value', files[i]['date_modified']);
          td_filename.appendChild(input_date_modified);
          var input_resolution = document.createElement('input');
          input_resolution.setAttribute('id', "input_resolution_" + j);
          input_resolution.setAttribute('name', "input_resolution_" + j);
          input_resolution.setAttribute('type', "hidden");
          input_resolution.setAttribute('value', files[i]['resolution']);
          td_filename.appendChild(input_resolution);
          var input_size = document.createElement('input');
          input_size.setAttribute('id', "input_size_" + j);
          input_size.setAttribute('name', "input_size_" + j);
          input_size.setAttribute('type', "hidden");
          input_size.setAttribute('value', files[i]['size']);
          td_filename.appendChild(input_size);
          var input_filetype = document.createElement('input');
          input_filetype.setAttribute('id', "input_filetype_" + j);
          input_filetype.setAttribute('name', "input_filetype_" + j);
          input_filetype.setAttribute('type', "hidden");
          input_filetype.setAttribute('value', files[i]['filetype']);
          td_filename.appendChild(input_filetype);
          // Alt/Title TD.
          var td_alt = document.createElement('td');
          td_alt.setAttribute('class', "table_extra_large_col");
          tr.appendChild(td_alt);
          var input_alt = document.createElement('input');
          input_alt.setAttribute('id', "image_alt_text_" + j);
          input_alt.setAttribute('name', "image_alt_text_" + j);
          input_alt.setAttribute('type', "text");
          input_alt.setAttribute('size', "24");
		  

            input_alt.setAttribute('value', files[i]['name']);
          
        
          td_alt.appendChild(input_alt);
		            <?php if ($option_row->thumb_click_action != 'open_lightbox') { ?>
          //Redirect url
          input_alt = document.createElement('input');
          input_alt.setAttribute('id', "redirect_url_" + j);
          input_alt.setAttribute('name', "redirect_url_" + j);
          input_alt.setAttribute('type', "text");
          input_alt.setAttribute('size', "24");
          td_alt.appendChild(input_alt);
          <?php } ?>
          // Description TD.
          var td_desc = document.createElement('td');
          td_desc.setAttribute('class', "table_extra_large_col");
          tr.appendChild(td_desc);
          var textarea_desc = document.createElement('textarea');
          textarea_desc.setAttribute('id', "image_description_" + j);
          textarea_desc.setAttribute('name', "image_description_" + j);
          textarea_desc.setAttribute('rows', "2");
          textarea_desc.setAttribute('cols', "20");
          textarea_desc.setAttribute('style', "resize:vertical;");
		  if (is_video) {
            textarea_desc.innerHTML = files[i]['description'];
          }
          td_desc.appendChild(textarea_desc);
          // Tag TD.
          var td_tag = document.createElement('td');
          td_tag.setAttribute('class', "table_extra_large_col");
          tr.appendChild(td_tag);
          var a_tag = document.createElement('a');
          a_tag.setAttribute('class', "modal button-primary");
		  a_tag.setAttribute('rel', "{handler: 'iframe', size: {x: 650, y: 500}}");
          a_tag.setAttribute('href', "index.php?option=com_gallery_wd&view=addTags&width=650&height=500&image_id=" + j);
          a_tag.innerHTML = 'Add tag';
          td_tag.appendChild(a_tag);
          var div_tag = document.createElement('div');
          div_tag.setAttribute('class', "tags_div");
          div_tag.setAttribute('id', "tags_div_" + j);
          td_tag.appendChild(div_tag);
          var hidden_tag = document.createElement('input');
          hidden_tag.setAttribute('type', "hidden");
          hidden_tag.setAttribute('id', "tags_" + j);
          hidden_tag.setAttribute('name', "tags_" + j);
          hidden_tag.setAttribute('value', "");
          td_tag.appendChild(hidden_tag);
          // Order TD.
          var td_order = document.createElement('td');
          td_order.setAttribute('class', "spider_order table_medium_col");
          td_order.setAttribute('style', "display: none;");
          tr.appendChild(td_order);
          var input_order = document.createElement('input');
          input_order.setAttribute('id', "order_input_" + j);
          input_order.setAttribute('name', "order_input_" + j);
          input_order.setAttribute('type', "text");
          input_order.setAttribute('value', 1 + j_int);
          input_order.setAttribute('size', "1");
          td_order.appendChild(input_order);
          // Publish TD.
          var td_publish = document.createElement('td');
          td_publish.setAttribute('class', "table_big_col");
          tr.appendChild(td_publish);
          var a_publish = document.createElement('a');
          a_publish.setAttribute('onclick', "spider_set_input_value('ajax_task', 'image_unpublish');spider_set_input_value('image_current_id', '" + j + "');spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');");
          td_publish.appendChild(a_publish);
          var img_publish = document.createElement('img');
          img_publish.setAttribute('src', "<?php echo '../components/com_gallery_wd/images/publish.png'; ?>");
          a_publish.appendChild(img_publish);
          // Delete TD.
          var td_delete = document.createElement('td');
          td_delete.setAttribute('class', "table_big_col");
          tr.appendChild(td_delete);
          var a_delete = document.createElement('a');
          a_delete.setAttribute('onclick', "spider_set_input_value('ajax_task', 'image_delete');spider_set_input_value('image_current_id', '" + j + "');spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');");
          a_delete.innerHTML = 'Delete';
          td_delete.appendChild(a_delete);
          document.getElementById("ids_string").value += j + ',';
          j_int++;
          j = 'pr_' + j_int;
          jQuery("#show_hide_weights").val("Hide order column");
          spider_show_hide_weights();
        }
		add_modal();

jQuery('#sbox-overlay').css('height',jQuery(document).height())
		
      }


    </script>
<style>
.editor
{
position: relative;
z-index: 5;
overflow: visible;
}

#description_ifr
{
height:200px !important;
}


#adminForm input[type="radio"]
{
margin:0px
}

#adminForm label
{
display: inline-block;
}
textarea,input[type="text"]
{
width: 150px;
}

</style>
    <form class="wrap" method="post" id="adminForm" name="adminForm" action="index.php?option=com_gallery_wd&view=galleries" style="width:95%;">

	 <span class="gallery-icon"></span>
      <h2><?php echo $page_title; ?></h2>

      <table style="clear:both;">
        <tbody>
          <tr>
            <td class="spider_label"><label for="name">Name: <span style="color:#FF0000;">*</span> </label></td>
            <td><input type="text" id="name" name="name" value="<?php echo $row->name; ?>" size="39" /></td>
          </tr>
          <tr>
            <td class="spider_label"><label for="slug">Slug: </label></td>
            <td><input type="text" id="slug" name="slug" value="<?php echo $row->slug; ?>" size="39" /></td>
          </tr>
          <tr>
            <td class="spider_label"><label for="description">Description: </label></td>
            <td>
              <div style="width:520px;">

			  <?php echo $editor->display('description',$row->description,'500', '200', '20', '20');?>
              </div>
            </td>
          </tr>
          <tr>
            <td class="spider_label"><label>Author: </label></td>
            <td><?php echo get_user_name($row->author); ?></td>
          </tr>
          <tr>
            <td class="spider_label"><label for="published1">Published: </label></td>
            <td>
              <input type="radio" class="inputbox" id="published0" name="published" <?php echo (($row->published) ? '' : 'checked="checked"'); ?> value="0" >
              <label for="published0">No</label>
              <input type="radio" class="inputbox" id="published1" name="published" <?php echo (($row->published) ? 'checked="checked"' : ''); ?> value="1" >
              <label for="published1">Yes</label>
            </td>
          </tr>
          <tr>
            <td class="spider_label"><label for="url">Preview image: </label></td>
            <td>
              <a  href="index.php?option=com_gallery_wd&view=filemanager&extensions=jpg,jpeg,png,gif&callback=bwg_add_preview_image&tmpl=component"
                 id="button_preview_image"
                 class="button-primary modal"
                 title="Add Preview Image"
                 onclick="return false;"
                 style="margin-bottom:5px; display:none;" rel="{handler: 'iframe', size: {x: 700, y: 600}}" >
                Add Preview Image
              </a>
              <input type="hidden" id="preview_image" name="preview_image" value="<?php echo $row->preview_image; ?>" style="display:inline-block;"/>
              <img id="img_preview_image"
                   style="max-height:90px; max-width:120px; vertical-align:middle;"
                   src="<?php echo JURI::root().WD_BWG_UPLOAD_DIR.'/'.$row->preview_image; ?>">
              <span id="delete_preview_image" class="spider_delete_img"
                    onclick="spider_remove_url('button_preview_image', 'preview_image', 'delete_preview_image', 'img_preview_image')"></span>
            </td>
          </tr>

          <tr>
            <td colspan=2>
              <?php
              echo image_display($id, $rows_data,$page_nav,$this->get_option_rows_data);
              ?>
            </td>
          </tr>
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value="" />
      <input id="current_id" name="current_id" type="hidden" value="<?php echo $row->id; ?>" />
	  <input type="hidden" name="id" value="<?php echo $row->id ?>" />
	  <input type="hidden" name="order" id="order" value="<?php echo $row->order ?>" />
	  		<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" /> 
		<?php echo JHtml::_( 'form.token' ); ?>	
			
      <script>
        <?php
        if ($row->preview_image == '') {
          ?>
          spider_remove_url('button_preview_image', 'preview_image', 'delete_preview_image', 'img_preview_image');
          <?php
        }
        ?>
      </script>
	  
	        <div id="opacity_div" style="display: none; background-color: rgba(0, 0, 0, 0.2); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99998;"></div>
      <div id="loading_div" style="display:none; text-align: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999;">
        <img src="<?php echo WD_BWG_URL . '/images/ajax_loader.png'; ?>" class="spider_ajax_loading" style="margin-top: 200px; width:50px;">
      </div>
	  
    </form>
    <?php

 function image_display($id,$rows_data,$page_nav,$option_row) {
    global $WD_BWG_UPLOAD_DIR;

    $search_value = JRequest::getVar('search_value');
    $asc_or_desc = JRequest::getVar('asc_or_desc','asc');
    $image_order_by = JRequest::getVar('image_order_by','order');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    ?>

      <div id="draganddrop" class="updated" style="display:none;"><strong><p>Changes made in this table should be saved.</p></strong></div>
	   <div class="buttons_div_left">
	   	   <?php
        $query_url = array_to_url(array('view' => 'filemanager', 'width' => '700', 'height' => '550', 'extensions' => 'jpg,jpeg,png,gif', 'callback' => 'bwg_add_image'));
		?>
	   
      <a style="margin: 5px 0;" href="index.php?option=com_gallery_wd&view=filemanager&extensions=jpg,jpeg,png,gif&callback=bwg_add_image&tmpl=component" class="button-primary modal" id="content-add_media" title="Add Images" onclick="return false;" style="margin-bottom:5px;"  rel="{handler: 'iframe', size: {x: 700, y: 600}}">
        Add Images
      </a>
	  
	  	          <script>
          var ajax_url = "<?php echo $query_url; ?>"
        </script>
      <input id="show_add_video" class="button-primary" type="button" onclick="jQuery('.opacity_add_video').show(); return false;" value="Add Video" />
	  </div>
	  
	  
	  
	  <div class="buttons_div_right">
                <span class="button-secondary non_selectable" onclick="spider_check_all_items()">
          <input type="checkbox" id="check_all_items" name="check_all_items" onclick="spider_check_all_items_checkbox()" style="margin: 0; vertical-align: middle;" />
          <span style="vertical-align: middle;">Select All</span>
        </span>
        <input id="show_hide_weights"  class="button-secondary" type="button" onclick="spider_show_hide_weights();return false;" value="Hide order column" />
        <input class="button-primary" type="submit" onclick="spider_set_input_value('ajax_task', 'image_set_watermark');
                                                             spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
                                                             return false;" value="Set Watermark" />

        <input class="button-secondary" type="submit" onclick="jQuery('.opacity_resize_image').show(); return false;" value="Resize" />															 
        <input class="button-secondary" type="submit" onclick="spider_set_input_value('ajax_task', 'image_recover_all');
                                                             spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
                                                             return false;" value="Reset" />

															 
<a onclick="return bwg_check_checkboxes();" href="index.php?option=com_gallery_wd&view=addTags" rel="{handler: 'iframe', size: {x: 800, y: 500}}" class="button-primary modal">Add tag</a>


        <input class="button-secondary" type="submit" onclick="spider_set_input_value('ajax_task', 'image_publish_all');
                                                     spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
                                                     return false;" value="Publish" />
        <input class="button-secondary" type="submit" onclick="spider_set_input_value('ajax_task', 'image_unpublish_all');
                                                     spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
                                                     return false;" value="Unpublish" />
        <input class="button-secondary" type="submit" onclick="if (confirm('Do you want to delete selected items?')) {
                                                       spider_set_input_value('ajax_task', 'image_delete_all');
                                                       spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
                                                       return false;
                                                     } else {
                                                       return false;
                                                     }" value="Delete" />
      </div>
	  
	        <div id="opacity_add_video" class="opacity_resize_image opacity_add_video bwg_opacity_video" onclick="jQuery('.opacity_add_video').hide();jQuery('.opacity_resize_image').hide();"></div>
			<div id="add_video" class="opacity_add_video bwg_add_video">
        <input type="text" id="video_url" name="video_url" value="" />
        <input class="button-primary" type="button" onclick="if (bwg_get_video_info('video_url')) {jQuery('.opacity_add_video').hide();} return false;" value="Add to gallery" />
        <input class="button-secondary" type="button" onclick="jQuery('.opacity_add_video').hide(); return false;" value="Cancel" />
        <div class="spider_description">Enter YouTube or Vimeo link here.</div>
      </div>
      <div id="" class="opacity_resize_image bwg_resize_image">
        Resize images to: 
        <input type="text" name="image_width" id="image_width" value="1600" /> x 
        <input type="text" name="image_height" id="image_height" value="1200" /> px
        <input class="button-primary" type="button" onclick="spider_set_input_value('ajax_task', 'image_resize');
                                                             spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
                                                             jQuery('.opacity_resize_image').hide();
                                                             return false;" value="Resize" />
        <input class="button-secondary" type="button" onclick="jQuery('.opacity_resize_image').hide(); return false;" value="Cancel" />
        <div class="spider_description">The maximum size of resized image.</div>
      </div>
	  
      <div class="tablenav top">
        <?php
        WDWLibrary::ajax_search('Filename', $search_value, 'adminForm', JSession::getFormToken());
        WDWLibrary::ajax_html_page_nav($page_nav['total'], $page_nav['limit'], 'adminForm', JSession::getFormToken());
        ?>
      </div>

      <table id="images_table" class="table table-striped">
        <thead>
          <th class="check-column table_small_col"></th>
          <th class="manage-column column-cb check-column table_small_col">
		  <input id="check_all" type="checkbox" onclick="spider_check_all(this)" style="margin:0;" /></th>
          <th class="table_extra_large_col">Thumbnail</th>
          <th class="table_extra_large_col <?php if ($image_order_by == 'filename') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('image_order_by', 'filename');
                        spider_set_input_value('asc_or_desc', '<?php echo (($image_order_by == 'filename' && $asc_or_desc== 'asc') ? 'desc' : 'asc'); ?>');
                        spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');">
              <span>Filename</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_extra_large_col <?php if ($image_order_by == 'alt') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('image_order_by', 'alt');
                        spider_set_input_value('asc_or_desc', '<?php echo (($image_order_by == 'alt') && $asc_or_desc == 'asc' ? 'desc' : 'asc'); ?>');
                        spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');">
              <span>Alt/Title<?php if ($option_row->thumb_click_action != 'open_lightbox') { ?><br />Redirect URL<?php } ?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_extra_large_col <?php if ($image_order_by == 'description') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('image_order_by', 'description');
                        spider_set_input_value('asc_or_desc', '<?php echo (($image_order_by == 'description' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');">
              <span>Description</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_extra_large_col">Tags</th>
          <th id="th_order" class="table_medium_col <?php if ($image_order_by == 'order') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('image_order_by', 'order');
                        spider_set_input_value('asc_or_desc', '<?php echo (($image_order_by == 'order' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');">
              <span>Order</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col <?php if ($image_order_by == 'published') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('image_order_by', 'published');
                        spider_set_input_value('asc_or_desc', '<?php echo (($image_order_by == 'published' && $asc_or_desc == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');">
              <span>Published</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col">Delete</th>
        </thead>
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
            foreach ($rows_data as $row_data) {
						$row_data->filename=htmlspecialchars($row_data->filename);
			$row_data->thumb_url=htmlspecialchars($row_data->thumb_url);
	
			  $is_video = $row_data->filetype == 'YOUTUBE' || $row_data->filetype == 'VIMEO';
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              $rows_tag_data =get_tag_rows_data($row_data->id);
              $published_image = (($row_data->published) ? 'publish' : 'unpublish');
              $published = (($row_data->published) ? 'unpublish' : 'publish');
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="connectedSortable table_small_col"><div title="Drag to re-order" class="handle" style="margin:5px auto 0 auto;"></div></td>
                <td class="table_small_col check-column"><input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>"  type="checkbox" /></td>
                <td class="table_extra_large_col">
                  <a class="modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}"  title="<?php echo $row_data->filename; ?>" href="index.php?option=com_gallery_wd&view=editThumb&type=display&image_id=<?php echo $row_data->id ?>&width=800&height=500">
                    <img id="image_thumb_<?php echo $row_data->id; ?>" class="thumb" src="<?php echo (!$is_video ? JURI::root().WD_BWG_UPLOAD_DIR.'/' : ""). $row_data->thumb_url . '?date=' . date('Y-m-y H:i:s'); ?>">
                  </a>
                </td>
                <td class="table_extra_large_col">
                  <div class="filename" id="filename_<?php echo $row_data->id; ?>">
                    <strong><a title="<?php echo $row_data->filename; ?>" rel="{handler: 'iframe', size: {x: 800, y: 500}}" class="spider_word_wrap modal" href="index.php?option=com_gallery_wd&view=editThumb&type=display&image_id=<?php echo $row_data->id ?>&width=800&height=500"><?php echo $row_data->filename; ?></a></strong>
                  </div>
                  <div class="fileDescription" title="Date modified" id="date_modified_<?php echo $row_data->id; ?>"><?php echo date("d F Y, H:i", strtotime($row_data->date)); ?></div>
                  <div class="fileDescription" title="Image Resolution" id="fileresolution_<?php echo $row_data->id; ?>"><?php echo $row_data->resolution; ?></div>
                  <div class="fileDescription" title="<?php echo (!$is_video ? "Image size" : "Duration")?>" id="filesize_<?php echo $row_data->id; ?>"><?php echo $row_data->size; ?></div>
                  <div class="fileDescription" title="Image type" id="filetype_<?php echo $row_data->id; ?>"><?php echo $row_data->filetype; ?></div>
				  
				  <?php if(!$is_video) {?>
                  <div>
                    
					
					<span class="edit_thumb"><a class="modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}" 
					
					href="index.php?option=com_gallery_wd&view=editThumb&type=crop&image_id=<?php echo $row_data->id ?>&width=800&height=500">Crop</a>
					
					
					</span> | 
                    <span class="edit_thumb"><a class="modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}" 
					href="index.php?option=com_gallery_wd&view=editThumb&type=rotate&image_id=<?php echo $row_data->id ?>&width=800&height=500">Rotate</a></span> | 
                    <span class="edit_thumb"><a onclick="if (confirm('Do you want to reset the image?')) {
                                                          spider_set_input_value('ajax_task', 'recover');
                                                          spider_set_input_value('image_current_id', '<?php echo $row_data->id; ?>');
                                                          spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');
                                                         }
                                                         return false;">Reset</a></span>
                  </div>
				  <?php } ?>
                  <input type="hidden" id="image_url_<?php echo $row_data->id; ?>" name="image_url_<?php echo $row_data->id; ?>" value="<?php echo $row_data->image_url; ?>" />
                  <input type="hidden" id="thumb_url_<?php echo $row_data->id; ?>" name="thumb_url_<?php echo $row_data->id; ?>" value="<?php echo $row_data->thumb_url; ?>" />
                  <input type="hidden" id="input_filename_<?php echo $row_data->id; ?>" name="input_filename_<?php echo $row_data->id; ?>" value="<?php echo $row_data->filename; ?>" />
                  <input type="hidden" id="input_date_modified_<?php echo $row_data->id; ?>" name="input_date_modified_<?php echo $row_data->id; ?>" value="<?php echo $row_data->date; ?>" />
                  <input type="hidden" id="input_resolution_<?php echo $row_data->id; ?>" name="input_resolution_<?php echo $row_data->id; ?>" value="<?php echo $row_data->resolution; ?>" />
                  <input type="hidden" id="input_size_<?php echo $row_data->id; ?>" name="input_size_<?php echo $row_data->id; ?>" value="<?php echo $row_data->size; ?>" />
                  <input type="hidden" id="input_filetype_<?php echo $row_data->id; ?>" name="input_filetype_<?php echo $row_data->id; ?>" value="<?php echo $row_data->filetype; ?>" />
                </td>
                <td class="table_extra_large_col">
                  <input size="24" type="text" id="image_alt_text_<?php echo $row_data->id; ?>" name="image_alt_text_<?php echo $row_data->id; ?>" value="<?php echo $row_data->alt; ?>" />
				                    <?php if ($option_row->thumb_click_action != 'open_lightbox') { ?>
                  <input size="24" type="text" id="redirect_url_<?php echo $row_data->id; ?>" name="redirect_url_<?php echo $row_data->id; ?>" value="<?php echo $row_data->redirect_url; ?>" />
                  <?php } ?>
				  
				  
                </td>
                <td class="table_extra_large_col">
                  <textarea cols="20" rows="2" id="image_description_<?php echo $row_data->id; ?>" name="image_description_<?php echo $row_data->id; ?>" style="resize:vertical;"><?php echo $row_data->description; ?></textarea>
                </td>
                <td class="table_extra_large_col">
                <a class="modal button-primary" rel="{handler: 'iframe', size: {x: 700, y: 600}}" href="index.php?option=com_gallery_wd&view=addTags&image_id=<?php echo $row_data->id ?>&width=650&height=500" class="button button-small button-primary modal">Add tag</a>
                  <div class="tags_div" id="tags_div_<?php echo $row_data->id; ?>">
                  <?php
                  $tags_id_string = '';
                  if ($rows_tag_data) {
                    foreach($rows_tag_data as $row_tag_data) {
                      ?>
                      <div class="tag_div" id="<?php echo $row_data->id; ?>_tag_<?php echo $row_tag_data->term_id; ?>">
                        <span class="tag_name"><?php echo $row_tag_data->name; ?></span>
                        <span style="float:right;" class="spider_delete_img_small" onclick="bwg_remove_tag('<?php echo $row_tag_data->term_id; ?>', '<?php echo $row_data->id; ?>')" />
                      </div>
                      <?php
                      $tags_id_string .= $row_tag_data->term_id . ',';
                    }
                  }
                  ?>
                  </div>
                  <input type="hidden" value="<?php echo $tags_id_string; ?>" id="tags_<?php echo $row_data->id; ?>" name="tags_<?php echo $row_data->id; ?>"/>
                </td>
                <td class="spider_order table_medium_col"><input id="order_input_<?php echo $row_data->id; ?>" name="order_input_<?php echo $row_data->id; ?>" type="text" size="1" value="<?php echo $row_data->order; ?>" /></td>
                <td class="table_big_col"><a onclick="spider_set_input_value('ajax_task', 'image_<?php echo $published; ?>');
                                                      spider_set_input_value('image_current_id', '<?php echo $row_data->id; ?>');
                                                      spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');"><img src="<?php echo  '../components/com_gallery_wd/images/' . $published_image . '.png'; ?>"></img></a>
													  </td>
                <td class="table_big_col"><a onclick="spider_set_input_value('ajax_task', 'image_delete');
                                                      spider_set_input_value('image_current_id', '<?php echo $row_data->id; ?>');
                                                      spider_ajax_save('adminForm','','<?php echo JSession::getFormToken() ?>');">Delete</a></td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
		
            }
			
          }
          ?>

          <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
          <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc" />
          <input id="image_order_by" name="image_order_by" type="hidden" value="<?php echo $image_order_by; ?>" />
          <input id="ajax_task" name="ajax_task" type="hidden" value="" />
          <input id="image_current_id" name="image_current_id" type="hidden" value="" />
			<input id="added_tags_select_all" name="added_tags_select_all" type="hidden" value="" />
		  	
        </tbody>
      </table>

      <script>
	  
	  jQuery('#tbody_arr').sortable({stop: function(event,ui){

if(jQuery('#asc_or_desc').val()=='asc')
i=1;
else
i=jQuery('#tbody_arr').find('tr').length;


jQuery('#tbody_arr').find('tr').each(
function()
{

jQuery(this).children()[7].childNodes[0].value=i;

if(jQuery('#asc_or_desc').val()=='asc')
i++;
else
i--


}
)


}})





        window.onload = spider_show_hide_weights;
		spider_run_checkbox()
      </script>
    <?php
  }
  
  function get_user_name($user_id)
{
       $db =JFactory::getDBO();
	   $query="SELECT name FROM #__users WHERE id=".(int)$db->escape($user_id);
	   $db->setQuery($query);
	   $user_name=$db->loadResult();
	   return $user_name;
}  
	
	
   function get_tag_rows_data($image_id) {
       $db =JFactory::getDBO();
    $query="SELECT table1.id as term_id,table1.name,table1.slug  FROM #__bwg_tags AS table1 INNER JOIN #__bwg_image_tag AS table2 ON table1.id=table2.tag_id WHERE table2.image_id=".(int)$db->escape($image_id)." ORDER BY table2.tag_id";
	$db->setQuery($query);
	$rows=$db->loadObjectList();

    return $rows;
  }
  
  	function array_to_url($array)
	{
		$url='index.php?option=com_gallery_wd&';
		foreach($array as $key=>$params_value)
		{
		if($key!='watermark_position')
		$url.=$key.'='.$params_value.'&';
		}
		
		return $url;
	}