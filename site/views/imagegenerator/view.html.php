<?php
/**
 * ImageGenerator Joomla! 3.0 Native Component
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the ImageGenerator Component
 */
jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;

if($JoomlaVersionRelease>=3.0)
{
        
        class ImageGeneratorViewImageGenerator extends JViewLegacy
        {
        // Overwriting JView display method
        function display($tpl = null) 
        {
                // Assign data to the view
		$app		= JFactory::getApplication();
                
                $this->Model = $this->getModel();
		
		$this->assignRef('model',$this->Model);
		$this->assignRef('imageprofile',$this->Model->imageprofile);
                $this->assignRef('instructions',$this->Model->instructions);
		
		
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                
 
                // Display the view
                parent::display($tpl);
        }
        }
}
else
{
        class ImageGeneratorViewImageGenerator extends JView
        {
        // Overwriting JView display method
        function display($tpl = null) 
        {
                // Assign data to the view
		$app		= JFactory::getApplication();
		
                $this->Model = $this->getModel();
                
		$this->assignRef('model',$this->Model);
		$this->assignRef('imageprofile',$this->Model->imageprofile);
                $this->assignRef('instructions',$this->Model->instructions);
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                
 
                // Display the view
                parent::display($tpl);
        }
        }  
}
