<?php
/**
 * ImageGenerator Joomla! Native Component
 * @version 1.0.0
 * @author Ivan Komlev <support@joomlaboat.com>
 * @link http://www.joomlaboat.com
 * @GNU General Public License
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);
	
function ImageGeneratorBuildRoute(&$query) {


       $segments = array();
       if(isset($query['view']))
       {
	      if (empty($query['Itemid'])) {
		     $segments[] = $query['view'];
	      }
              unset( $query['view'] );
       }
       
       if(isset($query['imageid']))
       {
	      $segments[] = $query['imageid'];
	      unset( $query['video'] ); 
       }
       
       return $segments;

}

function ImageGeneratorParseRoute($segments)
{
       $vars = array();
       $vars['view'] = 'imagegenerator';
  
       $sIndex=0;


       if(isset($segments[$sIndex]))
       {
	      $vars['videoid'] = $segments[$sIndex];
	      
       }
       return $vars;
}

?>