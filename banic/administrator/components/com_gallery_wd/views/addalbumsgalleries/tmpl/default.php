<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

  $rows_data = $this->get_rows_data;
    $page_nav = $this->page_nav;
    $search_value = ((isset($_POST['search_value'])) ? htmlspecialchars(stripslashes($_POST['search_value'])) : '');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? htmlspecialchars(stripslashes($_POST['asc_or_desc'])) : 'asc');
    $order_by = (isset($_POST['order_by']) ? htmlspecialchars(stripslashes($_POST['order_by'])) : 'name');
    $image_id = ((isset($_GET['image_id'])) ? htmlspecialchars($_GET['image_id']) : '0');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
	require_once(WD_BWG_DIR . '/framework/WDWLibrary.php');
    ?>
    <link media="all" type="text/css" href="<?php echo WD_BWG_URL . '/css/bwg_tables.css'; ?>" id="bwg_tables-css" rel="stylesheet">
<link rel="stylesheet" href="templates/isis/css/template.css?094dda951c26f608838bad562c1bf98a" type="text/css">
	<script src="../components/com_gallery_wd/js/jquery.js"></script>
<style>
body
{
padding:0px;
}
.spider_search_value
{
height: 23px !important;
}
</style>
    <script src="<?php echo WD_BWG_URL . '/js/bwg.js'; ?>" type="text/javascript"></script>
    <form class="wrap" id="albums_galleries_form" method="post" action="index.php?option=com_gallery_wd&view=addAlbumsGalleries&width=650&height=500" style="width:100%; margin: 0 auto;">
     <h2 style="width:200px;float:left">Albums/Galleries</h2>
      <a href="" class="thickbox thickbox-preview" id="content-add_media" title="Add Album/Gallery" onclick="spider_get_items(event);" style="float:right; padding: 9px 0px 4px 0">
        <img src="<?php echo WD_BWG_URL . '/images/add_but.png'; ?>" style="border:none;" />
      </a>
      <div class="tablenav top">
        <?php
    WDWLibrary::search('Name', $search_value, 'albums_galleries_form');
        WDWLibrary::html_page_nav($page_nav['total'], $page_nav['limit'], 'albums_galleries_form');
        ?>
      </div>
	  
      <table class="table table-striped" style="clear:both">
        <thead>
          <th class="manage-column column-cb check-column table_small_col">
		  <input id="check_all" type="checkbox" style="margin:0;" /></th>
          <th class="table_small_col <?php if ($order_by == 'id') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('order_by', 'id');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (htmlspecialchars(stripslashes($_POST['order_by'])) == 'id') && htmlspecialchars(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'albums_galleries_form')" href="">
              <span>ID</span><span class="sorting-indicator"></span></th>
            </a>
          <th class="<?php if ($order_by == 'is_album') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('order_by', 'is_album');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (htmlspecialchars(stripslashes($_POST['order_by'])) == 'is_album') && htmlspecialchars(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'albums_galleries_form')" href="">
              <span>Type</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="<?php if ($order_by == 'name') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('order_by', 'name');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (htmlspecialchars(stripslashes($_POST['order_by'])) == 'name') && htmlspecialchars(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'albums_galleries_form')" href="">
              <span>Name</span><span class="sorting-indicator"></span>
            </a>
          </th>
        </thead>
        <tbody id="tbody_albums_galleries">
          <?php
			if ($rows_data) {
            $iterator = 0;
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              ?>
              <tr id="tr_<?php echo $iterator; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column"><input id="check_<?php echo $iterator; ?>" name="check_<?php echo $iterator; ?>" type="checkbox" /></td>
                <td id="id_<?php echo $iterator; ?>" class="table_small_col"><?php echo $row_data->id; ?></td>
                <td id="url_<?php echo $iterator; ?>" class="table_medium_col_uncenter"><?php echo ($row_data->is_album ? "Album" : "Gallery") ; ?></td>
                <td>
                  <a onclick="window.parent.bwg_add_items(['<?php echo $row_data->id?>'],['<?php echo htmlspecialchars(addslashes($row_data->name))?>'], ['<?php echo htmlspecialchars(addslashes($row_data->is_album))?>'])" id="a_<?php echo $iterator; ?>" style="cursor:pointer;">
                    <?php echo $row_data->name?>
                  </a>
                </td>
              </tr>
              <?php
              $iterator++;
            }
          }
          ?>
        </tbody>
      </table>
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
    </form>
	<script>	
	spider_run_checkbox()
	if(window.parent.jQuery('#sbox-content').children().length!=1 && window.parent.jQuery('#sbox-content').children().length!=0)
	{
	for(i=1;i<window.parent.jQuery('#sbox-content').children().length;i++)
	window.parent.jQuery('#sbox-content').children()[i].remove();
	}	
	</script>
    <?php
    die();