<?php

class igMisc
{
    
    public static function hex2color_array($hex)
    {
                list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
                
                
                return [$r,$g,$b];
    }
    
    public static function hex2color($hex,&$image)
    {
                list($r, $g, $b) = sscanf($hex, "%02x%02x%02x");
                
                $color = imagecolorallocate($image, $r, $g, $b);
                return $color;
    }
    
    public static function Align2V($align)
    {
        $v='T';
        
        if(strpos($align,'top')!==false)
            $v='T';
        elseif(strpos($align,'middle')!==false)
            $v='M';
        elseif(strpos($align,'bottom')!==false)
            $v='B';
            
            
        return $v;
    }
    
    public static function Align2H($align)
    {
        $h='L';
        
        
        if(strpos($align,'left')!==false)
            $h='L';
        elseif(strpos($align,'center')!==false)
            $h='C';
        elseif(strpos($align,'right')!==false)
            $h='R';

        
            
        return $h;
    }
    
    public static function Align2Fitbox($align)
    {
        $h='L';
        $v='T';
        
        if(strpos($align,'left')!==false)
            $h='L';
        elseif(strpos($align,'center')!==false)
            $h='C';
        elseif(strpos($align,'right')!==false)
            $h='R';

        if(strpos($align,'top')!==false)
            $v='L';
        elseif(strpos($align,'middle')!==false)
            $v='C';
        elseif(strpos($align,'bottom')!==false)
            $v='R';
            
            
        return $h.$v;
    }
    
    public static function checkImageFile($paste_image_fileorurl,&$image_format)
    {
        
                        // image from file
                        if($paste_image_fileorurl[0]=='/')
                                $paste_image_fileorurl=substr($paste_image_fileorurl,1);
                        
                        if (!file_exists($paste_image_fileorurl))
                        {
                                echo 'The file '.$paste_image_fileorurl.' does not exist';
                                die;
                        }
                        
                        if(is_dir ($paste_image_fileorurl))
                        {
                                //echo 'Given path is a directory not file: "'.$paste_image_fileorurl.'".';
                                return;
                                die;
                        }
               
                        $condicion = GetImageSize($paste_image_fileorurl); // image format?

                        if(!isset($condicion[2]))
                        {
                                echo 'Cannot get image properties: "'.$paste_image_fileorurl.'".';
                                die;
                        }
                        
                        $image_format=$condicion[2];
                        
                        
                        if($image_format<0 or $image_format>3)
                        {
                                echo 'Unknown image format: "'.$paste_image_fileorurl.'".';
                                die;
                        }
        
        return $paste_image_fileorurl;
    }
    
    
    
    public static function getX(&$params,$scale,$i=0)
    {
        $x=0;
        if(isset($params[$i]))
                $x=floatval($params[$i])*$scale;
                
            return $x;
    }
    
    public static function getY(&$params,$scale,$i=1)
    {
        $y=0;
        if(isset($params[$i]))
                $y=(floatval($params[$i])*$scale);
                
            return $y;
    }
    
    public static function getW(&$params,$scale,$i=2)
    {
        
            $width=0;
            if(isset($params[$i]))
            {
                $w=floatval($params[$i]);
                if($w!=-1)
                    $width=($w*$scale);
            }
            
            return $width;
    }
    
     
    public static function getH(&$params,$scale,$i=3)
    {
            $height=-1;
            if(isset($params[$i]))
            {
                $h=floatval($params[$i]);
                
                if($h!=-1)
                    $height=($h*$scale);
            }
            
            return $height;
    }
        
    public static function getC(&$params,$scale,$i=4)
    {
        $color="FF0000";
        if(isset($params[$i]))
            $color=$params[$i];
                
        return $color;
    }

    
    public static function getImageExtention($ImageName_noExt)
    {
        $list=explode('.',$ImageName_noExt);
        if(count($list)<2)
            return '';
        
        $available_ext=array('gif','jpg','png','jpeg','pdf');
        
        $ext=$list[count($list)-1];
        
        if(in_array($ext,$available_ext))
           return $ext;
        
    	return '';	
    }
    
