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
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
jimport('joomla.application.menu' );


require_once(JPATH_SITE.DS.'components'.DS.'com_imagegenerator'.DS.'includes'.DS.'misc.php');

/**
 * ImageGenerator Model
 */
class ImageGeneratorModelImageGenerator extends JModelItem
{
    public $imageprofile;
    public $instructions;
    
    function __construct()
	{
        $imageprofile=array();
        $instructions=array();
        
		parent::__construct();
        $app	= JFactory::getApplication();
		$params	= $app->getParams();
        
        $imageid=(int)$params->get('imageid');
        if($imageid==0)
            return;
            
        //Load Row
        	
		$db = JFactory::getDBO();
		
		$query = 'SELECT * FROM `#__imagegenerator_images` WHERE `id`='.(int)$imageid.' LIMIT 1';
		$db->setQuery($query);

		$rows = $db->loadObjectList();
				
		if(count($rows)==0)
			return;
		
        $this->imageprofile=$rows[0];
        
        //if(isset($this->imageprofile->options))
           // $this->parseOptions();

    }
    
    
    
    /*
    
    
    protected function parseOptions()
    {
		$mainframe = JFactory::getApplication('site');
		$params_ = $mainframe->getParams('com_content');
	
        $list_array=igMisc::csv_explode("\n",$this->imageprofile->options, '"', true);
        
        foreach($list_array as $b)
		{
			$b=str_replace("\n",'',$b);
			$b=trim(str_replace("\r",'',$b));
			
            $listitem=igMisc::csv_explode(':', $b, '"', true);
         
            if(count($listitem)>1)
            {
                //$params=$this->csv_explode(',', $listitem[1], '"', false);
         
		 /*
                $new_params=array();
                foreach($params as $p)
                {
                    $this->ApplyURLQueryParameters($p);
					
					//Apply Content plugins
					
					//echo 'p='.$p.'<br/>
					//';
					/*
					$o = new stdClass();
					$o->text=$p;
					$dispatcher	= JDispatcher::getInstance();
					JPluginHelper::importPlugin('content');
					$r = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$o, &$params_, 0));
					$p=$o->text;
					
					if (ob_get_contents()) ob_end_clean();
					*/
					//echo 'p='.$p.'<br/>
					//';
					
					
                   // $new_params[]=$p;
                //}
				//*/
				/*
				$params=$listitem[1];
				
				$params=igMisc::parseOption($params);
				
		 
                
                $this->instructions[]=[$listitem[0],$params];//$new_params];
            }
        }
        
        
    }
    
	*/
	/*
	public function parseOption($option)
    {
		//$mainframe = JFactory::getApplication('site');
		//$params_ = $mainframe->getParams('com_content');
	   
        //$this->ApplyURLQueryParameters($option);
			
		/*	
		$o = new stdClass();
		$o->text=$option;
		$dispatcher	= JDispatcher::getInstance();
		JPluginHelper::importPlugin('content');
		$r = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$o, &$params_, 0));
		$option=$o->text;
					
		if (ob_get_contents()) ob_end_clean();
		*/
		
		//return $option;
        
    //}
    //*/
	
}
