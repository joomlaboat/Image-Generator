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
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * ImageGenerator - Image Form Controller
 */
class ImageGeneratorControllerImageForm extends JControllerForm
{
       /**
         * Proxy for getModel.
       */
       
       	function display($cachable = false, $urlparams = array())
	{
		$task=$_POST['task'];
		
	
		if($task=='imageform.add' or $task=='add' )
		{
			$this->setRedirect( 'index.php?option=com_imagegenerator&view=imageform&layout=edit');
			return true;
		}
		
		if($task=='imageform.edit' or $task=='edit' )
		{
			$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );

			if (!count($cid))
			{
				$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist', JText::_('COM_IMAGEGENERATOR_NO_IMAGELISTS_SELECTED'),'error' );
				return false;
			}
			
			$this->setRedirect( 'index.php?option=com_imagegenerator&view=imageform&layout=edit&id='.$cid[0]);
			return true;
		}
	
		JRequest::setVar( 'view', 'imageform');
		JRequest::setVar( 'layout', 'edit');
		
		switch(JRequest::getVar( 'task'))
		{
		case 'apply':
			$this->save();
			break;
		case 'imageform.apply':
			$this->save();
			break;
		case 'save':
			$this->save();
			break;
		case 'imageform.save':
			$this->save();
			break;
		case 'cancel':
			$this->cancel();
			break;
		case 'imageform.cancel':
			$this->cancel();
			break;
		default:
			parent::display();
			break;
		}
		
	}

       
	function save($key = NULL, $urlVar = NULL)
	{
		$task = JRequest::getVar( 'task');
		
		// get our model
		$model = $this->getModel('imageform');
		// attempt to store, update user accordingly
		
		if($task != 'save' and $task != 'apply' and $task != 'imageform.save' and $task != 'imageform.apply' )
		{
			$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGE_WAS_UNABLE_TO_SAVE');
			$this->setRedirect($link, $msg, 'error');
		}
		
		
		if ($model->store())
		{
		
			if($task == 'save' or $task == 'imageform.save')
				$link 	= 'index.php?option=com_imagegenerator&view=imagelist';
			elseif($task == 'apply' or $task == 'imageform.apply')
			{
	
				
				$link 	= 'index.php?option=com_imagegenerator&view=imageform&layout=edit&id='.$model->id;
			}
			
			$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_SAVED_SUCCESSFULLY' );
			
			$this->setRedirect($link, $msg);
		}
		else
		{
			  //die;
			$link 	= 'index.php?option=com_imagegenerator&view=imageform&layout=edit&id='.$model->id;
			$msg = JText::_( 'COM_IMAGEGENERATOR_IMAGELIST_WAS_UNABLE_TO_SAVE');
			$this->setRedirect($link, $msg, 'error');
		}
			
	}
	
	/**
	* Cancels an edit operation
	*/
	/*function cancelItem()
	{
		

		$model = $this->getModel('item');
		$model->checkin();

		
		
	}*/

	/**
	* Cancels an edit operation
	*/
	function cancel($key = NULL)
	{
		$this->setRedirect( 'index.php?option=com_imagegenerator&view=imagelist');
	}

	/**
	* Form for copying item(s) to a specific option
	*/
}
