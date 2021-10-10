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
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

 $rows_data = $this->rows_data;
    $page_nav = $this->page_nav;
	
	$lists=$this->lists;

    $ids_string = '';

	
	$saveOrder	= $lists['order'] == 'table1.order';

if ($saveOrder)
{

	$saveOrderingUrl = 'index.php?option=com_gallery_wd&task=albums.saveOrderAjax&tmpl=component';
	//JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($lists['order_Dir']), $saveOrderingUrl);
}
	
	
?>
<script type="text/javascript">

	
	
	
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
	</script>

    <div style="font-size: 14px; font-weight: bold;">
      This section allows you to create, edit and delete albums.
      <a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/joomla-gallery-guide-step-4.html">Read More in User Manual</a>
    </div>
		      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/products/joomla-gallery.html">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_BWG_URL . '/images/logo.png'; ?>" />
        </a>
      </div>
    <form class="wrap" id="adminForm" name="adminForm" method="post" action="index.php?option=com_gallery_wd&view=albums">

      <div id="draganddrop" class="updated" style="display:none;"><strong><p>Changes made in this table shoud be saved.</p></strong></div>
      <div class="buttons_div">
        <input id="show_hide_weights"  class="button" type="button" onclick="spider_show_hide_weights();return false;" value="Hide order column" />
      </div>
      <div class="tablenav top">
        <?php
       /* WDWLibrary::search('Name', $search_value, 'adminForm');
        WDWLibrary::html_page_nav($page_nav['total'], $page_nav['limit'], 'adminForm');*/
        ?>
      </div>
	  
	  			<table width="100%">
		<tr>
			<td align="left" width="100%">
				<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area"  placeholder="Search" style="margin:0px" />
				<button class="btn tip hasTooltip" type="submit" data-original-title="Search"><i class="icon-search"></i></button>
				<button class="btn tip hasTooltip" type="button" onclick="document.id('search').value='';this.form.submit();" data-original-title="Clear">
				<i class="icon-remove"></i></button>
				
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $page_nav->getLimitBox(); ?>
				</div>

			</td>
		</tr>
		</table>  
	  
      <table id="articleList" class="table table-striped">
        <thead>
<th width="1%" class="nowrap center hidden-phone">

				</th>
				<th width="20"><input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)"></th>

				<th width="30" class="title"><?php echo JHTML::_('grid.sort',   'ID', 'id', @$lists['order_Dir'], @$lists['order'] ); ?></th>
				
				<th nowrap="nowrap" width="100"><?php echo JHTML::_('grid.sort', 'Name', 'name', @$lists['order_Dir'], @$lists['order'] ); ?></th>
	
                
				<th nowrap="nowrap" width="100"><?php echo JHTML::_('grid.sort',   'Slug', 'slug',@$lists['order_Dir'], @$lists['order'] ); ?></th>
				<th nowrap="nowrap"  width="100">Thumbnail</th>
				
				<th nowrap="nowrap" width="100"><?php echo JHTML::_('grid.sort',   'Author', 'author',@$lists['order_Dir'], @$lists['order'] ); ?></th>
				
				<th id="th_order" nowrap="nowrap" width="100"><?php echo JHTML::_('grid.sort',   'Order', 'order',@$lists['order_Dir'], @$lists['order'] ); ?></th>
				<th nowrap="nowrap" width="100"><?php echo JHTML::_('grid.sort',   'Published', 'published',@$lists['order_Dir'], @$lists['order'] ); ?></th>
		
		
          <th class="table_big_col">Edit</th>
          <th class="table_big_col">Delete</th>
        </thead>
	  	
		<tfoot>
			<tr>
				<td colspan="11">
				 <?php echo $page_nav->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
        <tbody id="tbody_arr" class='ui-sortable'>
          <?php
          if ($rows_data) {
		  $i=0;
            foreach ($rows_data as $row_data) {
			
              $alternate = '';
              $published_image = (($row_data->published) ? 'publish' : 'unpublish');
              $published = (($row_data->published) ? 'unpublish' : 'publish');
              if ($row_data->preview_image == '') {
                $preview_image = 'components/com_gallery_wd/images/no-image.png';
              }
              else {
                $preview_image =   JURI::root().WD_BWG_UPLOAD_DIR.'/'.$row_data->preview_image;
              }
			  			  $preview_image =htmlspecialchars($preview_image );

			  $edit_link='index.php?option=com_gallery_wd&view=albums&task=edit&cid[]='.$row_data->id;
			  $checked 	= JHTML::_('grid.id', $i, $row_data->id);
				$published 	= published($row_data, $i, 'calendar');
				
				
				/////////////////ORDERING
				$ordering  = ($lists['order'] == 'table1.order');
				 
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" class="row<?php echo $i % 2; ?>" <?php echo $alternate; ?>>
                
                <td class="connectedSortable table_small_col"><div title="Drag to re-order"class="handle" style="margin:5px auto 0 auto;"></div>
											
					<input name="ids[]" type="hidden" value="<?php echo $row_data->id; ?>" />
				</td>
				
				
				
				
				
                <td><?php echo $checked?></td>
                <td class="table_small_col"><?php echo $row_data->id; ?></td>
               
                <td><a  href="<?php echo $edit_link ?>" title="Edit"><?php echo $row_data->name; ?></a></td>
                <td><?php echo $row_data->slug; ?></td>
				 <td class="table_extra_large_col">
                  <img title="<?php echo $row_data->name; ?>" style="border: 1px solid #CCCCCC; max-width:60px; max-height:60px;" src="<?php echo $preview_image . '?date=' . date('Y-m-y H:i:s'); ?>">
                </td>
                <td><?php echo $row_data->display_name; ?></td>
                <td class="spider_order table_medium_col">
				<input id="order_input_<?php echo $row_data->id; ?>" name="order_input_<?php echo $row_data->id; ?>" type="text" size="1" value="<?php echo $row_data->order; ?>" />
				</td>
               	
				<td align="center"><?php echo $published?></td>
               

			   <td class="table_big_col"><a  href="<?php echo $edit_link ?>">Edit</a></td>
               


			   <td class="table_big_col"><a onclick="
			   			   if (confirm('Do you want to delete this item?')) {
			  jQuery(this).parent().parent().children().find('input')[1].checked='checked'
			   spider_set_input_value('task', 'albums.delete');
                                                      spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                                      spider_form_submit(event, 'adminForm')
													  }
													  else
													  {
													  return false;
													  }
													  " href="">Delete</a></td>
              </tr>
              <?php
			 $i++;
              $ids_string .= $row_data->id . ',';
            }
          }
          ?>
        </tbody>
		

		
		
      </table>

      <input id="task" name="task" type="hidden" value="" />

      <input id="current_id" name="current_id" type="hidden" value="" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
		<input type="hidden" name="boxchecked" value="0"> 
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" id="filter_order_Dir" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />  

				<?php echo JHtml::_( 'form.token' ); ?>	
		
		<script>

		
        window.onload = spider_show_hide_weights;
      </script>
    </form>
	
<?php 

function published( &$row, $i, $task, $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='' ){
        $img     = $row->published ? $imgY : $imgX;
        $task     = $row->published ? 'albums.unpublish' : 'albums.publish';
        $alt     = $row->published ? JText::_( 'Published' ) : JText::_( 'Unpublished' );
        $action = $row->published ? JText::_( 'Unpublish Item' ) : JText::_( 'Publish item' );
 
        $href = '
        <a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" title="'. $action .'">
        <img src="templates/hathor/images/admin/'. $img .'" border="0" alt="'. $alt .'" /></a>'
        ;
 
        return $href;
    
}

?>	
	