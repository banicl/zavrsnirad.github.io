<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class gallery_wdModelFilemanager extends JModelLegacy {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function __construct() {
        parent::__construct();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_file_manager_data() {
	
		$option	= JRequest::getVar('option'); 
	$mainframe = JFactory::getApplication();
	
        $session_data = array();
        $session_data['sort_by'] = $this->get_UserState('sort_by', 'name');
        $session_data['sort_order'] = $this->get_UserState('sort_order', 'asc');
        $session_data['items_view'] = $this->get_UserState('items_view', 'thumbs');
        $session_data['clipboard_task'] = $this->get_UserState('clipboard_task', '');
        $session_data['clipboard_files'] = $this->get_UserState('clipboard_files', '');
        $session_data['clipboard_src'] = $this->get_UserState('clipboard_src', '');
        $session_data['clipboard_dest'] = $this->get_UserState('clipboard_dest', '');

        $data = array();
        $data['session_data'] = $session_data;
        $data['path_components'] = $this->get_path_components();
        $data['dir'] = $mainframe->input->get('dir');
        $data['files'] = $this->get_files($session_data['sort_by'], $session_data['sort_order']);
        $data['extensions'] = $mainframe->input->get('extensions');
        $data['callback'] = $mainframe->input->get('callback');

        return $data;
    }


	 public static function get_UserState($key, $default = null, $type = 'none', $use_input = true) {
        $option = 'com_gallery_wd';
        $controller = 'filemanager';
        $full_key = $option . '.' . $controller == '' ? '' : $controller . '.' . $key;
        $app = JFactory::getApplication();
        if ($use_input == true) {
            return $app->getUserStateFromRequest($full_key, $key, $default, $type);
        } else {
            return $app->getUserState($full_key, $default);
        }

    
    }
	
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_path_components() {
	$input = JFactory::getApplication()->input;

if(JRequest::getVar('dir')!='')
$dir=JRequest::getVar('dir');
else
$dir='';
        $dir_names = explode('/', $dir);
        $path = '';


        $components = array();
        $component = array();
        $component['name'] = 'root';
        $component['path'] = $path;
        $components[] = $component;
		
        for ($i = 0; $i < count($dir_names); $i++) {
		
            $dir_name = $dir_names[$i];
            if ($dir_name == '') {
                continue;
            }
            $path .= (($path == '') ? $dir_name : '/' . $dir_name);
            $component = array();
            $component['name'] = $dir_name;
            $component['path'] = $path;
            $components[] = $component;
        }
        return $components;
    }

    function get_files($sort_by, $sort_order) {
	$input = JFactory::getApplication()->input;

if(JRequest::getVar('dir')!='')
$dir=JRequest::getVar('dir');
else
$dir='';
	

        $icons_dir_url =  'components/com_gallery_wd/images/filemanager/file_icons';
        $valid_types = explode(',', strtolower(JRequest::getVar('extensions','*')));
        $parent_dir = $this->get_controller()->get_uploads_dir() . '/' . $dir;
        $parent_dir_url = $this->get_controller()->get_uploads_url() . '/' . $dir;
        $file_names = $this->get_sorted_file_names($parent_dir, $sort_by, $sort_order);

        $dirs = array();
        $files = array();

        foreach ($file_names as $file_name) {
            if (($file_name == '.') || ($file_name == '..')) {
                continue;
            }
			

            
			if (is_dir($parent_dir . '/' . $file_name)) {

                $file = array();
                $file['is_dir'] = true;
                $file['name'] = $file_name;
                $file['type'] = '';
                $file['thumb'] = $icons_dir_url . '/dir.png';
                $file['icon'] = $icons_dir_url . '/dir.png';
                $file['size'] = '';
                $file['date_modified'] = '';
				$file['resolution']='';
                $dirs[] = $file;

            } else {
                $file = array();

                $file['is_dir'] = false;
                $file['name'] = $file_name;
				$type=explode('.', $file_name);
				$end_type=end($type);
                $file['type'] = strtolower($end_type);
                $icon = $icons_dir_url . '/' . $file['type'] . '.png';
                if (file_exists($icon) == false) {
                    $icon = $icons_dir_url . '/' . '_blank.png';
                }
                $file['thumb'] = $this->is_img($file['type']) ? $parent_dir_url . '/thumb/' . $file_name : $icon;
                $file['icon'] = $icon;

                if (($valid_types[0] != '*') && (in_array($file['type'], $valid_types) == FALSE)) {
                    continue;
                }
									
                $file_size_kb = (int)(filesize($parent_dir . '/' . $file_name) / 1024);
                $file_size_mb = (int)($file_size_kb / 1024);
                $file['size'] = $file_size_kb < 1024 ? (string)$file_size_kb . 'KB' : (string)$file_size_mb . 'MB';
                $file['date_modified'] = date('d F Y, H:i', filemtime($parent_dir . '/' . $file_name));
               $image_info = getimagesize($parent_dir . '/' . $file_name);
				$file['resolution'] = $this->is_img($file['type']) ? $image_info[0]  . ' x ' . $image_info[1] . ' px' : '';


			   $files[] = $file;
			
            }
	
        }

		
        $result = $sort_order == 'asc' ? array_merge($dirs, $files) : array_merge($files, $dirs);


        return $result;
    }


	 public static function get_controller() {


			require_once 'components/com_gallery_wd/controllers/filemanager.php';
            $controller_class = 'gallery_wdControllerFilemanager';
            $controller = new $controller_class();
        
        return $controller;
    }
	
	
	
    private function get_sorted_file_names($parent_dir, $sort_by, $sort_order) {
  $file_names = scandir($parent_dir);

        switch ($sort_by) {
            case 'name':
                natcasesort($file_names);
                if ($sort_order == 'desc') {
                    $file_names = array_reverse($file_names);
                }
                break;
            case 'size':
                usort($file_names, function ($a, $b) use ($parent_dir, $sort_by, $sort_order) {
                    $size_of_a = filesize($parent_dir . '/' . $a);
                    $size_of_b = filesize($parent_dir . '/' . $b);
                    return $sort_order == 'asc' ? $size_of_a > $size_of_b : $size_of_a < $size_of_b;
                });
                break;
            case 'date_modified':
                usort($file_names, function ($a, $b) use ($parent_dir, $sort_by, $sort_order) {
                    $m_time_a = filemtime($parent_dir . '/' . $a);
                    $m_time_b = filemtime($parent_dir . '/' . $b);
                    return $sort_order == 'asc' ? $m_time_a > $m_time_b : $m_time_a < $m_time_b;
                });
                break;
        }

        return $file_names;
    }

    private function is_img($file_type) {
        switch ($file_type) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'bmp':
            case 'gif':
                return true;
                break;
        }

        return false;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}