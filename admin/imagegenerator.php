<?php
/**
 * Image Generator Joomla! Native Component
 * @version 1.0.0
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/


// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);

if(isset($_POST['task']))
	$task=$_POST['task'];
else
	$task='';

$view=JRequest::getCmd( 'view');
/*
$t='categories.delete';

if($view=='' and $task==$t)
{
	$controllerName = 'categories';
	JRequest::setVar('view', 'categories');
}
else
*/
	$controllerName = JRequest::getCmd( 'view', 'imagelist' );
 


switch($controllerName)
{
	case 'imagelist':
	
		JSubMenuHelper::addEntry(JText::_('Image List'), 'index.php?option=com_imagegenerator&view=imagelist', true);
		
	break;

}
 

jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;

if($JoomlaVersionRelease>=3.0)
	$controller = JControllerLegacy::getInstance('ImageGenerator');
else
	$controller = JController::getInstance('ImageGenerator');
	
// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();

?>