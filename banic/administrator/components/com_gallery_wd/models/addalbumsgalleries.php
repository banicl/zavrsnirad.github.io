<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class gallery_wdModelAddAlbumsGalleries extends JModelLegacy {
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
   
  

    public function get_rows_data($album_id) {
    $db =JFactory::getDBO();
    $where = ((isset($_POST['search_value']) && (htmlspecialchars(stripslashes($_POST['search_value'])) != '')) ? ' AND name LIKE "%' . $db->escape(htmlspecialchars(stripslashes($_POST['search_value']))) . '%"' : '');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? htmlspecialchars(stripslashes($_POST['asc_or_desc'])) : 'asc');
    $order_by = ' ORDER BY ' . ((isset($_POST['order_by']) && htmlspecialchars(stripslashes($_POST['order_by'])) != '') ? htmlspecialchars(stripslashes($_POST['order_by'])) : 'name') . ' ' . $asc_or_desc;
    if (isset($_POST['page_number']) && $_POST['page_number']) {
      $limit = ((int) $_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
	
	
    $query = "SELECT id, name, 1 as is_album FROM #__bwg_album WHERE published=1 AND id<>" . $db->escape($album_id) . " " . $where . " UNION SELECT id, name, 0 as is_album FROM #__bwg_gallery WHERE published=1" . $where . $order_by . " LIMIT " . $limit . ",20";
	
	
	$db->setQuery($query);
    $rows = $db->loadObjectList();
    return $rows;
  }
  
    public function page_nav() {
    $db =JFactory::getDBO();
    $where = ((isset($_POST['search_value']) && (htmlspecialchars(stripslashes($_POST['search_value'])) != '')) ? ' AND name LIKE "%' . $db->escape(htmlspecialchars(stripslashes($_POST['search_value']))) . '%"' : '');
    $query = "SELECT id, name, 1 FROM #__bwg_album WHERE published=1" . $where . " UNION SELECT id, name, 0 FROM #__bwg_gallery WHERE published=1" . $where;
$db->setQuery($query);	
    $total = $db->loadResult();
    $page_nav['total'] = $total;
    if (isset($_POST['page_number']) && $_POST['page_number']) {
      $limit = ((int) $_POST['page_number'] - 1) * 20;
    }
    else {
      $limit = 0;
    }
    $page_nav['limit'] = (int) ($limit / 20 + 1);
    return $page_nav;
  }
  
   
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}