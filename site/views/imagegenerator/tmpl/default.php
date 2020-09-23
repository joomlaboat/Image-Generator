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

require_once(JPATH_SITE.DS.'components'.DS.'com_imagegenerator'.DS.'includes'.DS.'include.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_imagegenerator'.DS.'includes'.DS.'misc.php');

if(!isset($this->imageprofile))
{
    echo 'Image Profile Not Selected';
    die;
}

if (ob_get_contents()) ob_end_clean();

$IG=new IG();

$IG->setImageGeneratorProfile($this->imageprofile);

$IG->setInstructions($this->imageprofile->options);

$obj=null;
$IG->render(true,$obj);

die;

?>