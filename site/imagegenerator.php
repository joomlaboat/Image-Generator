<?php
/**
 * ImageGenerator Joomla! Native Component
 * @version 1.0.0
 * @author Ivan Komlev< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by ImageGenerator

jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;

if($JoomlaVersionRelease>=3.0)
{
    $controller = JControllerLegacy::getInstance('ImageGenerator');
}
else
{
    $controller = JController::getInstance('ImageGenerator');
}


 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();


?>


