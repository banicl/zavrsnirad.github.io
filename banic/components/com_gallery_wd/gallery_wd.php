<?php

 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');
JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_gallery_wd/tables');

// import joomla controller library
jimport('joomla.application.component.controller');
define('WD_BWG_DIR', JPATH_COMPONENT_SITE);
define('WD_BWG_URL', JURI::root().'components/com_gallery_wd');

$db		=JFactory::getDBO();
$query="SHOW TABLES LIKE '#__bwg_option'";
$db->setQuery($query);


if ($db->query()) {

$query='SELECT images_directory FROM #__bwg_option WHERE id=1';
$db->setQuery($query);
define('WD_BWG_UPLOAD_DIR', $db->loadResult() . '/com_gallery_wd/uploads');
}
else {
 
define('WD_BWG_UPLOAD_DIR', "administrator/components/com_gallery_wd/uploads");
}

$document		=JFactory::getDocument();

$document->addScript(JURI::root() . 'components/com_gallery_wd/js/bwg_frontend.js');
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/bwg_frontend.css" type="text/css" rel="stylesheet');
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/jquery.mCustomScrollbar.css" type="text/css" rel="stylesheet');
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/jquery-ui-1.10.3.custom.css" type="text/css" rel="stylesheet');

$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/font-awesome-4.0.1/font-awesome.css" type="text/css" rel="stylesheet');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.ui.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery-migrate-1.2.1.js');
$view=JRequest::getVar('view');
//$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.fullscreen-0.4.1.js');
if($view!='captcha')
echo "<script src='".JURI::root() ."components/com_gallery_wd/js/jquery.fullscreen-0.4.1.js'></script>";

$document->addScript(JURI::root() . 'components/com_gallery_wd/js/bwg_gallery_box.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/3DEngine/3DEngine.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/3DEngine/Sphere.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.mCustomScrollbar.concat.min.js');

if($view!='captcha')
echo "<script src='".JURI::root() ."components/com_gallery_wd/js/jquery.raty.js'></script>";




//$document->addScriptDeclaration('var bwg_objectL10n = {bwg_field_required: "field is required.", bwg_mail_validation: "This is not a valid email address."};');

// Get an instance of the controller prefixed by gallery_wd
$controller = JControllerLegacy::getInstance('gallery_wd');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();