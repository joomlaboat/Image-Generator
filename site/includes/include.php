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

class IG
{
    var $scale;
    var $imageprofile;
    var $filename;
    var $fileformat;
    var $fileformatparam;
    var $width;
    var $height;
    var $background;
    var $instructions;
    var $x_offset;
    var $y_offset;
    
    function __construct()
    {
        $this->scale=JRequest::getFloat( 'scale',1 );
        if($this->scale<0.1)
            $this->scale=1;
    
        if($this->scale>50)
            $this->scale=50;
            
        $this->instructions=array();
        
        $this->x_offset=0;
        $this->y_offset=0;
    }
    
    function setImageGeneratorProfile(&$imageprofile)
    {
        $this->profilename=igMisc::parseOption($imageprofile->profilename);
        
        $this->filename=igMisc::parseOption($imageprofile->outputfilename);

        $this->fileformat=igMisc::parseOption($imageprofile->fileformat);
        $this->fileformatparam=igMisc::parseOption($imageprofile->fileformatparam);
        $this->width=floor(igMisc::parseOption($imageprofile->width)*$this->scale);
        $this->height=floor(igMisc::parseOption($imageprofile->height)*$this->scale);

        $this->background=igMisc::parseOption($imageprofile->background);
    }
    
    function setImageGeneratorProfileFromText($text)
    {
        $list_array=igMisc::csv_explode("\n",$text, '"', true);
        
        foreach($list_array as $b)
		{
			$b=str_replace("\n",'',$b);
			$b=trim(str_replace("\r",'',$b));
			
            
            $listitem=igMisc::csv_explode(':', $b, '"', true);
         
            if(count($listitem)>1)
            {
               	$params=$listitem[1];
				
                if($content_plugin)
                    $params=igMisc::parseOption($params);
				
                $item=$listitem[0];
                
                switch($item)
                {
            
                    case 'profilename':
                        $this->profilename=$params;
                    break;
                
                    case 'filename':
                        $this->filename=$params;
                    break;
                
                    case 'fileformat':
                        $this->fileformat=$params;
                    break;
                
                    case 'fileformatparam':
                        $this->fileformatparam=$params;
                    break;
                
                    case 'width':
                        $this->width=$params;
                    break;
                    
                    case 'height':
                        $this->height=$params;
                    break;
                
                    case 'background':
                        $this->background=$params;
                    break;
                
                }

            }
        }
    }
    
    function setInstructions($text,$content_plugin=true)
    {
        $this->instructions=array();
        
        $list_array=igMisc::csv_explode("\n",$text, '"', true);
        
        foreach($list_array as $b)
		{
			$b=str_replace("\n",'',$b);
			$b=trim(str_replace("\r",'',$b));
			
            $listitem=igMisc::csv_explode(':', $b, '"', true);
         
            if(count($listitem)>1)
            {
               	$params=$listitem[1];
				
                if($content_plugin)
                    $params=igMisc::parseOption($params);
				                
                $this->instructions[]=[$listitem[0],$params];//$new_params];
            }
        }
        
    }
    
    function render($outputfile=true,&$obj,$x_offset=0,$y_offset=0)
    {
        $this->x_offset=$x_offset*$this->scale;
        $this->y_offset=$y_offset*$this->scale;
        
        
        if($this->fileformat==100 or $this->fileformat=='pdf')
		{
			if($obj!==null)
				$obj->setDocumentSize($this->width,$this->height);
			
            return $this->renderPDF($outputfile,$obj);
		}
        else
            return $this->renderImage($outputfile,$obj);
    }
    
    function renderPDF($outputfile=true,$pdf)
    {
        //require_once(JPATH_SITE.DS.'components'.DS.'com_imagegenerator'.DS.'includes'.DS.'pdfgenerator.php');
        
        
        if($pdf===null)
        {
            require_once('pdfgenerator.php');
            
            $pdf=new PDFGenerator;
            $pdf->filename=$this->filename;
            $pdf->document_title=$this->profilename;
            $pdf->params=(int)$this->fileformatparam;//dpi

            $pdf->createDocument($this->width,$this->height,$this->background);
        }
        
        $pdf->setOffset($this->x_offset,$this->y_offset);
        
        //Add content
        foreach($this->instructions as $instruction)
        {
            $inst=$instruction[0];
        
            $params=igMisc::csv_explode(',', $instruction[1], '"', false);
        
            switch($inst)
            {
            
                case 'qr':
                    $this->instructionQR($pdf,$instruction,$params);
                    break;
            
                case 'svg':
                    $this->instructionSvg($pdf,$instruction,$params);
                    break;
            
                case 'rect':
                    $this->instructionRect($pdf,$instruction,$params);
                    break;

                case 'img':
                    $this->instructionImage($pdf,$instruction,$params);
                break;
            
                case 'txt':
                    $this->instructionText($pdf,$instruction,$params);
                break;
            }    
        }
   
        if($outputfile)
            $pdf->outputDocument();
            
        return $pdf;
    }
    
