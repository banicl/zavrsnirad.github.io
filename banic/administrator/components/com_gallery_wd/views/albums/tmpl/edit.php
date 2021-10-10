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
JHTML::_('behavior.modal');


	$editor	=JFactory::getEditor();
 global $WD_BWG_UPLOAD_DIR;
    $row = $this->get_row_data;
		$row->preview_image=htmlspecialchars($row->preview_image);

	$cid=JRequest::getVar('cid',0);
	$id=$cid[0];
	if(!isset($cid[0]))
	$id=0;
    $page_title = (($id != 0) ? 'Edit album ' . $row->name : 'Create new album');
    ?>
    <div style="font-size: 14px; font-weight: bold;">
      This section allows you to add/edit album.
      <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/joomla-gallery-guide-step-4.html">Read More in User Manual</a>
    </div>
		      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="http://web-dorado.com/products/joomla-gallery.html">
          <img width="215" border="0" alt="http://web-dorado.com" src="<?php echo WD_BWG_URL . '/images/logo.png'; ?>" />
        </a>
      </div>
    <script>
      function bwg_add_preview_image(files) {
        document.getElementById("preview_image").value = files[0]['thumb_url'];
        document.getElementById("button_preview_image").style.display = "none";
        document.getElementById("delete_preview_image").style.display = "inline-block";
        if (document.getElementById("img_preview_image")) {
          document.getElementById("img_preview_image").src = files[0]['reliative_url'];
          document.getElementById("img_preview_image").style.display = "inline-block";
        }
      }

      function bwg_add_items(trackIds, titles, types) {
        var tbody = document.getElementById('tbody_albums_galleries');
        var counter = 0;
        for(i = 0; i < trackIds.length; i++) {          
          tr = document.createElement('tr');
          tr.setAttribute('id', "tr_0:" + types[i] + ":" + trackIds[i]);
          tr.setAttribute('style', 'height:35px');
          
          var td_drag = document.createElement('td');
          td_drag.setAttribute('class','connectedSortable table_small_col');
          td_drag.setAttribute('title','Drag to re-order');
          
          var div_drag = document.createElement('div');
          div_drag.setAttribute('class', 'handle');
          
          td_drag.appendChild(div_drag);
          tr.appendChild(td_drag);          
          
          var td_title = document.createElement('td');
          td_title.setAttribute('style', 'max-width:420px;min-width:400px;');
          td_title.innerHTML = (types[i] == '1' ? 'Album: ' : 'Gallery: ') + titles[i];
          
          tr.appendChild(td_title);
          
          var td_delete = document.createElement('td');
          td_delete.setAttribute('class', 'table_small_col');
          
          var span_del = document.createElement('span');
          span_del.setAttribute('class', 'spider_delete_img');
          span_del.setAttribute('onclick', 'spider_remove_row("tbody_albums_galleries", event, this);');
          
          td_delete.appendChild(span_del);
          tr.appendChild(td_delete);
          
          tbody.appendChild(tr);
          counter++;
        }
        if (counter) {
          document.getElementById("table_albums_galleries").style.display = "block";
        }
        spider_sortt('tbody_albums_galleries');
           window.parent.SqueezeBox.close();
      }
	   
	   
	   window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});

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
</style>
    <form class="wrap" id="adminForm" name="adminForm" method="post" action="index.php?option=com_gallery_wd&view=albums" style="width:95%;">
      <span class="album-icon"></span>
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
			  <?php echo $editor->display('description',$row->description,'100%','250','40','6');?>
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
              <a href="index.php?option=com_gallery_wd&view=filemanager&extensions=jpg,jpeg,png,gif&callback=bwg_add_preview_image&tmpl=component"
                 id="button_preview_image"
                 class="button-primary thickbox thickbox-preview modal"
                 title="Add Preview Image"
                 onclick="return false;"
                 style="margin-bottom:5px; display:none;" rel="{handler: 'iframe', size: {x: 700, y: 600}}">
                Add Preview Image
              </a>
              <input type="hidden" id="preview_image" name="preview_image" value="<?php echo $row->preview_image; ?>" style="display:inline-block;"/>
              <img id="img_preview_image"
                   style="max-height:90px; max-width:120px; vertical-align:middle;"
                   src="<?php echo JURI::root().WD_BWG_UPLOAD_DIR.'/' . $row->preview_image; ?>">
              <span id="delete_preview_image" class="spider_delete_img"
                    onclick="spider_remove_url('button_preview_image', 'preview_image', 'delete_preview_image', 'img_preview_image')"></span>
            </td>
          </tr>
          <tr>
            <td class="spider_label"><label for="content-add_media">Albums And Galleries: </label></td>
            <td>
              <a href="index.php?option=com_gallery_wd&view=addAlbumsGalleries&album_id=<?php echo $id ?>&width=700&height=550" class="button-primary thickbox thickbox-preview modal" id="content-add_media" title="Add Images" onclick="return false;" style="margin-bottom:5px;" rel="{handler: 'iframe', size: {x: 700, y: 550}}">
                Add Albums/Galleries
              </a>              
              <?php $albums_galleries = $this->get_albums_galleries_rows_data ?>
              <table id="table_albums_galleries" class="widefat spider_table" <?php echo (($albums_galleries) ? '' : 'style="display:none;"'); ?>>          
                <tbody id="tbody_albums_galleries">
                  <?php
                  if ($albums_galleries) {
                    $hidden = "";
                    foreach($albums_galleries as $alb_gal) {
                      if ($alb_gal) {
                        ?>
                        <tr id="tr_<?php echo $alb_gal->id . ":" . $alb_gal->is_album . ":" . $alb_gal->alb_gal_id ?>" style="height:35px;">
                          <td class="connectedSortable table_small_col" title="Drag to re-order"><div class="handle"></div></td>
                          <td style="max-width:420px; min-width:400px;"><?php echo ($alb_gal->is_album ? 'Album: ' : 'Gallery: ') . $alb_gal->name; ?></td>
                          <td class="table_small_col">
                            <span class="spider_delete_img" onclick="spider_remove_row('tbody_albums_galleries', event, this)"/>
                          </td>
                        </tr>
                        <?php
                        $hidden .= $alb_gal->id . ":" . $alb_gal->is_album . ":" . $alb_gal->alb_gal_id . ",";
                      }
                    }
                  }
                  ?>
                </tbody>
              </table>
              <input type="hidden" value="<?php echo isset($hidden) ? $hidden : ''; ?>" id="albums_galleries" name="albums_galleries"/>
            </td>
          </tr>          
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value="" />
      <input id="current_id" name="current_id" type="hidden" value="<?php echo $row->id; ?>" />
	  <input type="hidden" name="id" value="<?php echo $row->id ?>" />
	<input type="hidden" name="order" value="<?php echo $row->order ?>" />
 				<?php echo JHtml::_( 'form.token' ); ?>	

      <script>
        jQuery(window).load(function() {
          spider_reorder_items('tbody_albums_galleries');
        });
        <?php
        if ($row->preview_image == '') {
          ?>
          spider_remove_url('button_preview_image', 'preview_image', 'delete_preview_image', 'img_preview_image');
          <?php
        }
        ?>
      </script>
    </form>
    <?php
  
    function get_user_name($user_id)
{
       $db =JFactory::getDBO();
	   $query="SELECT name FROM #__users WHERE id=".$db->escape($user_id);
	   $db->setQuery($query);
	   $user_name=$db->loadResult();
	   return $user_name;
}  

  
