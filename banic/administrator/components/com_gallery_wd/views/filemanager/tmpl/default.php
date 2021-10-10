<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');
$document		=JFactory::getDocument();
$items_view = $this->file_manager_data['session_data']['items_view'];
$sort_by = $this->file_manager_data['session_data']['sort_by'];
$sort_order = $this->file_manager_data['session_data']['sort_order'];
$clipboard_task = $this->file_manager_data['session_data']['clipboard_task'];
$clipboard_files = $this->file_manager_data['session_data']['clipboard_files'];
$clipboard_src = $this->file_manager_data['session_data']['clipboard_src'];
$clipboard_dest = $this->file_manager_data['session_data']['clipboard_dest'];
$icons_dir_url =  'components/com_gallery_wd/images/filemanager/file_icons';
$sort_icon = $icons_dir_url . '/' . $sort_order;
	$input = JFactory::getApplication()->input;
$get_controller=$this->get_controller;
$user=JFactory::getUser();

$guest= $user->guest;
$user_groups= implode(',',$user->groups);


 if (isset($_GET['filemanager_msg']) && htmlspecialchars($_GET['filemanager_msg']) != '') {
        ?>
        <div id="file_manager_message" style="height:40px;">
          <div  style="background-color: #FFEBE8; border: 1px solid #CC0000; margin: 5px 15px 2px; padding: 5px 10px;">
            <strong style="font-size:14px"><?php echo htmlspecialchars(stripslashes($_GET['filemanager_msg'])); ?></strong>
          </div>
        </div>
        <?php
        $_GET['filemanager_msg'] = '';
      }

      ?>

      <script>
        var DS = "<?php echo addslashes('/'); ?>";

        var errorLoadingFile = "<?php echo 'File loading failed'; ?>";

        var warningRemoveItems = "<?php echo 'Are you sure you want to permanently remove selected items?'; ?>";
        var warningCancelUploads = "<?php echo 'This will cancel uploads. Continue?'; ?>";

        var messageEnterDirName = "<?php echo 'Enter directory name'; ?>";
        var messageEnterNewName = "<?php echo 'Enter new name'; ?>";
        var messageFilesUploadComplete = "<?php echo 'Files upload complete'; ?>";

        var root = "<?php echo addslashes($get_controller->get_uploads_dir()); ?>";
        var dir = "<?php echo (isset($_REQUEST['dir']) ? addslashes($_REQUEST['dir']) : ''); ?>";
        var dirUrl = "<?php echo $get_controller->get_uploads_url() . (isset($_REQUEST['dir']) ? addslashes($_REQUEST['dir'] . '/') : ''); ?>";
        var callback = "<?php echo (isset($_REQUEST['callback']) ? addslashes($_REQUEST['callback']) : ''); ?>";
        var sortBy = "<?php echo $sort_by; ?>";
        var sortOrder = "<?php echo $sort_order; ?>";
      </script>
      	  <script src="<?php echo WD_BWG_URL; ?>/js/jquery.js"></script>
	  <script src="<?php echo WD_BWG_URL; ?>/js/filemanager/jq_uploader/jquery.ui.widget.js"></script>
	  <script src="<?php echo WD_BWG_URL; ?>/js/filemanager/jq_uploader/jquery.iframe-transport.js"></script>
	  <script src="<?php echo WD_BWG_URL; ?>/js/filemanager/jq_uploader/jquery.fileupload.js"></script>


	  <script src="<?php echo WD_BWG_URL; ?>/js/filemanager/default.js"></script>

      
	  
	  <link href="<?php echo WD_BWG_URL; ?>/css/filemanager/default.css" type="text/css" rel="stylesheet">
      
	  
	  <?php
      switch ($items_view) {
        case 'list':
          ?>
          <link href="<?php echo WD_BWG_URL; ?>/css/filemanager/default_view_list.css" type="text/css" rel="stylesheet">
          <?php
          break;
        case 'thumbs':
          ?>
          <link href="<?php echo WD_BWG_URL; ?>/css/filemanager/default_view_thumbs.css" type="text/css" rel="stylesheet">
          <?php
          break;
      }
      $i = 0;
      ?>

      <form id="adminForm" name="adminForm" action="" method="post">
        <div id="wrapper">
          <div id="opacity_div" style="background-color: rgba(0, 0, 0, 0.2); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99998;"></div>
          <div id="loading_div" style="text-align: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999;">
            <img src="<?php echo WD_BWG_URL . '/images/ajax_loader.png'; ?>" class="spider_ajax_loading" style="margin-top: 200px; width:50px;">
          </div>
          <div id="file_manager">
            <div class="ctrls_bar ctrls_bar_header">
              <div class="ctrls_left">
                <a class="ctrl_bar_btn btn_up" onclick="onBtnUpClick(event, this);" title="<?php echo 'Up'; ?>"></a>
                <a class="ctrl_bar_btn btn_make_dir" onclick="onBtnMakeDirClick(event, this);" title="<?php echo 'Make a directory'; ?>"></a>
                <a class="ctrl_bar_btn btn_rename_item" onclick="onBtnRenameItemClick(event, this);" title="<?php echo 'Rename item'; ?>"></a>
                <span class="ctrl_bar_divider"></span>
                <a class="ctrl_bar_btn btn_copy" onclick="onBtnCopyClick(event, this);" title="<?php echo 'Copy'; ?>"></a>
                <a class="ctrl_bar_btn btn_cut" onclick="onBtnCutClick(event, this);" title="<?php echo 'Cut'; ?>"></a>
                <a class="ctrl_bar_btn btn_paste" onclick="onBtnPasteClick(event, this);" title="<?php echo 'Paste'; ?>"> </a>
                <a class="ctrl_bar_btn btn_remove_items" onclick="onBtnRemoveItemsClick(event, this);" title="<?php echo 'Remove items'; ?>"></a>
                <span class="ctrl_bar_divider"></span>
                <span class="ctrl_bar_btn btn_primary">
                  <a class="ctrl_bar_btn btn_upload_files" onclick="onBtnShowUploaderClick(event, this);"><?php echo 'Upload files'; ?></a>
                </span>
              </div>
              <div class="ctrls_right">
                <a class="ctrl_bar_btn btn_view_thumbs" onclick="onBtnViewThumbsClick(event, this);" title="<?php echo 'View thumbs'; ?>"></a>
                <a class="ctrl_bar_btn btn_view_list" onclick="onBtnViewListClick(event, this);" title="<?php echo 'View list'; ?>"></a>
              </div>
            </div>
            <div id="path">
              <?php
              foreach ($this->file_manager_data['path_components'] as $key => $path_component) {
                ?>
                <a <?php echo ($key == 0) ? 'title="To change upload directory go to Options page."' : ''; ?> class="path_component path_dir"
                   onclick="onPathComponentClick(event, this, '<?php echo addslashes($path_component['path']); ?>');">
                    <?php echo $path_component['name']; ?></a>
                <a class="path_component path_separator"><?php echo '/'; ?></a>
                <?php
              }
              ?>
            </div>
            <div id="explorer">
              <div id="explorer_header_wrapper">
                <div id="explorer_header_container">
                  <div id="explorer_header">
                    <span class="item_numbering">#</span>
                    <span class="item_icon"></span>
                    <span class="item_name">
                      <span class="clickable" onclick="onNameHeaderClick(event, this);">
                          <?php
                          echo 'Name';
                          if ($sort_by == 'name') {
                            ?>
                            <span class="sort_order_<?php echo $sort_order; ?>"></span>
                            <?php
                          }
                          ?>
                      </span>
                    </span>
                    <span class="item_size">
                      <span class="clickable" onclick="onSizeHeaderClick(event, this);">
                        <?php
                        echo 'Size';
                        if ($sort_by == 'size') {
                          ?>
                          <span class="sort_order_<?php echo $sort_order; ?>"></span>
                          <?php
                        }
                        ?>
                      </span>
                    </span>
                    <span class="item_date_modified">
                      <span class="clickable" onclick="onDateModifiedHeaderClick(event, this);">
                        <?php
                        echo 'Date modified';
                        if ($sort_by == 'date_modified') {
                          ?>
                          <span class="sort_order_<?php echo $sort_order; ?>"></span>
                          <?php
                        }
                        ?>
                      </span>
                    </span>
                    <span class="scrollbar_filler"></span>
                  </div>
                </div>
              </div>
              <div id="explorer_body_wrapper">
                <div id="explorer_body_container">
                  <div id="explorer_body">
                    <?php
                    foreach ($this->file_manager_data['files'] as $file) {
					$file['name']=htmlspecialchars($file['name']);
					$file['thumb']=htmlspecialchars($file['thumb']);
					
					if($file['name']=='thumb' or $file['name']=='.original')
					continue;
                      ?>
                      <div class="explorer_item" draggable="true"
                           name="<?php echo $file['name']; ?>"
                           filename="<?php echo $file['name']; ?>"
                           filethumb="<?php echo $file['thumb']; ?>"
                           filesize="<?php echo $file['size']; ?>"
                           filetype="<?php echo strtoupper($file['type']); ?>"
                           date_modified="<?php echo $file['date_modified']; ?>"
                           fileresolution="<?php echo $file['resolution']; ?>"
                           onmouseover="onFileMOver(event, this);"
                           onmouseout="onFileMOut(event, this);"
                           onclick="onFileClick(event, this);"
                           ondblclick="onFileDblClick(event, this);"
                           ondragstart="onFileDragStart(event, this);"
                          <?php
                          if ($file['is_dir'] == true) {
                            ?>
                            ondragover="onFileDragOver(event, this);"
                            ondrop="onFileDrop(event, this);"
                            <?php
                          }
                          ?>
                            isDir="<?php echo $file['is_dir'] == true ? 'true' : 'false'; ?>">
                        <span class="item_numbering"><?php echo ++$i; ?></span>
                        <span class="item_thumb">
                          <img src="<?php echo $file['thumb']; ?>"/>
                        </span>
                        <span class="item_icon">
                          <img src="<?php echo $file['icon']; ?>"/>
                        </span>
                        <span class="item_name">
                          <?php echo $file['name']; ?>
                        </span>
                        <span class="item_size">
                          <?php echo $file['size']; ?>
                        </span>
                        <span class="item_date_modified">
                          <?php echo $file['date_modified']; ?>
                        </span>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="ctrls_bar ctrls_bar_footer">
              <div class="ctrls_left">
                <a class="ctrl_bar_btn btn_open btn_primary none_select" onclick="onBtnSelectAllClick();"><?php echo 'Select All'; ?></a>
              </div>
              <div class="ctrls_right">
                <span id="file_names_span">
                  <span>
                  </span>
                </span>
                <a class="ctrl_bar_btn btn_open btn_primary none_select" onclick="onBtnOpenClick(event, this);"><?php echo ((isset($_REQUEST['callback']) && htmlspecialchars($_REQUEST['callback']) == 'bwg_add_image') ? 'Add selected images to gallery' : 'Add'); ?></a>
                <span class="ctrl_bar_empty_devider"></span>
                <a class="ctrl_bar_btn btn_cancel btn_secondary none_select" onclick="onBtnCancelClick(event, this);"><?php echo 'Cancel'; ?></a>
              </div>
            </div>
          </div>
          <div id="uploader">
            <div id="uploader_bg"></div>
                       <div class="ctrls_bar ctrls_bar_header">
                           <div class="ctrls_left upload_thumb">
                Thumbnail Max. Dimensions:
                <input type="text" class="upload_thumb_dim" name="upload_thumb_width" id="upload_thumb_width" value="<?php echo $get_controller->get_options_data()->upload_thumb_width; ?>" /> x 
                <input type="text" class="upload_thumb_dim" name="upload_thumb_height" id="upload_thumb_height" value="<?php echo $get_controller->get_options_data()->upload_thumb_height; ?>" /> px
              </div>
              <div class="ctrls_right">
                <a class="ctrl_bar_btn btn_back" onclick="onBtnBackClick(event, this);" title="<?php echo 'Back'; ?>"></a>
              </div>

            </div>
            <label for="jQueryUploader">
              <div id="uploader_hitter">
                <div id="drag_message">
                  <span><?php echo 'Drag files here or click the button below' . '<br />' . 'to upload files' ?></span>
                </div>
                <div id="btnBrowseContainer">
                  <input id="jQueryUploader" type="file" name="files[]"
                         data-url="<?php echo 'index.php?option=com_gallery_wd&view=uploader&dir=' . $get_controller->get_uploads_dir() . '/' . 	JRequest::getVar('dir'). '/'; ?>"
                         multiple>
                </div>
                               <script>
                  jQuery("#jQueryUploader").fileupload({
                    dataType: "json",
                    dropZone: jQuery("#uploader_hitter"),
                    submit: function (e, data) {
                      jQuery("#uploader_progress_text").removeClass("uploader_text");
                      isUploading = true;
                      jQuery("#uploader_progress_bar").fadeIn();
                    },
                    progressall: function (e, data) {
                      var progress = parseInt(data.loaded / data.total * 100, 10);
                      jQuery("#uploader_progress_text").text("Progress " + progress + "%");
                      jQuery("#uploader_progress div div").css({width: progress + "%"});
                      if (data.loaded == data.total) {
                        isUploading = false;
                        jQuery("#uploader_progress_bar").fadeOut(function () {
                          jQuery("#uploader_progress_text").text(messageFilesUploadComplete);
                          jQuery("#uploader_progress_text").addClass("uploader_text");
                        });
                      }
                    },
                    stop: function (e, data) {
                      onBtnBackClick();
                    },
                    done: function (e, data) {
                      jQuery.each(data.result.files, function (index, file) {
                        if (file.error) {
                          alert(errorLoadingFile + ' :: ' + file.error);
                        }
                        if (file.error) {
                          jQuery("#uploaded_files ul").prepend(jQuery("<li class=uploaded_item_failed>" + "<?php echo 'Upload failed' ?> :: " + file.error + "</li>"));
                        }
                        else {
                          jQuery("#uploaded_files ul").prepend(jQuery("<li class=uploaded_item>" + file.name + " (<?php echo 'Uploaded' ?>)" + "</li>"));
                        }
                      });
                    }
                  });
                  jQuery(window).load(function () {
                    jQuery("#opacity_div").hide();
                    jQuery("#loading_div").hide();
                  })
				  

				  if(window.parent.jQuery('#sbox-content').children().length!=1 && window.parent.jQuery('#sbox-content').children().length!=0)
				  {
				  for(i=1;i<window.parent.jQuery('#sbox-content').children().length;i++)
				  window.parent.jQuery('#sbox-content').children()[i].remove();
				  }
				  
				   
                </script>
              </div>
            </label>
            <div id="uploaded_files">
              <ul></ul>
            </div>
            <div id="uploader_progress">
              <div id="uploader_progress_bar">
                <div></div>
              </div>
              <span id="uploader_progress_text" class="uploader_text">
                <?php echo 'No files to upload'; ?>
              </span>
            </div>
          </div>
        </div>

        <input type="hidden" name="task" value="">
        <input type="hidden" name="extensions" value="<?php echo (isset($_REQUEST['extensions']) ? $_REQUEST['extensions'] : '*'); ?>">
        <input type="hidden" name="callback" value="<?php echo (isset($_REQUEST['callback']) ? $_REQUEST['callback'] : ''); ?>">
        <input type="hidden" name="sort_by" value="<?php echo $sort_by; ?>">
        <input type="hidden" name="sort_order" value="<?php echo $sort_order; ?>">
        <input type="hidden" name="items_view" value="<?php echo $items_view; ?>">
        <input type="hidden" name="dir" value="<?php echo (isset($_REQUEST['dir']) ? $_REQUEST['dir'] : ''); ?>"/>
        <input type="hidden" name="file_names" value=""/>
        <input type="hidden" name="file_new_name" value=""/>
        <input type="hidden" name="new_dir_name" value=""/>
        <input type="hidden" name="clipboard_task" value="<?php echo $clipboard_task; ?>"/>
        <input type="hidden" name="clipboard_files" value="<?php echo $clipboard_files; ?>"/>
        <input type="hidden" name="clipboard_src" value="<?php echo $clipboard_src; ?>"/>
        <input type="hidden" name="clipboard_dest" value="<?php echo $clipboard_dest; ?>"/>
      </form>
	  

	  
      <?php

      die();