<?php

require_once(JPATH_SITE.DS.'components'.DS.'com_imagegenerator'.DS.'includes'.DS.'misc.php');


class ImageGenerator
{
        public $image;
        public $filename;
        public $fileformat;
        public $fileformatparam;
        public $defaultfontfile;
        public $x_offset;
        public $y_offset;
        
        public function setOffset($x_offset=0,$y_offset=0)
        {
                $this->x_offset=$x_offset;
                $this->y_offset=$y_offset;
        }
        
        public function createImage($width,$height,$color_hex)
        {
                //echo '$width='.$width;
                //echo '$height='.$height;
                //echo '$color_hex='.$color_hex;
                
                $this->image = imagecreatetruecolor($width, $height); //there will be opened background image
                $color=igMisc::hex2color($color_hex,$this->image);
                
                imagefill($this->image, 0, 0, $color);
        }
        
        
        
        public function printText($text,$fontfile,$fontsize,$margin_x,$margin_y,$line_height=0,$color_hex,$align="centermiddle")
        {
                if($fontfile=='')
                        $fontfile=$this->defaultfontfile;
                
                $color=igMisc::hex2color($color_hex,$this->image);
                
                if($line_height==0)
                        $line_height=$fontsize+3;
                
                $box_width=imagesx($this->image);
                
                if(strpos($align,'center')!==false)
                        $lines=$this->superWordwrap($fontsize,$fontfile,$text,$box_width-$margin_x*2);
                else
                        $lines=$this->superWordwrap($fontsize,$fontfile,$text,$box_width);

    
    
                $box_height=count($lines)*$line_height;
                $y=$this->AlignY($margin_y,$align,$box_height);

                $y+=$line_height;

                foreach($lines as $line)
                {
                        $box = @ImageTTFBBox($fontsize,0,$fontfile,$line);
                        $text_width=abs($box[2]-$box[0]);
                        
                        if(strpos($align,'center')!==false)
                                $x=$this->AlignX(0,$align,$text_width);
                        else
                                $x=$this->AlignX($margin_x,$align,$text_width);
                        
                        //echo '$this->x_offset='.$this->x_offset.'<br/>';
                        imagettftext($this->image, $fontsize, 0,$x+$this->x_offset, $y+$this->y_offset, $color, $fontfile, $line); // "+2" - height of space-line
                        $y+=$line_height;
                }
        }

        protected function centerAlignX($fontsize,$fontfile,$text,$box_width)
        {
                $box = @ImageTTFBBox($fontsize,0,$fontfile,$text);
                $width=abs($box[2]-$box[0]);
            
                $x=floor($box_width*0.5-$width*0.5);
    
                return $x;
        }



        
        function superWordwrap($fontsize,$fontfile,$text,$box_width)
        {
                $width=0;
                $lines=array();
    
                $str='';
                $words=array();
    
                $box = @ImageTTFBBox($fontsize,0,$fontfile,' ') ;
                $space_width=abs($box[2]-$box[0]);
    
                $text_array=explode(' ',$text);
                foreach($text_array as $t)
                {
                        $box = @ImageTTFBBox($fontsize,0,$fontfile,$t) ;
                        $w = abs($box[2]-$box[0]);
                        $h = abs($box[5]-$box[3]);
        
                        if($width>0)
                                $width+=$space_width;
        
                        $width+=$w;
        
        
                        if($width<$box_width)
                        {
                                $words[]=$t;
                        }
                        else
                        {
                                if(count($words)>0)
                                        $lines[]=implode(' ',$words);
                
                
                                $words=array();
                                $words[]=$t;
                                $width=$w;
                        }
        
                }       
    
                if(count($words)>0)
                        $lines[]=implode(' ',$words);
    
                return $lines;    
        }
        
        
        
        
        public function placeImage($paste_image_fileorurl,$x,$y,$new_width,$new_height,$align="left")
        {
                if($paste_image_fileorurl=='')
                        return; //don't do anything if no image
                
                if(strpos($paste_image_fileorurl,'http:')!==false or strpos($paste_image_fileorurl,'https:')!==false)
                {
                        //image from url
                        $imagedata=file_get_contents($paste_image_fileorurl);
                        if(strpos($imagedata,'JFIF')!==false or strpos($imagedata,'PNG')!==false  or strpos($imagedata,'GIF')!==false)
                        {
                                $image = imagecreatefromstring($imagedata);
                                $this->placeImageResource($image,$x,$y,$new_width,$new_height,$align);
                        }
                        else
                        {
                                echo 'Recourse '.$paste_image_fileorurl.' cannot be loaded.';
                                die;
                        }
                }
                else
                {
                        $image_format=0;
                        $paste_image_fileorurl=igMisc::checkImageFile($paste_image_fileorurl,$image_format);
                        if($paste_image_fileorurl=='')
                        {
                                //echo 'Image corrupted: "'.$paste_image_fileorurl.'"';
                                //die;
                                return;
                        }
                        
                        
                        $paste_image_resource=null;
                        
                        if($image_format == 1) //gif
                                $paste_image_resource = imagecreatefromgif($paste_image_fileorurl);
                        if($image_format == 2) //jpg
                                $paste_image_resource = imagecreatefromjpeg($paste_image_fileorurl);
                        if($image_format == 3) //png
                                $paste_image_resource = imagecreatefrompng($paste_image_fileorurl);
                        
                        if($paste_image_resource === null)
                        {
                                echo 'Cannot load image: "'.$paste_image_fileorurl.'".';
                                die;
                        }
                        
                        $this->placeImageResource($paste_image_resource,$x+$this->x_offset,$y+$this->y_offset,$new_width,$new_height,$align);
                }
        }
        
