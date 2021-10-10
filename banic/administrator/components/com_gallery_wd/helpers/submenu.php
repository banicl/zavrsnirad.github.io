<?php

 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('_JEXEC') or die('Restricted access'); 

class SpidermpSubMenu {
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
    public static function build() {
        $input = JFactory::getApplication()->input;
        $input_view = $input->get('view') ? $input->get('view') : 'galleries';


        JSubMenuHelper::addEntry(JText::_('Add Galleries/Images'), 'index.php?option=com_gallery_wd&view=galleries', $input_view == 'galleries' ? true : false);
        JSubMenuHelper::addEntry(JText::_('Albums'), 'index.php?option=com_gallery_wd&view=albums', $input_view == 'albums' ? true : false);
        JSubMenuHelper::addEntry(JText::_('Tags'), 'index.php?option=com_gallery_wd&view=tags', $input_view == 'tags' ? true : false);
        
		JSubMenuHelper::addEntry(JText::_('Options'), 'index.php?option=com_gallery_wd&view=options', $input_view == 'options' ? true : false);
		
		JSubMenuHelper::addEntry(JText::_('Themes'), 'index.php?option=com_gallery_wd&view=themes', $input_view == 'themes' ? true : false);
		
		//JSubMenuHelper::addEntry(JText::_('Comments'), 'index.php?option=com_gallery_wd&view=comments', $input_view == 'comments' ? true : false);
		JSubMenuHelper::addEntry(JText::_('Generate Shortcode'), 'index.php?option=com_gallery_wd&view=shortcode', $input_view == 'shortcode' ? true : false);
       JSubMenuHelper::addEntry(JText::_('Licensing'), 'index.php?option=com_gallery_wd&view=licensing', $input_view == 'licensing' ? true : false);

    }


	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}