<?php
/*Create a random string based on length given*/
function strRand($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Checks if the variable is an actual number, can be in char format ("6") or numerical format (6)
function isValidNumber($num) {
    return (is_numeric($num) || ctype_digit($num));
}

function checkIfSetArray($data, $keys) {
    $missingKeys = [];
    
    for ($i = 0; $i < count($keys); $i++) {
        if (!isset($data[$keys[$i]])) $missingKeys[] = $keys[$i];
    }
    
    return $missingKeys;
}

/*
    $file - the file as post
    $details {
        type - file type - image, document, zip, video
        compress - compress the file, if an image
        location - the save location
    }
*/
function uploadFile($file, $details) {
    switch ($details["type"]) {
        case 'image':
            if (!in_array(exif_imagetype($file), [IMAGETYPE_GIF,IMAGETYPE_JPEG,IMAGETYPE_PNG])) return false;
            break;
        case 'document':
            
            break;
        case 'zip':
            
            break;
        case 'video':
            
            break;
        default: return false;
    }
}

function compressImage($image) {
    
}
?>