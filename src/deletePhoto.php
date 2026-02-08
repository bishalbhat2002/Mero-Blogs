<?php


function deletePhoto($dbPath) {

    if (empty($dbPath)) return false;

//     convert the path to an absolute path 
    $cleanPath = realpath(__DIR__ . '/' . $dbPath);

// check if the path is valid and is within the uploads directory to prevent directory traversal attacks
    if (!$cleanPath) return false;


    if (!str_contains($cleanPath, DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR)) {
        return false;
    }

//     delete the file if it exists and return the result
    return file_exists($cleanPath) ? unlink($cleanPath) : false;
}


?>