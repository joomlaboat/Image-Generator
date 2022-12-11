<?php

//require_once(JPATH_SITE.DS.'components'.DS.'com_imagegenerator'.DS.'includes'.DS.'TCPDF-master'.DS.'examples'.DS.'tcpdf_include.php');
require_once(JPATH_SITE . DS . 'libraries' . DS . 'tcpdf' . DS . 'tcpdf.php');
require_once(JPATH_SITE . DS . 'components' . DS . 'com_imagegenerator' . DS . 'includes' . DS . 'misc.php');

class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        //$this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        //$this->SetY(-15);
        // Set font
        //$this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

class PDFGenerator
{
    public $pdf;
    public $filename;
    public $params;
    public $document_title;

    public $document_width;
    public $document_height;

    public $dpi;
    public $dpmm;
    public $points;

    public $x_offset;
    public $y_offset;

    public function setOffset($x_offset = 0, $y_offset = 0)
    {
        $this->x_offset = $x_offset;
        $this->y_offset = $y_offset;
    }

    public function setDocumentSize($width, $height)
    {
        $this->document_width = $width;//+100;
        $this->document_height = $height;//;//+100;

    }

    public function createDocument($width, $height, $color_hex)
    {


        //header('Content-type: text/plain; charset=utf-8');


        $custom_layout = array($width, $height);

        //$this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', $custom_layout, true, 'UTF-8', false);
        $orientation = PDF_PAGE_ORIENTATION;
        if ($width > $height)
            $orientation = 'L';
        else
            $orientation = 'P';

        //echo $orientation;
        //die;

        //$pageLayout = array($width, $height); //  or array($height, $width)
        //$pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
        $this->pdf = new MYPDF($orientation, 'mm', $custom_layout, true, 'UTF-8', false);
        //$this->pdf = new MYPDF($orientation, 'mm', $custom_layout, true, 'UTF-8', false);

        //$this->pdf->addFormat("custom", $width, $height);
        //$this->pdf->reFormat("custom", $orientation);

        // set document information
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('Image Generator');
        $this->pdf->SetTitle($this->document_title);
        $this->pdf->SetSubject($this->document_title);
        $this->pdf->SetKeywords($this->document_title);

        if ((int)$this->params < 1)
            $this->dpi = 72;
        else
            $this->dpi = (int)$this->params;

        $this->document_width = $width;//+100;
        $this->document_height = $height;//+100;


        $this->pdf->SetHeaderMargin(0);
        $this->pdf->SetFooterMargin(0);
        $this->pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);


        $this->dpmm = $this->dpi / 25.4; // inch -> mm


        // add a page
        $this->pdf->SetMargins(0, 0, 0, 0); // set the margins
        $this->pdf->AddPage($orientation);//, '', false, false);

        // set JPEG quality
        $this->pdf->setJPEGQuality(75);

