<?php
/**
 * ImageGenerator Joomla! Native Component
 * @author Ivan Komlev <support@joomlaboat.com>
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
 * ImageGenerator Imagelist View
 */

class imagegeneratorViewimagelist extends JViewLegacy
{
        /**
         * ImageGenerator view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $items = $this->get('Items');
                $pagination = $this->get('Pagination');
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;

                // Set the toolbar
                $this->addToolBar();
                
                $context= 'com_imagegenerator.imagelist.';
                $mainframe = JFactory::getApplication();
                $search			= $mainframe->getUserStateFromRequest($context."search",'search','',	'string' );
                $search			= JString::strtolower( $search );
                
                $lists['search']=$search;
                
                
                $filter_category= $mainframe->getUserStateFromRequest($context."filter_category",'filter_category','',	'integer' );
                
                
               // $available_categories=$this->getAllCategories();
                $javascript = 'onchange="document.adminForm.submit();"';
                //$lists['categories']=JHTML::_('select.genericlist', $available_categories, 'filter_category', $javascript ,'id','categoryname', $filter_category);
                
                $this->assignRef('lists', $lists);
                
                
                // Display the template
                parent::display($tpl);
        }
        
        /**
         * Setting the toolbar
        */
        protected function addToolBar() 
        {
                JToolBarHelper::title(JText::_('COM_IMAGEGENERATOR_IMAGELIST'));
                
                
                JToolBarHelper::addNew('imageform.add');
                JToolBarHelper::editList('imageform.edit');
                JToolBarHelper::custom( 'imagelist.copyItem', 'copy.png', 'copy_f2.png', 'Copy', true);
		
                JToolBarHelper::deleteList('', 'imagelist.delete');
                
        }
        
        
       
        
        function array_insert(&$array, $insert, $position = -1)
        {
                $position = ($position == -1) ? (count($array)) : $position ;
                if($position != (count($array))) {
                $ta = $array;
                for($i = $position; $i < (count($array)); $i++)
                {
                        if(!isset($array[$i])) {
                                 die("\r\nInvalid array: All keys must be numerical and in sequence.");
                        }
                        $tmp[$i+1] = $array[$i];
                        unset($ta[$i]);
                }       
                $ta[$position] = $insert;
                $array = $ta + $tmp;

                } else {
                     $array[$position] = $insert;
                }
                ksort($array);
                return true;
        }   
        
}//class

}else
{
	//for joomla 2.5
	/**
 * ImageGenerator Imagelist View
 */
class imagegeneratorViewimagelist extends JView
{
        /**
         * ImageGenerator view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $items = $this->get('Items');
                $pagination = $this->get('Pagination');
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;

                // Set the toolbar
                $this->addToolBar();
                
                $context= 'com_imagegenerator.imagelist.';
                $mainframe = JFactory::getApplication();
                $search			= $mainframe->getUserStateFromRequest($context."search",'search','',	'string' );
                $search			= JString::strtolower( $search );
                
                $lists['search']=$search;
                
                
                //$filter_category= $mainframe->getUserStateFromRequest($context."filter_category",'filter_category','',	'integer' );
                
                
                //$available_categories=$this->getAllCategories();
                $javascript = 'onchange="document.adminForm.submit();"';
                //$lists['categories']=JHTML::_('select.genericlist', $available_categories, 'filter_category', $javascript ,'id','categoryname', $filter_category);
                
                $this->assignRef('lists', $lists);
                
                
                // Display the template
                parent::display($tpl);
        }
        
        /**
         * Setting the toolbar
        */
        protected function addToolBar() 
        {
                JToolBarHelper::title(JText::_('COM_IMAGEGENERATOR_IMAGELIST'));
                
                
                JToolBarHelper::addNewX('imageform.add');
                JToolBarHelper::editListX('imageform.edit');
                JToolBarHelper::customX( 'imagelist.copyItem', 'copy.png', 'copy_f2.png', 'Copy', true);
		JToolBarHelper::custom( 'imagelist.updateItem', 'refresh.png', 'refresh_f2.png', 'Update', true);
		JToolBarHelper::custom( 'imagelist.refreshItem', 'purge.png', 'purge_f2.png', 'Refresh', true);
                JToolBarHelper::deleteListX('', 'imagelist.delete');
                
        }
        
        
       
        
        function array_insert(&$array, $insert, $position = -1)
        {
                $position = ($position == -1) ? (count($array)) : $position ;
                if($position != (count($array))) {
						$ta = $array;
						for($i = $position; $i < (count($array)); $i++)
						{
						        if(!isset($array[$i])) {
						                 die("\r\nInvalid array: All keys must be numerical and in sequence.");
						        }
						        $tmp[$i+1] = $array[$i];
						        unset($ta[$i]);
						}       
						$ta[$position] = $insert;
						$array = $ta + $tmp;

                } else {
                     $array[$position] = $insert;
                }
                ksort($array);
                return true;
        }   
        
}//class

	
	
}//if