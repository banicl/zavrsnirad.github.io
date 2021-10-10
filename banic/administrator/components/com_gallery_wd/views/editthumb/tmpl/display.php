<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

 $popup_width = (int)JRequest::getVar('width',800);
    $image_width = $popup_width - 40;
    $popup_height = (int)JRequest::getVar('height',500);
    $image_height = $popup_height - 40;
    $image_id =JRequest::getVar('image_id',0);
    ?>
    <div style="display:table; width:100%; height:<?php echo $popup_height; ?>px;">
      <div style="display:table-cell; text-align:center; vertical-align:middle;">
        <img id="image_display" src="" style="max-width:<?php echo $image_width; ?>px; max-height:<?php echo $image_height; ?>px;"/>
      </div>
    </div>
    <script>
      var image_url = "<?php echo JURI::root().WD_BWG_UPLOAD_DIR.'/'; ?>" + window.parent.document.getElementById("image_url_<?php echo $image_id; ?>").value;
     
	 var input_filetype=window.parent.document.getElementById("input_filetype_<?php echo $image_id; ?>").value;
	  if(input_filetype=='YOUTUBE' ||  input_filetype=='VIMEO')
      var image_url = window.parent.document.getElementById("image_thumb_<?php echo $image_id; ?>").src;



	 window.document.getElementById("image_display").src = image_url + "?date=<?php echo date('Y-m-y H:i:s'); ?>";
    
		if(window.parent.jQuery('#sbox-content').children().length!=1 && window.parent.jQuery('#sbox-content').children().length!=0)
	{
	for(i=1;i<window.parent.jQuery('#sbox-content').children().length;i++)
	window.parent.jQuery('#sbox-content').children()[i].remove();
	}
	
	</script>
    <?php
    die();