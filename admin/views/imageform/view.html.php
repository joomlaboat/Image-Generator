<?php
/**
 * ImageGenerator Joomla! 3.0 Native Component
 * @version 1.0.0
 * @author Ivan Komlev< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);
        
// import Joomla view library
jimport('joomla.application.component.view');


jimport('joomla.version');
$version = new JVersion();
$JoomlaVersionRelease=$version->RELEASE;

if($JoomlaVersionRelease>=3.0)
{
        //joomla 3.x
 
/**
 * Image Generator - Image Form View
 */
class imagegeneratorViewimageform extends JViewLegacy
{
        /**
         * display method of Image Generator view
         * @return void
         */
        public function display($tpl = null) 
        {
		

                $form = $this->get('Form');

		
                $item = $this->get('Item');

                $script = $this->get('Script');

                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                
                // Assign the Data
                $this->form = $form;
                $this->item = $item;
                $this->script = $script;

                // Set the toolbar
                $this->addToolBar();
 
                // Display the template
		
                parent::display($tpl);
                
                // Set the document
        }
 
        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
                JRequest::setVar('hidemainmenu', true);
                $isNew = ($this->item->id == 0);
                JToolBarHelper::title($isNew ? JText::_('COM_IMAGEGENERATOR_IMAGEFORM_NEW') : JText::_('COM_IMAGEGENERATOR_IMAGEFORM_EDIT'));
                JToolBarHelper::apply('imageform.apply');
                JToolBarHelper::save('imageform.save');
                JToolBarHelper::cancel('imageform.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
        }
        
        /**
        * Method to set up the document properties
        *
        * @return void
        */
        protected function setDocument() 
        {
                $isNew = ($this->item->id < 1);
                $document = JFactory::getDocument();
                $document->setTitle($isNew ? JText::_('COM_IMAGEGENERATOR_IMAGEFORM_NEW') : JText::_('COM_IMAGEGENERATOR_IMAGEFORM_EDIT'));
                $document->addScript(JURI::root() . $this->script);
                $document->addScript(JURI::root() . "/administrator/components/com_imagegenerator/views/imageform/submitbutton.js");
                JText::script('COM_IMAGEGENERATOR_FORMEDIT_ERROR_UNACCEPTABLE');
        }
}//class

}
else
{
        // for joomla 2.5
        /**
 * Image Generator - Image Form View
 */
class imagegeneratorViewimageform extends JView
{
        /**
         * display method of Image Generator view
         * @return void
         */
        public function display($tpl = null) 
        {
		

                $form = $this->get('Form');

                $item = $this->get('Item');

                $script = $this->get('Script');

                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                
                // Assign the Data
                $this->form = $form;
                $this->item = $item;
                $this->script = $script;

                // Set the toolbar
                $this->addToolBar();
 
                // Display the template
                parent::display($tpl);
                
                // Set the document
		
        }
 
        /**
         * Setting the toolbar
         */
        protected function addToolBar() 
        {
                JRequest::setVar('hidemainmenu', true);
                $isNew = ($this->item->id == 0);
                JToolBarHelper::title($isNew ? JText::_('COM_IMAGEGENERATOR_IMAGEFORM_NEW') : JText::_('COM_IMAGEGENERATOR_IMAGEFORM_EDIT'));
                JToolBarHelper::apply('imageform.apply');
                JToolBarHelper::save('imageform.save');
                JToolBarHelper::cancel('imageform.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
        }
        
        /**
        * Method to set up the document properties
        *
        * @return void
        */
        protected function setDocument() 
        {
                $isNew = ($this->item->id < 1);
                $document = JFactory::getDocument();
                $document->setTitle($isNew ? JText::_('COM_IMAGEGENERATOR_IMAGEFORM_NEW') : JText::_('COM_IMAGEGENERATOR_IMAGEFORM_EDIT'));
                $document->addScript(JURI::root() . $this->script);
                $document->addScript(JURI::root() . "/administrator/components/com_imagegenerator/views/imageform/submitbutton.js");
                JText::script('COM_IMAGEGENERATOR_FORMEDIT_ERROR_UNACCEPTABLE');
        }
}//class

}


?>