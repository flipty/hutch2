<?php
    // Fetch the file info.
	$upload_dir = wp_upload_dir();
    $filePath = get_field('file_upload', get_the_ID());

    $password_status = get_field('password_protected', get_the_ID());

    if ( $password_status == 1 ) {
        die('This file is password protected and unavailable for direct download.');
    }

	$filePath = $upload_dir['basedir'] . '/' . substr($filePath, strpos($filePath, 'uploads'));
	$filePath = str_replace('/uploads/uploads/', '/uploads/', $filePath);
    $path_parts = pathinfo($filePath);

    if( file_exists($filePath) ) {
        $fileName = basename($filePath);
        $fileSize = filesize($filePath);

        // Output headers.
        header("Cache-Control: private");
        header("Content-Length: ".$fileSize);
        if ( $path_parts['extension'] == 'pdf' ) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=".$fileName);
        } else {
            header("Content-Type: application/stream");
            header("Content-Disposition: attachment; filename=".$fileName);
        }
        
        //Output file.
        readfile ($filePath);               
        exit();
    } else {
        die('The provided file path is not valid.');
    }
?>