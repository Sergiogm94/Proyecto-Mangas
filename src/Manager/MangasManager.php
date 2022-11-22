<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class MangasManager
{

    public function uploadImage(UploadedFile $image, $target) {
        $fileName = uniqid().".".$image -> guessExtension();   // Con esto se le da un nombre con un numero aleatorio a la imagen pero se conserva la extensión
        if(!is_dir($target)){
            mkdir($target, 0777);
        }
        $image -> move($target, $fileName);
        // Aquí la imagen está subida en $target/$filename
        return $fileName;
    }

}