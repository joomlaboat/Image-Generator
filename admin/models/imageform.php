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

if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');


/**
 * ImageGenerator - Image Form Model
 */
class imagegeneratorModelimageform extends JModelAdmin
{
        /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         
         */
		public $id;
		
		
        public function getTable($type = 'imagelist', $prefix = 'ImageGeneratorTable', $config = array()) 
        {
                return JTable::getInstance($type, $prefix, $config);
        }
        /**
         * Method to get the record form.
         *
         * @param       array   $data           Data for the form.
         * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
         * @return      mixed   A JForm object on success, false on failure
         
         */
        public function getForm($data = array(), $loadData = true) 
        {
                // Get the form.
				
                $form = $this->loadForm('com_imagegenerator.imageform', 'imageform', array('control' => 'jform', 'load_data' => $loadData)); //$loadData
                if (empty($form)) 
                {
                        return false;
                }
				
                return $form;
        }
		
		/**
         * Method to get the script that have to be included on the form
         *
         * @return string       Script files
         */
        public function getScript() 
        {
                return 'administrator/components/com_imagegenerator/models/forms/imageform.js';
        }
		
        /**
         * Method to get the data that should be injected in the form.
         *
         * @return      mixed   The data for the form.
         
         */
        protected function loadFormData() 
        {
                // Check the session for previously entered form data.
                $data = JFactory::getApplication()->getUserState('com_imagegenerator.edit.imageform.data', array());
                if (empty($data)) 
                {
                        $data = $this->getItem();
                }
                return $data;
        }
		
	function deleteImageList($cids)
        {

        	$imageform_row = $this->getTable('imagelist');

		$db = JFactory::getDBO();
            
        	if (count( $cids ))
        	{
        		foreach($cids as $cid)
        		{
				$query='DELETE FROM `#__imagegenerator_images` WHERE `id`='.(int)$cid;
			
				$db->setQuery($query);
				$db->execute();
				
				if (!$imageform_row->delete( $cid ))
					return false;
			}
        	}
		
		
		
        	return true;
        }
	

        function store()
        {
                
                
        	$imageform_row = $this->getTable('imagelist');
            
        	// consume the post data with allow_html
        	$data_ = JRequest::get( 'post',JREQUEST_ALLOWRAW);
		$data=$data_['jform'];
            
        	$post = array();
            
		$name=trim(preg_replace("/[^a-zA-Z0-9_]/", "", $data['profilename']));
		$data['jform']['profilename']=$name;
		
        	if (!$imageform_row->bind($data))
        	{
                echo 'Cannot bind.';
        		return false;
        	}
               
        	// Make sure the  record is valid
        	if (!$imageform_row->check())
        	{
                echo 'Cannot check.';
        		return false;
        	}

        	// Store
        	if (!$imageform_row->store())
        	{
				
                echo '<p>Cannot store.</p>
				<p>There are some fields missing.</p>
				';
        		return false;
        	}
	
		$this->id=$imageform_row->id;
			
        	return true;
        }
        
}
