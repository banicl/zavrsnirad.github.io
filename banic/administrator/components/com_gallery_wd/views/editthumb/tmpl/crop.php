<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

	$options = $this->get_option_data;
    $thumb_width = $options->upload_thumb_width;
    $thumb_height = $options->upload_thumb_height;
    
	$popup_width = (int)JRequest::getVar('width') - 50;
    $image_width = $popup_width - $thumb_width - 70;
    $popup_height = (int)JRequest::getVar('height') - 75;
    $image_height = $popup_height - 70;
    
	
	$image_id = JRequest::getVar('image_id',0);
    $edit_type = JRequest::getVar('edit_type');
    $x = (isset($_POST['x']) ? (int) $_POST['x'] : 0);
    $y = (isset($_POST['y']) ? (int) $_POST['y'] : 0);
    $w = (isset($_POST['w']) ? (int) $_POST['w'] : 0);
    $h = (isset($_POST['h']) ? (int) $_POST['h'] : 0);

    if (JRequest::getVar('image_url')) {
      $image_data = new stdClass();
      $image_data->image_url = JRequest::getVar('image_url');
      $image_data->thumb_url = JRequest::getVar('thumb_url');
      $filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->image_url;
      $thumb_filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->thumb_url;
	  $form_action="index.php?option=com_gallery_wd&view=editThumb&type=crop&image_id=".$image_id."&image_url=".$image_data->image_url."&thumb_url=".$image_data->thumb_url."&width=800&height=500";
    }
    else {
      $image_data = $this->get_image_data;
      $filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->image_url;
      $thumb_filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->thumb_url;
      $form_action="index.php?option=com_gallery_wd&view=editThumb&type=crop&image_id=".$image_id."&width=800&height=500";

	  
    }
	

    ini_set('memory_limit', '-1');
    list($width_orig, $height_orig, $type_orig) = getimagesize($filename);
    if ($edit_type == 'crop') {
      if ($type_orig == 2) {
        $img_r = imagecreatefromjpeg($filename);
        $dst_r = ImageCreateTrueColor($thumb_width, $thumb_height);
        imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $thumb_width, $thumb_height, $w, $h);
        imagejpeg($dst_r, $thumb_filename, 100);
        imagedestroy($img_r);
        imagedestroy($dst_r);
      }
      elseif ($type_orig == 3) {
        $img_r = imagecreatefrompng($filename);
        $dst_r = ImageCreateTrueColor($thumb_width, $thumb_height);
        imageColorAllocateAlpha($dst_r, 0, 0, 0, 127);
        imagealphablending($dst_r, FALSE);
        imagesavealpha($dst_r, TRUE);
        imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $thumb_width, $thumb_height, $w, $h);
        imagealphablending($dst_r, FALSE);
        imagesavealpha($dst_r, TRUE);
        imagepng($dst_r, $thumb_filename, 9);
        imagedestroy($img_r);
        imagedestroy($dst_r);
      }
      elseif ($type_orig == 1) {
        $img_r = imagecreatefromgif($filename);
        $dst_r = ImageCreateTrueColor($thumb_width, $thumb_height);
        imageColorAllocateAlpha($dst_r, 0, 0, 0, 127);
        imagealphablending($dst_r, FALSE);
        imagesavealpha($dst_r, TRUE);
        imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $thumb_width, $thumb_height, $w, $h);
        imagealphablending($dst_r, FALSE);
        imagesavealpha($dst_r, TRUE);
        imagegif($dst_r, $thumb_filename);
        imagedestroy($img_r);
        imagedestroy($dst_r);
      }
      else {
        ?>
        <div class="thumb_message"><strong>You can't crop this type of image.</strong></div>
        <?php
      }
    }
    ini_restore('memory_limit');
    ?>
      	  <script src="<?php echo WD_BWG_URL; ?>/js/jquery.js"></script>
    <script src="<?php echo WD_BWG_URL . '/js/Jcrop-1902/js/jquery.Jcrop.min.js'; ?>" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo WD_BWG_URL . '/js/Jcrop-1902/css/jquery.Jcrop.css'; ?>" type="text/css" />
    <style>
      body {
        height: <?php echo $popup_height; ?>px;
      }
      .spider_crop {
        background: linear-gradient(to top, #ECECEC, #F9F9F9) repeat scroll 0 0 #F1F1F1;
        cursor: pointer;
        height: 30px;
        padding: 2px;
        -moz-outline-radius:  2px;
        outline: 1px solid #CCCCCC;
      }
      .spider_crop:hover {
        -moz-outline-radius:  2px;
        outline: 1px solid #999999;
        padding: 2px;
      }
      .jcrop-holder {
        margin: 0 auto;
      }
      .thumb_preview {
        height: <?php echo $thumb_height; ?>px;
        margin: 0 auto;
        overflow: hidden;
        width: <?php echo $thumb_width; ?>px;
      }
      #thumb_image_preview {
        display: none;
      }
      .thumb_preview_td {
        background-color: #F5F5F5;
        border-radius: 3px;
        border: 1px solid #CCCCCC; 
      }
      .thumb_message {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        background: linear-gradient(to top, #ECECEC, #F9F9F9) repeat scroll 0 0 #F1F1F1;
        background-color: #F5F5F5;
        border: 1px solid #CCCCCC;
        border-radius: 3px 3px 3px 3px;
        box-sizing: border-box;
        color: #333333;
        font-family: sans-serif;
        font-size: 12px;
        margin: 5px auto;
        padding: 8px 5px;
        width: <?php echo $popup_width; ?>;
      }
      #crop_button {
        display: none;
        height: 38px;
        margin-top: 5px;
        text-align: center;
      }
    </style>
    <?php
    if ($edit_type == 'crop') {
      ?><div class="thumb_message" id="croped_message"><strong>The thumbnail successfully croped.</strong></div><?php
    }
    else {
      ?><div class="thumb_message" id="thumb_message"><strong>Select the area for the thumbnail.</strong></div><?php
    }
    ?>
    <form method="post" id="crop_image" action="<?php echo $form_action; ?>" >
      <div style="height:<?php echo $popup_height - 10; ?>px; width:<?php echo $popup_width; ?>; margin: 5px auto;">
        <div id="crop_button">
          <img title="Crop" class="spider_crop" onclick="spider_crop('crop', 'crop_image')" src="<?php echo WD_BWG_URL . '/images/crop.png'; ?>"/>
        </div>
        <table style="height: inherit; top: 45px; position: absolute ;width: inherit; margin: 0 auto;">
          <tr>
            <td class="thumb_preview_td" style="vertical-align: middle; width: <?php echo ($popup_width - $thumb_width) - 40; ?>px;">
              <img id="image_view" src="<?php echo JURI::root().WD_BWG_UPLOAD_DIR.'/'. $image_data->image_url; ?>?date=<?php echo date('Y-m-y H:i:s'); ?>" style="max-width:<?php echo $image_width; ?>px; max-height:<?php echo $image_height; ?>px;" />
            </td>
            <td class="thumb_preview_td" style="width:<?php echo $thumb_width + 20; ?>px;">
              <div class="thumb_preview">
                <img id="thumb_image_preview" src="<?php echo JURI::root().WD_BWG_UPLOAD_DIR.'/' . $image_data->image_url; ?>?date=<?php echo date('Y-m-y H:i:s'); ?>">
              </div>
            </td>
          </tr>
        </table>
      </div>
      <input type="hidden" name="edit_type" id="edit_type" />
      <input id="x" type="hidden" name="x" value="" />
      <input id="y" type="hidden" name="y" value="" />
      <input id="w" type="hidden" name="w" value="" />
      <input id="h" type="hidden" name="h" value="" />
    </form>
    <script language="javascript">
      function spider_crop(type, form_id) {
        document.getElementById("edit_type").value = type;
        document.getElementById(form_id).submit();
      }
      var image_src = window.parent.document.getElementById("image_thumb_<?php echo $image_id; ?>").src;
      window.parent.document.getElementById("image_thumb_<?php echo $image_id; ?>").src = image_src + "?date=<?php echo date('Y-m-y H:i:s'); ?>";
      // jQuery('#image_view').Jcrop();
      jQuery(window).load(function() {
        var ratio = parseInt('<?php echo $width_orig; ?>') / jQuery('#image_view').width();
        var thumb_width = parseInt('<?php echo $options->upload_thumb_width; ?>');
        var thumb_height = parseInt('<?php echo $options->upload_thumb_height; ?>');
        if (<?php echo $w; ?> == 0) {
          jQuery('#image_view').Jcrop({
            onChange: spider_update_thumb,
            onSelect: spider_update_coords,
            // bgColor: 'black',
            bgOpacity: .7,
            aspectRatio: thumb_width / thumb_height
          });
        }
        else {
          jQuery('#image_view').Jcrop({
            onChange: spider_update_thumb,
            onSelect: spider_update_coords,
            // bgColor: 'black',
            bgOpacity: .7,
            setSelect: [ <?php echo $x; ?> / ratio, <?php echo $y; ?> / ratio, <?php echo $x + $w; ?> / ratio, <?php echo $y + $h; ?> / ratio ],
            aspectRatio: thumb_width / thumb_height
          });
        }
      })
      function spider_update_coords(c) {
        var ratio = parseInt('<?php echo $width_orig; ?>') / jQuery('#image_view').width();
        jQuery('#x').val(c.x * ratio);
        jQuery('#y').val(c.y * ratio);
        jQuery('#w').val(c.w * ratio);
        jQuery('#h').val(c.h * ratio);
        jQuery('#crop_button').show();
        jQuery('#thumb_message').hide();
        jQuery('#croped_message').hide();
        jQuery('#thumb_image_preview').show();
        jQuery('.thumb_preview').css("border", "1px solid #CCCCCC");
      }
      function spider_update_thumb(c) {
        jQuery('#crop_button').hide();
        jQuery('#croped_message').show();
        var thumb_width = parseInt('<?php echo $options->upload_thumb_width; ?>');
        var thumb_height = parseInt('<?php echo $options->upload_thumb_height; ?>');
        jQuery('#thumb_image_preview').css("margin-left", -c.x * (thumb_width / c.w) + "px");
        jQuery('#thumb_image_preview').css("margin-top", -c.y * (thumb_height / c.h) + "px");        
        jQuery('#thumb_image_preview').css("width", ((thumb_width / c.w) * jQuery('#image_view').width()) + "px");
        jQuery('#thumb_image_preview').css("height", ((thumb_height / c.h) * jQuery('#image_view').height()) + "px");
      }
	  
	if(window.parent.jQuery('#sbox-content').children().length!=1 && window.parent.jQuery('#sbox-content').children().length!=0)
	{
	for(i=1;i<window.parent.jQuery('#sbox-content').children().length;i++)
	window.parent.jQuery('#sbox-content').children()[i].remove();
	}	  
	  
    </script>
    <?php
    die();
  