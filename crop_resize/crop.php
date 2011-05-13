<?php
    // SETTINGS
    $image_name = 'night.jpg';    // Full path and image name with extension
    $thumb_name = 'thumbnail';   // Generated thumbnail name without extension
    $thumb_side = 100;           // Desired thumbnail side size
    $save_to_file = false;       // If you want to save result to file set this option to `true`
    // END OF SETTINGS
    
    $image_extension = explode('.', $image_name); // I assume that images are named only following 'imagename.ext' pattern
    
    if (preg_match('/jpg|jpeg/', $image_extension[1])) {
        $src_image = imagecreatefromjpeg($image_name);
        $image_extension = 'jpg';
    } else if (preg_match('/png/', $image_extension[1])) {
        $src_image = imagecreatefrompng($image_name);
        $image_extension = 'png';
    }
    
    $src_width = imageSX($src_image);   // Width of the original image
    $src_height = imageSY($src_image);  // Height of the original image
    
    $min_side = min($src_width, $src_height);
    
    /*********** If you need this part uncomment it
    $ratio = $min_side / $thumb_width;
    $new_width = floor($src_width / $ratio);
    $new_height = floor($src_height / $ratio);
    **********************************************/    
    
    $dst_image = imagecreatetruecolor($thumb_side, $thumb_side);
        
    imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $thumb_side, $thumb_side, $min_side, $min_side);
    
    switch ($image_extension)
    {
        case 'jpg':
            if ($save_to_file) {
                imagejpeg($dst_image, $thumb_name . '.jpg', 100);
            } else {
                header('Content-Type: image/jpeg');
                imagejpeg($dst_image, NULL, 100);
            }
            break;
        case 'png':
            if ($save_to_file) {
                imagepng($dst_image, $thumb_name . '.png', 100);
            } else {
                header('Content-Type: image/png');
                imagepng($dst_image, NULL, 100);
            }
            break;
    }
    
    imagedestroy($src_image);
    imagedestroy($dst_image);
?>
