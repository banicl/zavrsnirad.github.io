<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die('Restricted access');
$user = JFactory::getUser();
if (!$user->authorise('core.manage', 'com_gallery_wd')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
if ($user->authorise('core.admin', 'com_gallery_wd')) 
{
JToolBarHelper::preferences('com_gallery_wd');	
}

/////////////////////////////////////PERMISSIONS
$task=JRequest::getVar('task');
$controller_task=explode('.',$task);
if(isset($controller_task[1]))
$task=$controller_task[1];


if(!$user->authorise('core.create', 'com_gallery_wd') and ($task=="add" or $task=="save_tag" ))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

if(!$user->authorise('core.edit', 'com_gallery_wd') and ($task=="edit" or $task=="unpublish" or $task=="publish" or $task=="save_option" or $task=="reset" or $task=="save_order"))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}


if(!$user->authorise('core.delete', 'com_gallery_wd') and ($task=="delete" OR $task=="delete_all" ))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}


//////////////////////////////////////PERMISSIONS END


		$db	= JFactory::getDBO();
$query="SELECT MAX(version_id) FROM #__schemas";
$db->setQuery($query);
$version=$db->loadResult();

if((float)$version>3.1)
JHtml::_('behavior.tabstate');

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_gallery_wd/tables');

define('WD_BWG_DIR', JPATH_COMPONENT_SITE);
define('WD_BWG_URL', JURI::root().'components/com_gallery_wd');
require_once JPATH_COMPONENT_ADMINISTRATOR .  '/helpers/submenu.php';
require_once JPATH_SITE .  '/components/com_gallery_wd/framework/WDWLibraryEmbed.php';
require_once JPATH_SITE .  '/components/com_gallery_wd/framework/WDWLibrary.php';



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


$query='SELECT watermark_url,built_in_watermark_url FROM #__bwg_option WHERE id=1';
$db->setQuery($query);
$watermark_urls=$db->loadObject();
$watermark_url='components/com_gallery_wd/images/watermark.png';
if($watermark_urls->watermark_url=='components/com_gallery_wd/images/watermark.png')
{
$query='UPDATE #__bwg_option SET watermark_url="'.JURI::root().$watermark_url.'" WHERE id=1';
$db->setQuery($query);
$db->query();
}

if($watermark_urls->built_in_watermark_url=='components/com_gallery_wd/images/watermark.png')
{
$query='UPDATE #__bwg_option SET built_in_watermark_url="'.JURI::root().$watermark_url.'" WHERE id=1';
$db->setQuery($query);
$db->query();
}

$document		=JFactory::getDocument();
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/bwg_tables.css" type="text/css" rel="stylesheet');
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/bwg_licensing.css" type="text/css" rel="stylesheet');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.ui.js');

$document->addScript(JURI::root() . 'components/com_gallery_wd/js/bwg.js');
// Execute the task.


//////////////ON UPDATE






/////////END UPDATE



$task='';
if(JRequest::getVar('task')!='')
{
if(strpos(JRequest::getVar('task'),'.'))
{
$task_array=explode('.',JRequest::getVar('task'));
$task=$task_array[1];
}
else
$task=JRequest::getVar('task');
}


if($task=='' or ($task!="add" AND $task!=='edit' ))
SpidermpSubMenu::build();


if($task=="addEmbed")
{
    $url_to_embed = JRequest::getVar('URL_to_embed');
    $host = JRequest::getVar('host');

    $data = WDWLibraryEmbed::add_embed($url_to_embed,$host);

    echo WDWLibrary::delimit_wd_output($data);
exit;
}


$controller = JControllerLegacy::getInstance('gallery_wd');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