        protected function placeImageResource($paste_image,$x,$y,$new_width,$new_height,$align="left")
        {
                


                $paste_width=imagesx($paste_image);
                $paste_height=imagesy($paste_image);//no changes - as source image

                //echo '$new_width='.$new_width.'<br/>';
                //echo '$new_height='.$new_height.'<br/>';
                        
                if($new_width==0)
                        $new_width=$paste_width;
                        
                if($new_height==0)
                        $new_height=$paste_height;
                        
                if($new_height==-1)
                {
                        if($new_width==0)
                        {
                                echo 'New Image width is 0;';
                                die;
                        }
                        
                        if($paste_width==0)
                        {
                                echo 'Paste Image width is 0;';
                                die;
                        }
                        
                        $new_height=floor($paste_height/($paste_width/$new_width));

                }
                //echo '$new_width='.$new_width.'<br/>';
                //echo '$new_height='.$new_height.'<br/>';
                
                //$paste_image2=imagescale ($paste_image,$new_width,$new_height, IMG_BILINEAR_FIXED);//);//,IMG_NEAREST_NEIGHBOUR);//, IMG_BILINEAR_FIXED);
                //imagedestroy($paste_image);

                $base_image_width=imagesx($this->image);
                $base_image_height=imagesy($this->image);
        
                //$scale_width=$new_width;//imagesx($paste_image2);

                //$scale_height=$new_height;//imagesy($paste_image2);//no changes - as source image
      
                $xpos=$this->AlignX($x,$align,$new_width);
                $ypos=$this->AlignY($y,$align,$new_height);
                
                //imagecopy($this->image, $paste_image2,$xpos , $ypos, 0, 0, $scale_width, $scale_height);
                
                imagecopyresampled($this->image,$paste_image, $xpos, $ypos, 0, 0, $new_width, $new_height, $paste_width, $paste_height);
      //$this->image = $new_image;
                imagedestroy($paste_image);

        }

        protected function AlignX($x,$align,$scale_width)
        {
                $base_image_width=imagesx($this->image);
                return igMisc::AlignX($x,$align,$scale_width,$base_image_width);
        }
        
        protected function AlignY($x,$align,$scale_height)
        {
                $base_image_height=imagesy($this->image);
                return igMisc::AlignY($x,$align,$scale_height,$base_image_height);
        }
        
        
        public function outputImage()
        {
                $ext=igMisc::getImageExtention($this->filename);
	
		if($ext!='')
                {
                        if($fileformat<1 or $fileformat>3)
                        {
                                echo 'ensuported format ('.$fileformat.')';
                                die;
                        }
                        
                        $available_ext=array('','gif','jpg','png');
                        
			$filename=$this->filename.'.'.$available_ext[$fileformat];
                }
		else
			$filename=$this->filename;
                
                
                header('Content-type: image/png');
                header('Content-Disposition: inline; filename="' . $filename . '"');
                
                if($this->fileformat==1 or $this->fileformat=='gif')
                        imagegif($this->image,null);
                if($this->fileformat==2 or $this->fileformat=='jpg')
                        imagejpeg($this->image,null,$this->fileformatparam);
                if($this->fileformat==3 or $this->fileformat=='png')
                        imagepng($this->image,null);
                
                imagedestroy($this->image);
        }
}
