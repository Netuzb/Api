<?php

if(isset($_GET['text'])){

header("Content-type: image/jpeg");

//settings

$fontSize = 130;

$backgroundPath = "rasm.jpg";

$font = "shrift.ttf";

$text = $_GET['text'];

$padding = 10; //from edges

//create image

$im = imagecreatefromjpeg($backgroundPath);

$imageSize = getimagesize($backgroundPath);

$width = $imageSize[0];

$height = $imageSize[1];

//get textRows

$textRows = GetTextRowsFromText($fontSize, $font, $text, $width - ($padding * 2));

//colors

$colorWhite = imagecolorallocate($im, 255, 255, 255);

$colorBlack = imagecolorallocate($im, 255, 255, 255);

$colorGrey = imagecolorallocate($im, 255, 255, 255);

//border

//imagerectangle($im, 5, 2, $width - 1, $height - 1, $colorGrey);

for($i = 0; $i < count($textRows); $i++)

{

    //text size

    $line_box = imagettfbbox ($fontSize, 0, $font, $textRows[$i]);

    $text_width = GetTextWidth($fontSize, $font, $textRows[$i]); 

    $text_height = GetMaxTextHeight($fontSize, $font, $textRows) * 2;

    //align: center 

    $position_center = ceil(($width - $text_width) / 2);

    //valign: middle

    $test = (count($textRows) - $i) - ceil(count($textRows) / 3);

    $position_middle = ceil(($height - ($text_height * $test)) / 2);

    imagettfstroketext($im, $fontSize, 0, $position_center, $position_middle, $colorBlack, $colorGrey, $font, $textRows[$i], 2);

}

imagejpeg($im, "photo.jpg");

header ('location: photo.jpg');

}

function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {

    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)

        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)

            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);

}

function GetTextWidth($fontSize, $font, $text)

{

    $line_box = imagettfbbox ($fontSize, 0, $font, $text);

    return ceil($line_box[0]+$line_box[2]); 

}

function GetTextHeight($fontSize, $font, $text)

{

    $line_box = imagettfbbox ($fontSize, 0, $font, $text);

    return ceil($line_box[1]-$line_box[7]); 

}

function GetMaxTextHeight($fontSize, $font, $textArray)

{

    $maxHeight = 0;

    for($i = 0; $i < count($textArray); $i++)

    {       

        $height = GetTextHeight($fontSize, $font, $textArray[$i]);

        if($height > $maxHeight)

            $maxHeight = $height;

    }

    return $maxHeight;

}

function GetTextRowsFromText($fontSize, $font, $text, $maxWidth)

{   

    $text = str_replace("\n", "\n ", $text);

$text = str_replace("\\n", "\n ", $text);

    $words = explode(" ", $text);

    $rows = array();

    $tmpRow = "";

    for($i = 0; $i < count($words); $i++)

    {

        //last word

        if($i == count($words) -1)

        {

            $rows[] = $tmpRow.$words[$i];

            break;;

        }

        if(GetTextWidth($fontSize, $font, $tmpRow.$words[$i]) > $maxWidth) //break

        {

            $rows[] = $tmpRow;

            $tmpRow = "";

        }

        else if(StringEndsWith($tmpRow, "\n ")) //break in text

        {

            $tmpRow = str_replace("\n ", "", $tmpRow);

            $rows[] = $tmpRow;

            $tmpRow = "";

        }

        //add new word to row   

        $tmpRow .= $words[$i]." ";

    }

    return $rows;

}

function StringEndsWith($haystack, $needle)

{

    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;

}

?>
