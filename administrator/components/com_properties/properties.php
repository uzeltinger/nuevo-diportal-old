<?php
/**
 * @version		$Id: properties.php 1 2010-2014 este8an $
 * @package		Joomla.Administrator
 * @subpackage	com_properties
 * @copyright	Copyright (C) 2008 - 2016 Fabio Esteban Uzeltinger.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_properties')) {
	return JFactory::getApplication()->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');
}
$doc = JFactory::getDocument();
$doc->addStyleSheet('components/com_properties/includes/css/properties.css');
JLoader::register('PropertiesHelper', __DIR__ . '/helpers/helper.php');
$controller = JControllerLegacy::getInstance('Properties');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();