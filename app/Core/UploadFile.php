<?php

namespace App\Core;

use Exception;

class UploadFile
{

    private $allowedExtensions = [];
    private $uploadDirectory;
    private $maxFileSize;
    private $initialName;

    /**
     * Construtor da classe que inicializa os parâmetros para a configuração do upload de arquivos.
     *
     * @param string $uploadDirectory O diretório onde os arquivos enviados serão armazenados.
     * @param array $allowedExtensions Um array contendo as extensões de arquivo permitidas para upload.
     * @param int $maxFileSize Tamanho máximo do arquivo permitido em megabytes (MB).
     */
    public function __construct($uploadDirectory, $allowedExtensions = [], $maxFileSize = 8)
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->allowedExtensions = $allowedExtensions;
        $this->maxFileSize = $this->convertMBtoBytes($maxFileSize);
    }

    private  function convertMBtoBytes($megabytes)
    {
        $bytesInMegabyte = 1048576;
        return $megabytes * $bytesInMegabyte;
    }

    public function formatMaxFileSize()
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = 0;
        $maxFileSizeInBytes = $this->maxFileSize;

        while ($maxFileSizeInBytes >= 1024 && $index < count($units) - 1) {
            $maxFileSizeInBytes /= 1024;
            $index++;
        }

        return round($maxFileSizeInBytes, 2) . ' ' . $units[$index];
    }

    public function initialFileName($name)
    {
        $this->initialName = $name;
    }

    public function upload($file)
    {
        if (empty($file) || !isset($file['name']) || $file['size'] == 0) {
            throw new Exception('No image.');
        }

        $fileExtension =  $this->getExtension($file['name']);
        $newFileName = $this->generateFileName() . "." .$fileExtension;
   
        $filePath = ASSETS . $this->uploadDirectory . '/' . $newFileName;

        if (!is_dir(dirname($filePath))) {
            throw new Exception("The directory provided does not exist: " . dirname($filePath));
        }

        if (!$this->isFileAllowed($fileExtension)) {
            throw new Exception('Invalid extension.');
        }

        if (!$this->isFileSizeValid($file['size'])) {
            throw new Exception('The file size exceeds the maximum allowed. ' . $this->formatMaxFileSize());
        }

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            $error = error_get_last();
            throw new Exception('Failed to upload file. Error: ' . $error['message']);
        }

        return $newFileName;
    }


    private function isFileAllowed($extension)
    {
        return in_array($extension, $this->allowedExtensions);
    }

    private function isFileSizeValid($fileSize)
    {
        return $fileSize <= $this->maxFileSize;
    }


    private function generateFileName()
    {

        $fileName = md5(date('d/m/Y_H:i:s'));

        if (!empty($this->initialName)) {
            $fileName = $this->initialName  . "_" . $fileName;
        }


        return $fileName;
    }

    private function getExtension($file)
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }
}
