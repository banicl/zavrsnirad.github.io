<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');


    if (isset($_GET['image_id'])) {
      $get_image_id = $_GET['image_id'];
      $cur_image_row = $this->get_image_row_data;
	   $session = JFactory::getSession();
 
 $current_url =$_GET['curr_url'] ;//$session->get('current_url');
  function bgw_url_decode($url)
{
$url=str_replace('bwg_dots',':',$url);
$url=str_replace('bwg_slash','/',$url);
$url=str_replace('bwg_equal','=',$url);
$url=str_replace('bwg_amp','&',$url);
$url=str_replace('bwg_sharp','#',$url);
$url=str_replace('bwg_quest','?',$url);
return $url;

}

function bgw_url_encode($url)
{
$url=str_replace(':','bwg_dots',$url);
$url=str_replace('/','bwg_slash',$url);
$url=str_replace('=','bwg_equal',$url);
$url=str_replace('&','bwg_amp',$url);
$url=str_replace('#','bwg_sharp',$url);
$url=str_replace('?','bwg_quest',$url);
return $url;

}
 
 

      ?>
      <html>
        <head>
          <meta property="og:image" name="bwg_image" content="<?php echo ($cur_image_row->filetype == "YOUTUBE" || $cur_image_row->filetype == "VIMEO") ? $cur_image_row->thumb_url : JURI::root()  . WD_BWG_UPLOAD_DIR .'/' . str_replace(' ','%20',$cur_image_row->image_url); ?>" />
          <meta property="og:title" name="bwg_title" content="<?php echo $cur_image_row->alt; ?>" />
          <meta property="og:description" name="bwg_description" content="<?php echo $cur_image_row->description; ?>" />

        <body style="display:none;">
          <img src="<?php echo ($cur_image_row->filetype == "YOUTUBE" || $cur_image_row->filetype == "VIMEO") ? $cur_image_row->thumb_url : JURI::root()  . WD_BWG_UPLOAD_DIR .'/' .  $cur_image_row->image_url; ?>">
        </body>
      </html>
      <?php
    }
    ?>
    <script>
      var bwg_hash = window.parent.location.hash;
      if (bwg_hash) {
        if (bwg_hash.indexOf("bwg") == "-1") {
          bwg_hash = bwg_hash.replace("#", "#bwg");
        }
        window.location.href = "<?php echo (isset($current_url) ? bgw_url_decode($current_url) : ''); ?>" + bwg_hash;
      }
    </script>
    <?php
    die();
