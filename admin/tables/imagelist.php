<?php
/**
 * ImageGenerator Joomla! Native Component
 * @version 1.0.0
 * @author Ivan Komlev< <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * Image Generator - Video Lists Table class
 */
class ImageGeneratorTableimagelist extends JTable
{
        /**
         * Constructor
         *
         * @param object Database connector object
         */

		var $id = null;
		var $profilename = null;
		var $width = null;
		var $height = null;
		var $background = null;
		var $fileformat = null;
		var $fileformatparam = null;
		var $outputfilename = null;
		var $options = null;
		
  
        function __construct(&$db) 
        {
                parent::__construct('#__imagegenerator_images', 'id', $db);
        }
}

?>