        $this->points = 1 * 72 / $this->dpi;

    }


    public function placeQRCode($code, $x, $y, $new_width, $new_height, $align = "left")
    {
        $h = igMisc::Align2H($align);
        $v = igMisc::Align2V($align);

        if ($h == 'C')
            $x = $this->document_width * 0.5 - $new_width * 0.5;
        elseif ($h == 'R')
            $x = $this->document_width - $new_width - $x;


        if ($v == 'M')
            $y = $this->document_height * 0.5 - $new_height * 0.5;
        elseif ($v == 'B')
            $y = $this->document_height - $new_height - $y;


        // new style
        $style = array(
            'border' => false,
            'padding' => 0,
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,


        );

        ///'vpadding' => 'auto',
        //'hpadding' => 'auto'
        //'module_width' => 0, // width of a single module in points
        //'module_height' => 0 // height of a single module in points

        $this->pdf->write2DBarcode($code, 'QRCODE,H', $x + $this->x_offset, $y + $this->y_offset, $new_width, $new_height, $style, 'N');
    }

    public function placeSVG($paste_svg_file, $x, $y, $new_width, $new_height, $align = "left")
    {

        $h = igMisc::Align2H($align);
        $v = igMisc::Align2V($align);

        if ($h == 'C')
            $x = $this->document_width * 0.5 - $new_width * 0.5;
        elseif ($h == 'R')
            $x = $this->document_width - $new_width - $x;


        if ($v == 'M')
            $y = $this->document_height * 0.5 - $new_height * 0.5;
        elseif ($v == 'B')
            $y = $this->document_height - $new_height - $y;

        $this->pdf->ImageSVG($paste_svg_file, $x + $this->x_offset, $y + $this->y_offset, $new_width, $new_height, '', '', '', 0, false);
    }

    public function placeRectangle($x, $y, $w, $h, $color_hex)
    {
        $style4 = array('L' => 0,
            'T' => 0,
            'R' => 0,
            'B' => 0);
        /*
        $style4 = array('L' => 0,
                'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
                'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
                'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
         */

        $color = igMisc::hex2color_array($color_hex);
        //print_r($color);
        //die;
        $this->pdf->Rect($x + $this->x_offset, $y + $this->y_offset, $w, $h, 'DF', $style4, $color);
    }

    public function printText($text, $family, $fontsize, $margin_x, $margin_y, int $line_height, $color_hex, $align = "centermiddle")
    {
        //$line_height=0

        if (strpos($color_hex, ',') !== false) {
            //CMYK

            $color = explode(',', $color_hex);
            //$cmd=
            $this->pdf->setColor('text', $color[0], $color[1], $color[2], $color[3], true, '');
            //echo '$cmd='.$cmd.'';
            //die;
        } else {
            //RGB
            $color = igMisc::hex2color_array($color_hex);
            $this->pdf->SetTextColorArray($color);
        }

        $font_size = $fontsize * $this->points * 4;


        if ($family == '')
            $family = 'helvetica';

        $this->pdf->SetFont($family, '', $font_size);//;//, '', 'default', true);
        //SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), AddLink(), Ln(), MultiCell(), Write(), SetAutoPageBreak()


        $top = 0;

        $v = igMisc::Align2V($align);

        if ($v == 'T') {
            $top = 0;
            $this->pdf->SetY($margin_y + $this->y_offset, true);
        }
        if ($v == 'B') {
            $top = 0;
            $this->pdf->SetY($this->document_height - $margin_y - $line_height + $this->y_offset, true);

        }

        $keepmargins = true;


        $h = igMisc::Align2H($align);


        if ($h == 'L') {
            $left = $margin_x;
            $right = -1;
            $this->pdf->SetX($margin_x + $this->x_offset, true);
            $this->pdf->SetMargins($left, $top, $right, $keepmargins);
        } elseif ($h == 'C') {
            $this->pdf->SetX(floor($margin_x + $this->x_offset), true);
            $left = $margin_x;
            $right = $margin_x;
            $this->pdf->SetMargins($left, $top, $right, $keepmargins);
        } elseif ($h == 'R') {
            $left = -1;
            $right = $margin_x;
            $this->pdf->SetX(0 + $this->x_offset, true);
            $this->pdf->SetMargins($left, $top, $right, $keepmargins);
        }


        //$this->pdf->SetX($margin_x, true);


        //$this->points
        //Align2A($align)
        $firstline = false;
        $margin = '';


        //echo $text;
        //die;

        $remaining_string = $this->pdf->Write($line_height, $text, '', false, $h, false, 0, $firstline, false, 0, 0, $margin);

    }


    public function placeImage($paste_image_fileorurl, $x, $y, $new_width, $new_height, $align = "left")
    {
        //echo '.new_width='.$new_width.'<br/>';
        //echo '.new_height='.$new_height.'<br/>';

        if ($paste_image_fileorurl == '')
            return; //don't do anything if no image

        if (strpos($paste_image_fileorurl, 'http:') !== false or strpos($paste_image_fileorurl, 'https:') !== false) {
            //image from url
            try {
                $imagedata = @file_get_contents($paste_image_fileorurl);
            } catch (Exception $e) {
                return;
            }

            $ext = '';
            if (strpos($imagedata, 'Exif') !== false)
                $ext = 'jpg';
            elseif (strpos($imagedata, 'JFIF') !== false)
                $ext = 'jpg';
            elseif (strpos($imagedata, 'PNG') !== false)
                $ext = 'png';
            elseif (strpos($imagedata, 'GIF') !== false)
                $ext = 'gif';

            if ($ext != '') {
                $image = imagecreatefromstring($imagedata);
                $paste_width = imagesx($image);
                $paste_height = imagesy($image);
                $this->placeImageResource('@' . $imagedata, $x, $y, $new_width, $new_height, $align, $ext, $paste_width, $paste_height);
                imagedestroy($image);
            } else {
                return;
                echo 'Recourse [332] ' . $paste_image_fileorurl . ' cannot be loaded.';
                die;
            }

        } else {
            $image_format = 0;
            $paste_image_fileorurl = igMisc::checkImageFile($paste_image_fileorurl, $image_format);

            if ($paste_image_fileorurl == '') {
                //no image. path is empty
                //do nothing
                return;

            }


            if ($paste_image_fileorurl == '') {
                echo 'corrupted image: "' . $paste_image_fileorurl . '"';
                die;

            }


            $ext = igMisc::getImageExtention($paste_image_fileorurl);
            if ($ext == '') {
                echo 'unsupported format: "' . $paste_image_fileorurl . '"';
                die;
            }

            //echo 'new_width='.$new_width.'<br/>';
            //echo 'new_height='.$new_height.'<br/>';
            //echo $ext;
            //die;
            list($paste_width, $paste_height, $type, $attr) = getImageSize($paste_image_fileorurl);

            $this->placeImageResource($paste_image_fileorurl, $x, $y, $new_width, $new_height, $align, $ext, $paste_width, $paste_height);
        }
    }

    public function outputDocument()
    {


        $ext = igMisc::getImageExtention($this->filename);

        if ($ext != 'pdf')
            $filename = $this->filename . '.pdf';
        else
            $filename = $this->filename;

        $this->pdf->Output($filename, 'I');
    }

    protected function placeImageResource($paste_image_file, $x, $y, $new_width, $new_height, string $align, $ext, $paste_width, $paste_height)
    {
        //$align="left"

        if ($new_width == 0)
            $new_width = $paste_width / $this->dpmm;

        if ($new_height == 0)
            $new_height = $paste_height / $this->dpmm;

        if ($new_height == -1) {
            if ($new_width == 0) {
                echo 'New Image width is 0;';
                die;
            }

            if ($paste_width == 0) {
                echo 'Paste Image width is 0;';
                die;
            }

            $new_height = floor($paste_height / ($paste_width / $new_width));

        }


        $xpos = igMisc::AlignX($x, $align, $new_width, $this->document_width);
        $ypos = igMisc::AlignY($y, $align, $new_height, $this->document_height);

        $fitbox = igMisc::Align2Fitbox($align);

        // Image example with resizing
        $ext = strtoupper($ext);


        $this->pdf->Image($paste_image_file, $xpos + $this->x_offset, $ypos + $this->y_offset, $new_width, $new_height, $ext, '', '', false, 300, '', false, false, 0, $fitbox, false, false);


    }

}


?>