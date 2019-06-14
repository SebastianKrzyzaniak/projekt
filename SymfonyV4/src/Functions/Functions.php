<?php

namespace App\Functions;

class Functions
{
    public static function ChangeImageSize(string $src_image_path, int $dst_width, int $dst_height)
    {
        $src_image = Functions::CreateImage($src_image_path);

        if($src_image == 0)
        {
            return null;   //podano nieobsłużony format
        }

        $x = imagesx($src_image);
        $y = imagesy($src_image);

        $tmp_x = 0;
        $tmp_y = 0;

        // skalowanie
        if($y<$x) $tmp_x = ceil(($x-$dst_width*$y/$dst_height)/2);
        elseif($x<$y) $tmp_y = ceil(($y-$dst_height*$x/$dst_width)/2);
            
        $dst_image = imagecreatetruecolor($dst_width, $dst_height); 
        imagecopyresampled($dst_image, $src_image, 0, 0, $tmp_x, $tmp_y, $dst_width, $dst_height, $x-2*$tmp_x, $y-2*$tmp_y);
        
        imagejpeg($dst_image, Functions::$path, 100);
        imagedestroy($dst_image); 
        unlink($src_image_path);    //usuwa (stary)plik, z którego stwrzylismy nowy, sformatowany

        return Functions::$path;
    }

    private static $path;

    private static function CreateImage ($originalImage)
    {
        // jpg, png, gif or bmp
        $exploded = explode('.',$originalImage);
        Functions::$path = $exploded[0].".jpeg";
        $ext = $exploded[count($exploded) - 1]; 

        if (preg_match('/jpg|jpeg/i',$ext))
            $imageConverted=imagecreatefromjpeg($originalImage);
        else if (preg_match('/png/i',$ext))
            $imageConverted=imagecreatefrompng($originalImage);
        else if (preg_match('/gif/i',$ext))
            $imageConverted=imagecreatefromgif($originalImage);
        else if (preg_match('/bmp/i',$ext))
            $imageConverted=imagecreatefrombmp($originalImage);
        else
            return null;

        return $imageConverted;
    }
}