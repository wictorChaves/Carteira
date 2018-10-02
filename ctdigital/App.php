<?php

/**
 * Description of App
 *
 * @author Wictor
 */
class App {

    function getPastaRaiz() {
        return $this->parseDiretorio(__DIR__);
    }

    /**
     * Converte uma imagem para base 64
     * @param type $path Caminho do arquivo
     */
    public function imgToBase64($path) {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    /**
     * Gera um guid
     */
    public function guidv4() {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function isPost() {
        if ($_POST != null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna o valor POST ou FILE da requisição
     * @return array Array contendo os valores
     */
    private function getPost() {
        return $values = array_merge($_POST, $_FILES);
    }

    /**
     * Retorna o valor do POST ou FILE da requisição
     * @param string $name Nome da variável
     * @param object $defaultValue Valor padrão caso informação não seja encontrada
     * @return string Valor encontrado
     */
    public function getPostValue($name, $defaultValue) {
        $post = $this->getPost();
        if (isset($post[$name])) {
            return $post[$name];
        }
        return $defaultValue;
    }

    public function getIssetPost($name) {
        if (isset($post[$name])) {
            return true;
        }
        return false;
    }

    public function getGetValue($name, $defaultValue) {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }
        return $defaultValue;
    }

    public function getIssetGet($name) {
        if (isset($_GET[$name])) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $files
     * @param type $destination
     * @param type $overwrite
     * @return boolean
     */
    function create_zip($files = array(), $destination = '', $overwrite = false) {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file[0])) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file[0], str_replace(__DIR__ . DIRECTORY_SEPARATOR, "", $file[1]));
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }

    public function parseDiretorio($dir) {
        $barras = array("/", "\\");
        return str_replace($barras, DIRECTORY_SEPARATOR, $dir);
    }

    public function parseDiretorioFile($dir) {
        $barras = array("/", "\\");
        return "file://" . str_replace($barras, DIRECTORY_SEPARATOR, $dir);
    }

}