        public static function AlignX($x,$align,$scale_width,$base_image_width)
        {
                //$base_image_width=imagesx($this->image);
                
                
                $xpos=$x;
                if(strpos($align,'left')!==false)
                        $xpos=$x;
                elseif(strpos($align,'center')!==false)
                       $xpos=$base_image_width*0.5-$scale_width*0.5+$x; //center align
                elseif(strpos($align,'right')!==false)
                       $xpos=$base_image_width-$scale_width-$x;
                
                       
                return $xpos;
        }
        
        public static function AlignY($y,$align,$scale_height,$base_image_height)
        {
                
                //$base_image_height=imagesy($this->image);
                
                $ypos=$y;
                if(strpos($align,'top')!==false)
                        $ypos=$y;
                elseif(strpos($align,'middle')!==false)
                       $ypos=$base_image_height*0.5-$scale_height*0.5+$y;
                elseif(strpos($align,'bottom')!==false)
                       $ypos=$base_image_height-$scale_height-$y;
                
                       
                return $ypos;
        }
        
        
        public static function csv_explode($delim=',', $str, $enclose='"', $preserve=false)
        {
            $resArr = array();
            $n = 0;
            $expEncArr = explode($enclose, $str);
            foreach($expEncArr as $EncItem)
            {
            	if($n++%2){
            		array_push($resArr, array_pop($resArr) . ($preserve?$enclose:'') . $EncItem.($preserve?$enclose:''));
            	}else{
            		$expDelArr = explode($delim, $EncItem);
            		array_push($resArr, array_pop($resArr) . array_shift($expDelArr));
            	    $resArr = array_merge($resArr, $expDelArr);
            	}
            }
            return $resArr;
    	}
        
        public static function ApplyURLQueryParameters(&$str)
        {
		
        	$options=array();
        	$fList=igMisc::getListToReplace('url',$options,$str,'{}',':');
		
        	$i=0;
		
        	foreach($fList as $fItem)
        	{
        		$optpair=igMisc::csv_explode(',',$options[$i],'"',false);
			
        		$value= JRequest::getString($optpair[0],"");
			
        		$str=str_replace($fItem,$value,$str);
        		$i++;
        	}
        }
        
        
        public static function parseOption($option)
        {
            $mainframe = JFactory::getApplication('site');
            $params_ = $mainframe->getParams('com_content');
	   
            igMisc::ApplyURLQueryParameters($option);
				
            $o = new stdClass();
            $o->text=$option;
            $dispatcher	= JDispatcher::getInstance();
            JPluginHelper::importPlugin('content');
            $r = $dispatcher->trigger('onContentPrepare', array ('com_content.article', &$o, &$params_, 0));
            $option=$o->text;
            			
            if (ob_get_contents()) ob_end_clean();
		
            return $option;
        
        
        
        }
        
        
        public static function getListToReplace($par,&$options,&$text,$qtype,$separator=':')
	{
		$fList=array();
		$l=strlen($par)+2;
	
		$offset=0;
		do{
			if($offset>=strlen($text))
				break;
		
			$ps=strpos($text, $qtype[0].$par.$separator, $offset);
			if($ps===false)
				break;
		
		
			if($ps+$l>=strlen($text))
				break;
		
		$pe=strpos($text, $qtype[1], $ps+$l);
				
		if($pe===false)
			break;
		
		$notestr=substr($text,$ps,$pe-$ps+1);

			$options[]=trim(substr($text,$ps+$l,$pe-$ps-$l));
			$fList[]=$notestr;
			

		$offset=$ps+$l;
		
			
		}while(!($pe===false));
		
		//for these with no parameters
		$ps=strpos($text, $qtype[0].$par.$qtype[1]);
		if(!($ps===false))
		{
			$options[]='';
			$fList[]=$qtype[0].$par.$qtype[1];
		}
		
		return $fList;
	}
        
    
}

?>
