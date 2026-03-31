<?php


function uploadImage($file_field) {
    if (!isset($_FILES[$file_field]) || $_FILES[$file_field]['error'] != UPLOAD_ERR_OK) {
        return null;
    }

    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileTmpPath = $_FILES[$file_field]['tmp_name'];
    $fileName = $_FILES[$file_field]['name'];
    
    
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
    
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'webp');
    
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadDir . $newFileName;
        
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            return 'uploads/' . $newFileName;
        }
    }
    
    return null;
}
?>
