<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

 global $WD_BWG_UPLOAD_DIR;
    $popup_width = (int)JRequest::getVar('width') - 30;
    $image_width = $popup_width - 40;
    $popup_height = (int)JRequest::getVar('height') - 55;
    $image_height = $popup_height - 70;
    $image_id = JRequest::getVar('image_id',0);
    $edit_type = JRequest::getVar('edit_type');

   if (JRequest::getVar('image_url')) {
      $image_data = new stdClass();
      $image_data->image_url = JRequest::getVar('image_url');
      $image_data->thumb_url = JRequest::getVar('thumb_url');
      $filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->image_url;
      $thumb_filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->thumb_url;
	  $form_action="index.php?option=com_gallery_wd&view=editThumb&type=rotate&image_id=".$image_id."&image_url=".$image_data->image_url."&thumb_url=".$image_data->thumb_url."&width=800&height=500";
    }
    else {
      $image_data = $this->get_image_data;
      $filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->image_url;
      $thumb_filename = JPATH_SITE.'/' . WD_BWG_UPLOAD_DIR . $image_data->thumb_url;
      $form_action="index.php?option=com_gallery_wd&view=editThumb&type=rotate&image_id=".$image_id."&width=800&height=500";
    }
    ini_set('memory_limit', '-1');
    list($width_rotate, $height_rotate, $type_rotate) = getimagesize($filename);
    if ($edit_type == '270' || $edit_type == '90') {
      if ($type_rotate == 2) {
        $source = imagecreatefromjpeg($filename);
        $thumb_source = imagecreatefromjpeg($thumb_filename);
        $rotate = imagerotate($source, $edit_type, 0);
        $thumb_rotate = imagerotate($thumb_source, $edit_type, 0);
        imagejpeg($thumb_rotate, $thumb_filename, 100);
        imagejpeg($rotate, $filename, 100);
        imagedestroy($source);
        imagedestroy($rotate);
        imagedestroy($thumb_source);
        imagedestroy($thumb_rotate);
      }
      elseif ($type_rotate == 3) {
        $source = imagecreatefrompng($filename);
        $thumb_source = imagecreatefrompng($thumb_filename);
        imagealphablending($source, FALSE);
        imagealphablending($thumb_source, FALSE);
        imagesavealpha($source, TRUE);
        imagesavealpha($thumb_source, TRUE);
        $rotate = imagerotate($source, $edit_type, imageColorAllocateAlpha($source, 0, 0, 0, 127));
        $thumb_rotate = imagerotate($thumb_source, $edit_type, imageColorAllocateAlpha($source, 0, 0, 0, 127));
        imagealphablending($rotate, FALSE);
        imagealphablending($thumb_rotate, FALSE);
        imagesavealpha($rotate, TRUE);
        imagesavealpha($thumb_rotate, TRUE);
        imagepng($rotate, $filename, 9);
        imagepng($thumb_rotate, $thumb_filename, 9);
        imagedestroy($source);
        imagedestroy($rotate);
        imagedestroy($thumb_source);
        imagedestroy($thumb_rotate);
      }
      elseif ($type_rotate == 1) {
        $source = imagecreatefromgif($filename);
        $thumb_source = imagecreatefromgif($thumb_filename);
        imagealphablending($source, FALSE);
        imagealphablending($thumb_source, FALSE);
        imagesavealpha($source, TRUE);
        imagesavealpha($thumb_source, TRUE);
        $rotate = imagerotate($source, $edit_type, imageColorAllocateAlpha($source, 0, 0, 0, 127));
        $thumb_rotate = imagerotate($thumb_source, $edit_type, imageColorAllocateAlpha($source, 0, 0, 0, 127));
        imagealphablending($rotate, FALSE);
        imagealphablending($thumb_rotate, FALSE);
        imagesavealpha($rotate, TRUE);
        imagesavealpha($thumb_rotate, TRUE);
        imagegif($rotate, $filename);
        imagegif($thumb_rotate, $thumb_filename);
        imagedestroy($source);
        imagedestroy($rotate);
        imagedestroy($thumb_source);
        imagedestroy($thumb_rotate);
      }
      else {
        ?>
        <div class="thumb_message"><strong>You can't rotate this type of image.</strong></div>
        <?php
      }
    }
    elseif ($edit_type == 'vertical' || $edit_type == 'horizontal'  || $edit_type == 'both') {
      function bwg_image_flip($imgsrc, $mode) {
        $width = imagesx($imgsrc);
        $height = imagesy($imgsrc);
        $src_x = 0;
        $src_y = 0;
        $src_width = $width;
        $src_height = $height;

        switch ($mode) {
          case 'vertical':
            $src_y = $height - 1;
            $src_height = -$height;
            break;

          case 'horizontal':
            $src_x = $width - 1;
            $src_width = -$width;
            break;

          case 'both':
            $src_x = $width - 1;
            $src_y = $height - 1;
            $src_width = -$width;
            $src_height = -$height;
            break;

          default:
            return $imgsrc;
        }
        $trans_colour = imageColorAllocateAlpha($imgsrc, 0, 0, 0, 127);
        $imgdest = imagecreatetruecolor($width, $height);
        imagefill($imgdest, 0, 0, $trans_colour);
        if (imagecopyresampled($imgdest, $imgsrc, 0, 0, $src_x, $src_y , $width, $height, $src_width, $src_height)) {
          return $imgdest;
        }
        return $imgsrc;
      }
      if ($type_rotate == 2) {
        $source = imagecreatefromjpeg($filename);
        $flip = bwg_image_flip($source, $edit_type);
        imagejpeg($flip, $filename, 100);
        $thumb_source = imagecreatefromjpeg($thumb_filename);
        $thumb_flip = bwg_image_flip($thumb_source, $edit_type);
        imagejpeg($thumb_flip, $thumb_filename, 100);
        imagedestroy($source);
        imagedestroy($flip);
        imagedestroy($thumb_source);
        imagedestroy($thumb_flip);
      }
      elseif ($type_rotate == 3) {
        $source = imagecreatefrompng($filename);
        $thumb_source = imagecreatefrompng($thumb_filename);
        imagealphablending($source, FALSE);
        imagealphablending($thumb_source, FALSE);
        imagesavealpha($source, TRUE);
        imagesavealpha($thumb_source, TRUE);
        $flip = bwg_image_flip($source, $edit_type);
        $thumb_flip = bwg_image_flip($thumb_source, $edit_type);
        imagealphablending($flip, FALSE);
        imagealphablending($thumb_flip, FALSE);
        imagesavealpha($flip, TRUE);
        imagesavealpha($thumb_flip, TRUE);
        imagepng($flip, $filename, 9);
        imagepng($thumb_flip, $thumb_filename, 9);
        imagedestroy($source);
        imagedestroy($flip);
        imagedestroy($thumb_source);
        imagedestroy($thumb_flip);
      }
      elseif ($type_rotate == 1) {
        $source = imagecreatefromgif($filename);
        $thumb_source = imagecreatefromgif($thumb_filename);
        imagealphablending($source, FALSE);
        imagealphablending($thumb_source, FALSE);
        imagesavealpha($source, TRUE);
        imagesavealpha($thumb_source, TRUE);
        $flip = bwg_image_flip($source, $edit_type);
        $thumb_flip = bwg_image_flip($thumb_source, $edit_type);
        imagealphablending($flip, FALSE);
        imagealphablending($thumb_flip, FALSE);
        imagesavealpha($flip, TRUE);
        imagesavealpha($thumb_flip, TRUE);
        imagegif($flip, $filename);
        imagegif($thumb_flip, $thumb_filename);
        imagedestroy($source);
        imagedestroy($flip);
        imagedestroy($thumb_source);
        imagedestroy($thumb_flip);
      }
      else {
        ?>
        <div class="thumb_message"><strong>You can't flip this type of image.</strong></div>
        <?php
      }
      ini_restore('memory_limit');
    }
    ?>
    <style>
      .spider_rotate {
        background: linear-gradient(to top, #ECECEC, #F9F9F9) repeat scroll 0 0 #F1F1F1;
        cursor: pointer;
        height: 30px;
        padding: 2px;
        -moz-outline-radius:  2px;
        outline: 1px solid #CCCCCC;
      }
      .spider_rotate:hover {
        -moz-outline-radius:  2px;
        outline: 1px solid #999999;
        padding: 2px;
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
        padding: 7px 5px;
        width: <?php echo $popup_width; ?>;
      }
    </style>
    <script>
      function spider_rotate(type, form_id) {
        document.getElementById("edit_type").value = type;
        document.getElementById(form_id).submit();
      }
      var image_src = window.parent.document.getElementById("image_thumb_<?php echo $image_id; ?>").src;
      window.parent.document.getElementById("image_thumb_<?php echo $image_id; ?>").src = image_src + "?date=<?php echo date('Y-m-y H:i:s'); ?>";
    </script>
    <form method="post" id="rotate_image" action="<?php echo $form_action; ?>">
      <div style="text-align:center; width:inherit; height:<?php echo $popup_height; ?>px;">
        <div style="height:40px;">
          <img title="Flip Both" class="spider_rotate" onclick="spider_rotate('both', 'rotate_image')" src="<?php echo WD_BWG_URL . '/images/flip_both.png'; ?>"/>
          <img title="Flip Vertical" class="spider_rotate" onclick="spider_rotate('vertical', 'rotate_image')" src="<?php echo WD_BWG_URL . '/images/flip_vertical.png'; ?>"/>
          <img title="Flip Horizontal" class="spider_rotate" onclick="spider_rotate('horizontal', 'rotate_image')" src="<?php echo WD_BWG_URL . '/images/flip_horizontal.png'; ?>"/>
          <img title="Rotate Left" class="spider_rotate" onclick="spider_rotate('90', 'rotate_image')" src="<?php echo WD_BWG_URL . '/images/rotate_left.png'; ?>"/>
          <img title="Rotate Right" class="spider_rotate" onclick="spider_rotate('270', 'rotate_image')" src="<?php echo WD_BWG_URL . '/images/rotate_right.png'; ?>"/>
        </div>
        <div style="display:table; width:100%; height:<?php echo $popup_height - 40; ?>px;">
          <div style="display:table-cell; vertical-align:middle;">
            <img src="<?php echo JURI::root().WD_BWG_UPLOAD_DIR.'/' . $image_data->image_url; ?>?date=<?php echo date('Y-m-y H:i:s'); ?>" style="margin:0 auto; display:block; max-width:<?php echo $image_width; ?>px;max-height:<?php echo $image_height; ?>px;" />
          </div>
        </div>
      </div>
      <input type="hidden" name="edit_type" id="edit_type" />
      <input type="hidden" name="image_id" id="image_id" value="<?php echo $image_id; ?>" />
    </form>
	<script>
		if(window.parent.jQuery('#sbox-content').children().length!=1 && window.parent.jQuery('#sbox-content').children().length!=0)
	{
	for(i=1;i<window.parent.jQuery('#sbox-content').children().length;i++)
	window.parent.jQuery('#sbox-content').children()[i].remove();
	}
	</script>
    <?php
    die();