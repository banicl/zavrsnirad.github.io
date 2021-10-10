<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class gallery_wdModelShortcode extends JModelLegacy {
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
   
  
  public function get_gallery_rows_data() {
    $db =JFactory::getDBO();
	$query="SELECT * FROM #__bwg_gallery WHERE published=1 ORDER BY name";
	$db->setQuery($query);
    $rows = $db->loadObjectList();
    return $rows;
  }

  public function get_album_rows_data() {
    $db =JFactory::getDBO();
    $query = "SELECT * FROM #__bwg_album WHERE published=1 ORDER BY name";
	$db->setQuery($query);
    $rows = $db->loadObjectList();
    return $rows;
  }

  public function get_option_row_data() {
    $db =JFactory::getDBO();
    $query = "SELECT * FROM #__bwg_option WHERE id=1";
	$db->setQuery($query);
    $rows = $db->loadObject();
    return $rows;
  }

  public function get_theme_rows_data() {
    $db =JFactory::getDBO();
    $query = "SELECT * FROM #__bwg_theme ORDER BY name";
	$db->setQuery($query);
    $rows = $db->loadObjectList();
    return $rows;
  }

   
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}