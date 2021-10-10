<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Restricted access');


require_once 'components/com_gallery_wd/controller.php';
class gallery_wdControllerFilemanager extends gallery_wdController {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    public $uploads_dir;
    public $uploads_url;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function __construct() {
        parent::__construct();
		$input = JFactory::getApplication()->input;
        $input->set('view', 'filemanager');
        $input->set('tmpl', 'component');



	  $this->uploads_dir = (($this->get_options_data()->images_directory . '/com_gallery_wd/uploads') ? JPATH_SITE .'/' . $this->get_options_data()->images_directory . '/com_gallery_wd/uploads' : WD_BWG_DIR . '/uploads');
      if (file_exists($this->uploads_dir) == FALSE) {
        mkdir($this->uploads_dir);
		fopen($this->uploads_dir.'/index.html','w');
		
      }

	  
	  $this->uploads_url = (($this->get_options_data()->images_directory . '/com_gallery_wd/uploads') ? JURI::root() . '/' . $this->get_options_data()->images_directory . '/com_gallery_wd/uploads' : WD_BWG_URL . '/uploads');

	  

    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
	
	 public function get_options_data() {
     	$db		=JFactory::getDBO();
		$query='SELECT * FROM #__bwg_option WHERE id=1';
		$db->setQuery($query);
		$row=$db->loadObject();
      
      return $row;
    }
	
    public function get_uploads_dir() {
        return $this->uploads_dir;
    }

    public function get_uploads_url() {
        return $this->uploads_url;
    }

    public function display($cachable = false, $urlparams = array()) {
        parent::display();
    }

    public function make_dir() {
	
	$input = JFactory::getApplication()->input;
        $input_dir = JRequest::getVar('dir');
        $cur_dir_path = $input_dir == '' ? $this->uploads_dir : $this->uploads_dir . '/' . $input_dir;

        $new_dir_path = $cur_dir_path . '/' . JRequest::getVar('new_dir_name');

        $msg = '';
        if (file_exists($new_dir_path) == true) {
            $msg = JText::_('Directory already exists');
        } else {
            mkdir($new_dir_path);
			fopen($new_dir_path.'/index.html','w');
			
        }
       $this->fmanager_redirect('filemanager',
            '',
            '',
            'extensions=' . JRequest::getVar('extensions') . '&callback=' . JRequest::getVar('callback') . '&dir=' . JRequest::getVar('dir'),
            $msg,
            'Warning'
        );
    }

    public function rename_item() {
	$input = JFactory::getApplication()->input;
        $input_dir = JRequest::getVar('dir');
        $cur_dir_path = $input_dir == '' ? $this->uploads_dir : $this->uploads_dir . '/' . $input_dir;

        $file_names = $this->get_array('file_names', '**#**');
        $file_name = $file_names[0];

        $file_new_name =JRequest::getVar('file_new_name');

        $file_path = $cur_dir_path . '/' . $file_name;
      $thumb_file_path = $cur_dir_path . '/thumb/' . $file_name;
      $original_file_path = $cur_dir_path . '/.original/' . $file_name;

        $msg = '';
        if (file_exists($file_path) == false) {
            $msg = JText::_('File doesn\'t exists');
        } else if (is_dir($file_path) == true) {
            if (rename($file_path, $cur_dir_path . '/' . $file_new_name) == false) {
                $msg = JText::_('Can\'t rename the file');
            }
        } else if ((strrpos($file_name, '.') !== false)) {
            $file_extension = substr($file_name, strrpos($file_name, '.') + 1);
            if (rename($file_path, $cur_dir_path . '/' . $file_new_name . '.' . $file_extension) == false) {
                $msg = JText::_('Can\'t rename the file');
            }
	     rename($thumb_file_path, $cur_dir_path . '/thumb/' . $file_new_name . '.' . $file_extension);
        rename($original_file_path, $cur_dir_path . '/.original/' . $file_new_name . '.' . $file_extension);
			
			
        } else {
            $msg = JText::_('Can\'t rename the file');
        }

        $input->set('file_names', '');

       $this->fmanager_redirect('filemanager',
            'show_file_manager',
            '',
            'tmpl=component&extensions=' . JRequest::getVar('extensions') . '&callback=' . JRequest::getVar('callback') . '&dir=' . JRequest::getVar('dir'),
            $msg,
            'Warning'
        );
    }

	public static function get_array($name, $delimiter = ',') {
	$input = JFactory::getApplication()->input;
        $input_array = explode($delimiter ,JRequest::getVar($name, '', 'string'));
        return $input_array;
    }

	
	
    public function remove_items() {
	$input = JFactory::getApplication()->input;
        $input_dir = JRequest::getVar('dir');
        $cur_dir_path = $input_dir == '' ? $this->uploads_dir : $this->uploads_dir . '/' . $input_dir;

        $file_names = $this->get_array('file_names', '**#**');

        $msg = '';
        foreach ($file_names as $file_name) {
            $file_path = $cur_dir_path . '/' . $file_name;

            if (file_exists($file_path) == false) {
                $msg = JText::_('Some of the file can\'t be removed');
            } else {
                $this->remove_file_dir($file_path);
            }
        }

        $input->set('file_names', '');

        $this->fmanager_redirect('filemanager',
            'show_file_manager',
            '',
            'tmpl=component&extensions=' . JRequest::getVar('extensions') . '&callback=' . JRequest::getVar('callback') . '&dir=' . JRequest::getVar('dir'),
            $msg,
            'Warning'
        );
    }

	
	public function fmanager_redirect($controller, $task = '', $cid = '', $params = '', $msg = '', $msgType = 'message', $moved = false) {
	$app = JFactory::getApplication();
        $app->redirect(
            'index.php?option=com_gallery_wd' .
            '&view=' . $controller .
            '&task=' . $task .
            '&cid[]=' . $cid .
            '&' . $params,
            $msg,
            $msgType,
            $moved
        );
    }
	
	
    public function paste_items() {
	$input = JFactory::getApplication()->input;
        $msg = '';

        $file_names = $this->get_array('clipboard_files', ',');
        $src_dir =  $src_dir = (isset($_REQUEST['clipboard_src']) ? stripslashes($_REQUEST['clipboard_src']) : '');
        $src_dir = $src_dir == '' ? $this->uploads_dir : $this->uploads_dir . '/' . $src_dir;
		$dest_dir = (isset($_REQUEST['clipboard_dest']) ? stripslashes($_REQUEST['clipboard_dest']) : '');
        $dest_dir = $dest_dir == '' ? $this->uploads_dir : $this->uploads_dir . '/' . $dest_dir;

        switch ($input->get('clipboard_task')) {
            case 'copy':
                foreach ($file_names as $file_name) {
                    $src = $src_dir . '/' . $file_name;
                    if (file_exists($src) == false) {
                        $msg = JText::_('Failed to copy some of the files');
                        continue;
                    }

                    $dest = $dest_dir . '/' . $file_name;
					
					////NEW
					            if (!is_dir($src_dir . '/' . $file_name)) {
              if (!is_dir($dest_dir . '/thumb')) {
                mkdir($dest_dir . '/thumb', 0777);
              }
              $thumb_src = $src_dir . '/thumb/' . $file_name;
              $thumb_dest = $dest_dir . '/thumb/' . $file_name;
              if (!is_dir($dest_dir . '/.original')) {
                mkdir($dest_dir . '/.original', 0777);
              }
              $original_src = $src_dir . '/.original/' . $file_name;
              $original_dest = $dest_dir . '/.original/' . $file_name;
            }
			
			/////NEW END
					
					
                    $i = 0;
                    if (file_exists($dest) == true) {
                        $path_parts = pathinfo($dest);
                        while (file_exists($path_parts['dirname'] . '/' . $path_parts['filename'] . '(' . ++$i . ')' . '.' . $path_parts['extension'])) {
                        }
                        $dest = $path_parts['dirname'] . '/' . $path_parts['filename'] . '(' . $i . ')' . '.' . $path_parts['extension'];
						if (!is_dir($src_dir . '/' . $file_name)) {
						$thumb_dest = $path_parts['dirname'] . '/thumb/' . $path_parts['filename'] . '(' . $i . ')' . '.' . $path_parts['extension'];
						$original_dest = $path_parts['dirname'] . '/.original/' . $path_parts['filename'] . '(' . $i . ')' . '.' . $path_parts['extension'];
					}
						
                    }

                    if (!$this->copy_file_dir($src, $dest)) {
                        $msg = JText::_('Failed to copy some of the files');
                    }
					
					 if (!is_dir($src_dir . '/' . $file_name)) {
					  $this->copy_file_dir($thumb_src, $thumb_dest);
					  $this->copy_file_dir($original_src, $original_dest);
					}
                }
                break;
            case 'cut':
                if ($src_dir != $dest_dir) {
                    foreach ($file_names as $file_name) {
                        $src = $src_dir . '/' . $file_name;
                        $dest = $dest_dir . '/' . $file_name;
						
						////NEW
				   if (!is_dir($src_dir . '/' . $file_name)) {
						$thumb_src = $src_dir . '/thumb/' . $file_name;
						$thumb_dest = $dest_dir . '/thumb/' . $file_name;
						if (!is_dir($dest_dir . '/thumb')) {
						  mkdir($dest_dir . '/thumb', 0777);
						}
						$original_src = $src_dir . '/.original/' . $file_name;
						$original_dest = $dest_dir . '/.original/' . $file_name;
						if (!is_dir($dest_dir . '/.original')) {
						  mkdir($dest_dir . '/.original', 0777);
						}
					  }
			  
			  ////NEW END
						
						
                        if ((file_exists($src) == false) || (file_exists($dest) == true) || (!rename($src, $dest))) {
                            $msg = JText::_('Failed to move some of the files');
                        }
						 if (!is_dir($src_dir . '/' . $file_name)) {
							rename($thumb_src, $thumb_dest);
							rename($original_src, $original_dest);
							}
                    }
                }
                break;
        }
       $this->fmanager_redirect('filemanager',
            'show_file_manager',
            '',
            'tmpl=component&extensions=' . JRequest::getVar('extensions') . '&callback=' . JRequest::getVar('callback') . '&dir=' . JRequest::getVar('dir'),
            $msg,
            'Warning'
        );
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function remove_file_dir($del_file_dir) {
        if (is_dir($del_file_dir) == true) {
            $files_to_remove = scandir($del_file_dir);
            foreach ($files_to_remove as $file) {
                if ($file != '.' and $file != '..') {
                    $this->remove_file_dir($del_file_dir . '/' . $file);
                }
            }
            rmdir($del_file_dir);
        } else {
            unlink($del_file_dir);
        }
    }

    private function copy_file_dir($src, $dest) {
        if (is_dir($src) == true) {
            $dir = opendir($src);
            @mkdir($dest);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        $this->copy_file_dir($src . '/' . $file, $dest . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dest . '/' . $file);
                    }
                }
            }
            closedir($dir);
            return true;
        } else {
            return copy($src, $dest);
        }
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}