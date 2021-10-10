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

 $rows_data = $this->get_rows_data;
     $pageNav = $this->pageNav;
	
	$lists=$this->lists;
    //$page_nav = $this->model->page_nav();
    $search_value = ((isset($_POST['search_value'])) ? htmlspecialchars(stripslashes($_POST['search_value'])) : '');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? htmlspecialchars(stripslashes($_POST['asc_or_desc'])) : 'asc');
    $order_by = (isset($_POST['order_by']) ? htmlspecialchars(stripslashes($_POST['order_by'])) : 'id');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
	$user=JFactory::getUser();
	
    ?>
    <script>
	<?php if(!$user->authorise('core.edit', 'com_gallery_wd')){ ?>
function edit_tag()
{
return false;
}

<?php } ?>

      var ajax_url = "index.php?option=com_gallery_wd&view=tags"
	  
	  	 Joomla.submitbutton=function(pressbutton) 
	{
		var form = document.adminForm;
		if (pressbutton == 'cancel') 
		{

			submitform( pressbutton );
			return;
		}
		submitform( pressbutton );
	}
	
	
	Joomla.tableOrdering= function ( order, dir, task )  {
    var form = document.adminForm;
    form.filter_order.value     = order;
    form.filter_order_Dir.value = dir;
    submitform( task );
}

	jQuery(document).ready(function() {
  jQuery(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});	
    </script>
	
    <div style="font-size: 14px; font-weight: bold;">
      This section allows you to create, edit and delete tags.
      <a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/joomla-gallery-guide-step-3.html">Read More in User Manual</a>
    </div>
		      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/products/joomla-gallery.html">
          <img width="215" border="0" alt="https://web-dorado.com" src="<?php echo WD_BWG_URL . '/images/logo.png'; ?>" />
        </a>
      </div>
    <div id="wordpress_message_1" style="width:95%;display:none"><div id="wordpress_message_2" class="updated"><p><strong>Item Succesfully Saved.</strong></p></div></div>
    <form class="wrap" id="adminForm" name="adminForm" method="post" action="index.php?option=com_gallery_wd&view=tags" style="width:95%;">
      <span class="tag_icon"></span>
      <h2>Tags</h2>


	  
	  	  			<table width="100%">
		<tr>
			<td align="left" width="100%">
				<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area"  placeholder="Search" style="margin:0px" />
				<button class="btn tip hasTooltip" type="submit" data-original-title="Search"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('search').value='';this.form.submit();" data-original-title="Clear">
				<i class="icon-remove"></i></button>
				
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $pageNav->getLimitBox(); ?>
				</div>

			</td>
		</tr>
		</table>  
	  
      <table class="table table-striped">
        <thead>
          <tr>
            <th width="20"><input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)"></th>

				<th width="30" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></th>

				<th><?php echo JHTML::_('grid.sort', 'Name', 'name', @$lists['order_Dir'], @$lists['order'] ); ?></th>
	
                
				<th nowrap="nowrap" width="100"><?php echo JHTML::_('grid.sort',   'Slug', 'slug',@$lists['order_Dir'], @$lists['order'] ); ?></th>
				
				<th nowrap="nowrap" style="text-align:center" width="100"><?php echo JHTML::_('grid.sort',   'Count', 'count',@$lists['order_Dir'], @$lists['order'] ); ?></th>
				

       
          </tr>
		  <tr id="tr">
            <th></th>
            <th></th>
            <th class="edit_input">
              <input class="input_th" name="name" type="text" value="">
            </th>
            <th class="edit_input">
              <input class="input_th" name="slug" type="text" value="">
            </th>
            <th></th>
            <th class="table_big_col">
              <a class="add_tag_th button-primary button button-small" onclick="spider_set_input_value('task', 'tags.save_tag');
                                                                                spider_set_input_value('current_id', '');
                                                                                spider_form_submit(event, 'adminForm')" href="">Add Tag </a>
            </th>
            <th></th>
          </tr>
        </thead>
		

		
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
		  $i=0;
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
			  $checked 	= JHTML::_('grid.id', $i, $row_data->id);
              ?>
            <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column" id="td_check_<?php echo $row_data->id; ?>" ><?php echo $checked; ?></td>
                <td class="table_small_col" id="td_id_<?php echo $row_data->id; ?>" ><?php echo $row_data->id; ?></td>
                <td id="td_name_<?php echo $row_data->id; ?>" >
                  <a class="pointer" id="name<?php echo $row_data->id; ?>"
                     onclick="edit_tag(<?php echo $row_data->id; ?>,'<?php echo JSession::getFormToken() ?>')" 
                     title="Edit"><?php echo $row_data->name; ?></a>
                </td>
                <td id="td_slug_<?php echo $row_data->id; ?>">
                  <a class="pointer"
                     id="slug<?php echo $row_data->id; ?>"
                     onclick="edit_tag(<?php echo $row_data->id; ?>,'<?php echo JSession::getFormToken() ?>')" 
                     title="Edit"><?php echo $row_data->slug; ?></a>
                </td>
                <td class="table_big_col" id="td_count_<?php echo $row_data->id; ?>" >
                  <a class="pointer"
                     id="count<?php echo $row_data->id; ?>"
                     onclick="edit_tag(<?php echo $row_data->id; ?>,'<?php echo JSession::getFormToken() ?>')"
                     title="Edit"><?php echo get_count_of_images($row_data->id); ?></a>
                </td>
                <td class="table_big_col" id="td_edit_<?php echo $row_data->id; ?>">
                  <a onclick="edit_tag(<?php echo $row_data->id; ?>,'<?php echo JSession::getFormToken() ?>')">Edit</a>
                </td>
                <td class="table_big_col" id="td_delete_<?php echo $row_data->id; ?>">
                  <a onclick="spider_set_input_value('task', 'tags.delete');
                              spider_set_input_value('current_id', <?php echo $row_data->id; ?>);
                              spider_form_submit(event, 'adminForm')" href="">Delete</a>
                </td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
			  $i++;
            }
          }
          ?>
        </tbody>
		
				<tfoot>
			<tr>
				<td colspan="11">
				 <?php echo $pageNav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
      </table>
      <input id="task" name="task" type="hidden" value="" />
      <input id="view" name="view" type="hidden" value="tags" />
      <input id="current_id" name="current_id" type="hidden" value="" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="<?php echo $asc_or_desc; ?>" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
	  <input id="boxchecked" name="boxchecked" type="hidden" value="0" />
	    <input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />   
		
		<input type="hidden" name="option" value="com_gallery_wd">
				<?php echo JHtml::_( 'form.token' ); ?>	
		
    </form>
    <?php

	
	
	function get_count_of_images($term_id) {
	$db =JFactory::getDBO();
    $query = "SELECT count FROM #__bwg_tags WHERE id=" . $db->escape($term_id);
   $db->setQuery($query );
   $count = $db->loadResult();
    return $count;
  }