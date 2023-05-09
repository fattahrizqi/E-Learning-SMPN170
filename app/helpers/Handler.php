<?php

namespace App\helpers;

class Handler {

    public function file($file)
    {
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $error = $file['error'];
        $tmpName = $file['tmp_name'];

        if ( empty($tmpName)) {
            return false;
        }

        $validExtension = ['xlsx', 'docx', 'pdf', 'jpg', 'png'];
        $uploadExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($uploadExtension));

        if ( !in_array($fileExtension, $validExtension) ) {
            return false;
        }

        if ( $fileSize > 10000000 ) {
            return false;
        }

        $newFilename = $uploadExtension[0];
        $newFilename .= "_";
        $newFilename .= uniqid();
        $newFilename .= '.';
        $newFilename .= $fileExtension;

        $data = array('filename'=>$uploadExtension[0], 'dirname'=>$newFilename);

        move_uploaded_file($tmpName, 'repo/' . $newFilename);

        return $data;
    }

    function profpic($files){

        $fileName = $files['name'];
        $fileSize = $files['size'];
        $error = $files['error'];
        $tmpName = $files['tmp_name'];
    
        $validExtension = ['jpg', 'jpeg', 'png'];
        $uploadExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($uploadExtension));
    
        if ( !in_array($fileExtension, $validExtension)) {  
            return null;
        }
    
        //cek apakah ukuran file terlalu besar
        if($fileSize > 2000000){
            echo "<script>
                    alert('File too big');
                </script>";
            return null;
        }
    
        //generate nama gambar baru apabila ada nama file yang sama
        $newFileName = uniqid();
        $newFileName .= '.';
        $newFileName .= $fileExtension;
    
        move_uploaded_file($tmpName, 'asset/' . $newFileName);
    
        return $newFileName;
    
    }

}