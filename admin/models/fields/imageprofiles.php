<?php
/**
 * Image Generator Joomla! Native Component
 * @version 1.0.0
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * Image Generator Form Field class for the Youtube Gallery component
 */
class JFormFieldImageProfiles extends JFormFieldList
{
        /**
         * The field type.
         *
         * @var         string
         */
        protected $type = 'imageprofiles';
 
        /**
         * Method to get a list of options for a list input.
         *
         * @return      array           An array of JHtml options.
         */
        protected function getOptions() 
        {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('id,profilename');
                $query->from('#__imagegenerator_images');
                $db->setQuery((string)$query);
                $messages = $db->loadObjectList();
                $options = array();
                if ($messages)
                {
                        foreach($messages as $message) 
                        {
                                $options[] = JHtml::_('select.option', $message->id, $message->profilename);
                                
                        }
                }
                
                $options = array_merge(parent::getOptions(), $options);
                return $options;
        }
        
        
}

