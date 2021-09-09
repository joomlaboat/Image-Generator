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
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * imagelist Model
 */
class imagegeneratorModelimagelist extends JModelList
{
        /**
         * Method to build an SQL query to load the list data.
         *
         * @return string  An SQL query
         */
        protected function getListQuery()
        {
				$where=array();
				
				$context= 'com_imagegenerator.imagelist.';
                $mainframe = JFactory::getApplication();
                $search			= $mainframe->getUserStateFromRequest($context."search",'search','',	'string' );
				$search			=strtolower(trim(preg_replace("/[^a-zA-Z0-9 ]/", "", $search)));
				
                
				if($search!='')
						$where[]='instr(`profilename`,"'.$search.'")';

				
				
                // Create a new query object.         
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('*, #__imagegenerator_images.id AS id, profilename');
                // From the Image Generator table
                $query->from('#__imagegenerator_images');
				
				
				
				if(count($where)>0)
						$query->where(implode(' AND ',$where));
				
                return $query;
        }
    
        
       	
	function ConfirmRemove()
        {
				JRequest::setVar('hidemainmenu', true);
				JToolBarHelper::title(JText::_( 'COM_IMAGEGENERATOR_DELETE_IMAGELIST_S' ));
		
				$cancellink='index.php?option=com_imagegenerator&view=imagelist';
		
				$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
				
				echo '<h1>'.JText::_( 'COM_IMAGEGENERATOR_DELETE_IMAGELIST_S' ).'</h1>';
		
				if(count($cids)==0)
						return false;
		
				//Get Table Name
		
				if (count( $cids ))
				{
							
						echo '<ul>';
						
						$complete_cids=$cids;
						foreach($cids as $id)
						{
								$row=$this->getImageListItem($id);
								echo '<li>'.$row->profilename.'</li>';
						}
						
						echo '</ul>';
						
						if(count($complete_cids)>1)
								echo '<p>Total '.count($complete_cids).' Image Lists.</p>';
						

						echo '<br/><br/><p style="font-weight:bold;"><a href="'.$cancellink.'">'.JText::_( 'COM_IMAGEGENERATOR_NO_CANCEL' ).'</a></p>
            <form action="index.php?option=com_imagegenerator" method="post" >
            <input type="hidden" name="task" value="imagelist.remove_confirmed" />
';
						$i=0;
						foreach($complete_cids as $cid)
						        echo '<input type="hidden" id="cb'.$i.'" name="cid[]" value="'.$cid.'">';
            
						echo '
            <input type="submit" value="'.JText::_( 'COM_IMAGEGENERATOR_YES_DELETE' ).'" class="button" />
            </form>
';
						
				}
				else
						echo '<p><a href="'.$cancellink.'">'.JText::_( 'COM_IMAGEGENERATOR_NO_ITEMS_SELECTED' ).'</a></p>';

        }
		
		
	protected function getImageListItem($id)
	{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('`id`, `profilename`');
			$query->from('#__imagegenerator_images');
			$query->where('`id`='.$id);
			$db->setQuery((string)$query);
			$rows = $db->loadObjectList();
					
			if(count($rows)==0)
				return array();
			
			return $rows[0];
	}
		
	public function getTable($type = 'imagelist', $prefix = 'ImageGeneratorTable', $config = array()) 
        {
                return JTable::getInstance($type, $prefix, $config);
        }
		
	function copyItem($cid)
	{


				$item = $this->getTable('imagelist');
				
	    
		
				foreach( $cid as $id )
				{
			
		
						$item->load( $id );
						$item->id 	= NULL;
		
						$old_title=$item->profilename;
						$new_title='Copy of '.$old_title;
		
						$item->profilename 	= $new_title;
			
	
		
						if (!$item->check()) {
							return false;
						}
		
						if (!$item->store()) {
							return false;
						}
						$item->checkin();
							
				}//foreach( $cid as $id )
		
				return true;
	}//function copyItem($cid)
    
      
}