    function renderImage($outputfile=true,$ig)
    {
        //require_once(JPATH_SITE.DS.'components'.DS.'com_imagegenerator'.DS.'includes'.DS.'imagegenerator.php');
        if($ig===null)
        {
            require_once('imagegenerator.php');
    
    
            $ig=new ImageGenerator;
            $ig->filename=$this->filename;
            $ig->fileformat=$this->fileformat;
            $ig->fileformatparam=$this->fileformatparam;
    
            $ig->defaultfontfile='components/com_imagegenerator/fonts/expresswa_rg.ttf';
            $ig->createImage($this->width*$this->scale,$this->height*$this->scale,$this->background);
        }
        //echo 'g='.$this->x_offset.'<br/>';
        $ig->setOffset($this->x_offset,$this->y_offset);

        
        foreach($this->instructions as $instruction)
        {
            $inst=$instruction[0];
        
            $params=igMisc::csv_explode(',', $instruction[1], '"', false);
        
        
        
            switch($inst)
            {
                case 'img':
                    $this->instructionImage($ig,$instruction,$params);
                break;
            
                case 'txt':
                    $this->instructionText($ig,$instruction,$params);
                break;
            }   
        }
    
        
            
        if($outputfile)
        {
            
            
            $ig->outputImage();
        }
        
        return $ig;
    }
    
    function instructionQR(&$obj,&$instruction,$params)
    {
    
        $code=$params[0];
    
        $x=igMisc::getX($params,$this->scale,1);
        $y=igMisc::getY($params,$this->scale,2);
        $width=igMisc::getW($params,$this->scale,3);
        $height=igMisc::getH($params,$this->scale,4);
    
    
        $align="";
        if(isset($params[5]))
            $align=$params[5];
        
        $obj->placeQRCode($code,$x,$y,$width,$height,$align);
    }
    

    function instructionSVG(&$obj,&$instruction,$params)
    {
        //$params=$instruction[1];
    
        $paste_svg_file=$params[0];
    
        $x=igMisc::getX($params,$this->scale,1);
        $y=igMisc::getY($params,$this->scale,2);
        $width=igMisc::getW($params,$this->scale,3);
        $height=igMisc::getH($params,$this->scale,4);
    
    
        $align="";
        if(isset($params[5]))
            $align=$params[5];
            
        $obj->placeSVG($paste_svg_file,$x,$y,$width,$height,$align);
    }

    function instructionRect(&$obj,&$instruction,$params)
    {
            //$params=$instruction[1];
    
            $x=igMisc::getX($params,$this->scale,0);
            $y=igMisc::getY($params,$this->scale,1);
            $width=igMisc::getW($params,$this->scale,2);
            $height=igMisc::getH($params,$this->scale,3);
            $color=igMisc::getC($params,$this->scale,4);
       
            $obj->placeRectangle($x,$y,$width,$height,$color);
    }

    function instructionText(&$obj,&$instruction,$params)
    {

        
            $fontname="";
            if(isset($params[1]))
                $fontname=$params[1];
            
            $fontsize=15;
            if(isset($params[2]))
                $fontsize=($params[2])*$this->scale;
            
            $x=igMisc::getX($params,$this->scale,3);
            $y=igMisc::getY($params,$this->scale,4);
            $color=igMisc::getC($params,$this->scale,6);
            
            $lineheight=0;
            if(isset($params[5]))
                $lineheight=(intval($params[5])*$this->scale);
                
            $align="";
            if(isset($params[7]))
                $align=$params[7];
        
        
            $obj->printText($params[0],$fontname,$fontsize,$x,$y,$lineheight,$color,$align);
    }

    function instructionImage(&$obj,&$instruction,$params)
    {
            //$params=$instruction[1];
            
            //print_r($params);
        
            $x=0;
            if(isset($params[1]))
                $x=floor(intval($params[1])*$this->scale);
            
            $y=0;
            if(isset($params[2]))
                $y=floor(intval($params[2])*$this->scale);
            
            $width=0;
            if(isset($params[3]))
            {
                $w=intval($params[3]);
                
                if($w!=-1)
                    $width=floor($w*$this->scale);
                    
                
            }   
        
            
            $height=-1;
            if(isset($params[4]))
            {
                $h=intval($params[4]);
                
                if($h!=-1)
                    $height=floor($h*$this->scale);
            }
            
            
            $align="left";
            if(isset($params[5]))
                $align=$params[5];
        
            $obj->placeImage($params[0],$x,$y,$width,$height,$align);
    }


}
?>