<?php
/**
 * ImageGenerator Joomla! Native Component
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/


// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * ImageGenerator Component Controller
 */

jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;

if($JoomlaVersionRelease>=3.0)
{
    class ImageGeneratorController extends JControllerLegacy
    {
    }
}
else
{
    class ImageGeneratorController extends JController
    {
    }
}
