<?php
/**
 * ImageGenerator Joomla! Native Component
 * @version 1.0.0
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of ImageGenerator component
 */
jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;

if($JoomlaVersionRelease>=3.0)
{
    
    class ImageGeneratorController extends JControllerLegacy
    {
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = null) 
        {
                // set default view if not set
                JRequest::setVar('view', JRequest::getCmd('view', 'imagelist'));
                
                // call parent behavior
                parent::display($cachable);
        }
    }
}
else
{
    class ImageGeneratorController extends JController
    {
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = null) 
        {
                // set default view if not set
                JRequest::setVar('view', JRequest::getCmd('view', 'imagelist'));
                
                // call parent behavior
                parent::display($cachable);
        }
    }
}
