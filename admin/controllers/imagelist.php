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
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Image Generator - Imagelist Controller
 */

class ImageGeneratorControllerImageList extends JControllerAdmin
{
		/**
		* Proxy for getModel.
		*/
		
		function display($cachable = false, $urlparams = array())
		{
				$task=JRequest::getVar( 'task');

				switch($task)
				{
						case 'delete':
								$this->delete();
								break;
						case 'imagelist.delete':
								$this->delete();
								break;
						case 'remove_confirmed':
								$this->remove_confirmed();
								break;
						case 'imagelist.remove_confirmed':
								$this->remove_confirmed();
								break;
						case 'copyItem':
								$this->copyItem();
								break;
						case 'imagelist.copyItem':
								$this->copyItem();
								break;
						case 'refreshItem':
								$this->refreshItem();
								break;
						case 'imagelist.refreshItem':
								$this->refreshItem();
								break;
						case 'updateItem':
								$this->updateItem();
								break;
						case 'imagelist.updateItem':
								$this->updateItem();
								break;
						
						default:
								JRequest::setVar( 'view', 'imagelist');
								parent::display();
								break;
				}
		
				
		}
		
		public function getModel($name = 'Imagelist', $prefix = 'ImageGeneratorModel', $config = array()) 
		{
		        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
		        return $model;
		}
 
		public function updateItem()
		{
				$model = $this->getModel('imageform');
				$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );

				if (count($cid)<1)
				{
						$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist', JText::_('COM_IMAGEGENERATOR_NO_ITEMS_SELECTED'),'error' );
                				return false;
				}
					    	    
				if($model->RefreshPlayist($cid,true))
				{
						$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_UPDATED_SUCCESSFULLY' );
						$link 	= 'index.php?option=com_imagegenerator&view=imagelist';
						$this->setRedirect($link, $msg);
				}
				else
				{
						$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_WAS_UNABLE_TO_UPDATE' );
						$link 	= 'index.php?option=com_imagegenerator&view=imagelist';
						$this->setRedirect($link, $msg,'error');
				}

		}
		
		public function refreshItem()
		{
				
				$model = $this->getModel('imageform');
        	
				
				$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
	    
				if (count($cid)<1) {
		
						$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist', JText::_('COM_IMAGEGENERATOR_NO_ITEMS_SELECTED'),'error' );
                
						return false;
				}
					    	    
				if($model->RefreshPlayist($cid,false))
				{
						$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_REFRESHED_SUCCESSFULLY' );
						$link 	= 'index.php?option=com_imagegenerator&view=imagelist';
						$this->setRedirect($link, $msg);
				}
				else
				{
						$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_WAS_UNABLE_TO_REFRESH' );
						$link 	= 'index.php?option=com_imagegenerator&view=imagelist';
						$this->setRedirect($link, $msg,'error');
				}

		}
 
        
		public function delete()
		{
                
				// Check for request forgeries
				JRequest::checkToken() or jexit( 'Invalid Token' );
        	
				$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );

				if (count($cid)<1)
				{

						$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist', JText::_('COM_IMAGEGENERATOR_NO_VIDEOLISTS_SELECTED'),'error' );
						return false;
				}
		
				$model = $this->getModel();
        	
				$model->ConfirmRemove();
		}
	
		public function remove_confirmed()
		{
		
				// Get some variables from the request
				$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

				if (count($cid)<1)
				{
					$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist', JText::_('COM_IMAGEGENERATOR_NO_VIDEOLISTS_SELECTED'),'error' );
					return false;
				}

				$model = $this->getModel('imageform');
				if ($n = $model->deleteImageList($cid))
				{
					$msg = JText::sprintf( 'COM_IMAGEGENERATOR_IMAGELIST_S_DELETED', $n );
					$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist', $msg );
				}else
				{
					$msg = $model->getError();
				$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist', $msg,'error' );
				}
		}
		
		public function copyItem()
		{
				
				$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
	    
				$model = $this->getModel('imagelist');
	    
	    
				if($model->copyItem($cid))
				{
						$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_COPIED_SUCCESSFULLY' );
						$link 	= 'index.php?option=com_imagegenerator&view=imagelist';
						$this->setRedirect($link, $msg);
				}
				else
				{
						$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_WAS_UNABLE_TO_COPY' );
						$link 	= 'index.php?option=com_imagegenerator&view=imagelist';
						$this->setRedirect($link, $msg,'error');
				}
	    	}

}

?>