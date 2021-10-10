<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class gallery_wdModeladdTags extends JModelLegacy {
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
   
  
  public function get_image_data($id) {
    $db =JFactory::getDBO();
	$query="SELECT * FROM #__bwg_image WHERE id='".$db->escape($id)."'";
	$db->setQuery($query);
	$row = $db->loadObject();
    return $row;
  }

    public function get_rows_data() {
    $db =JFactory::getDBO();
    $where = ((isset($_POST['search_value']) && (htmlspecialchars(stripslashes($_POST['search_value'])) != '')) ? ' WHERE name LIKE "%' . $db->escape(htmlspecialchars(stripslashes($_POST['search_value']))) . '%"' : '');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? htmlspecialchars(stripslashes($_POST['asc_or_desc'])) : 'asc');
    $order_by = ' ORDER BY ' . ((isset($_POST['order_by']) && htmlspecialchars(stripslashes($_POST['order_by'])) != '') ? htmlspecialchars(stripslashes($_POST['order_by'])) : 'name') . ' ' . $asc_or_desc;
    if (isset($_POST['page_number']) && $_POST['page_number']) {
      $limit = ((int) $_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }

	$query = "SELECT id as term_id ,  name ,  slug FROM #__bwg_tags AS table1  " . $where . $order_by . " LIMIT " . $limit . ",20";
	
	
	$db->setQuery($query);
    $rows = $db->loadObjectList();
    return $rows;
  }
  
   
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}