<?php

require_once 'application/third_party/file-uploader.php';

class Uploader extends MY_BackendController {

    function __construct() {
        parent::__construct();

        UsuarioBackendSesion::force_login();
    }

    function logo() {        
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array('png','jpg','gif');
        // max file size in bytes
        $sizeLimit = 20 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload('uploads/logos/');
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
    
    function themes() {        
        // list of valid extensions, ex. array("ZIP")
        $cuenta = UsuarioBackendSesion::usuario()->cuenta_id;
        $ruta_uploads = 'uploads/themes/'. $cuenta .'/';
        $ruta_views = 'application/views/themes/'. $cuenta .'/'; 

        $resp = is_dir('uploads/themes/')? TRUE:mkdir('uploads/themes/');
        $resp = is_dir('application/views/themes/')? TRUE:mkdir('application/views/themes/');      
        $resp = is_dir($ruta_uploads)? TRUE:mkdir($ruta_uploads);
        $resp = is_dir($ruta_views)? TRUE:mkdir($ruta_views);      

        $allowedExtensions = array('zip');
        // max file size in bytes
        $sizeLimit = 20 * 1024 * 1024;
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($ruta_uploads,true,true);
        
        if(isset($result['success'])){
            $archivo=$result['full_path'];
            $partes_ruta = pathinfo($archivo);
            $directorio = $partes_ruta['dirname'];
            $filename = $partes_ruta['filename']; // desde PHP 5.2.0    

            if ($filename=='default') {
                $filename = 'default'.$cuenta;
            } else {
                
            }

            $source = $ruta_uploads . $filename . '/';
            $zip = new ZipArchive;
            if ($zip->open($archivo) === TRUE) {
                $zip->extractTo($source);
                $zip->close();
                unlink($archivo);    
            }   
            $fileorigen = $source . 'template.php';
            $filedestino = $ruta_views . $filename . '/template.php';

            if (file_exists($filedestino)) {
                unlink($filedestino);   
            } else if (!is_dir(dirname($filedestino))) {
                mkdir(dirname($filedestino));      
            }
            
            rename($fileorigen, $filedestino);
            $result['full_path'] = $source . 'preview.png';
            $result['file_name'] = 'preview.png'; 
            $result['folder'] = $filename;     

          }

        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }

    function firma() {        
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array('png','jpg','gif');
        // max file size in bytes
        $sizeLimit = 20 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload('uploads/firmas/');
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
    
    function firma_get($filename){
        readfile('uploads/firmas/'.$filename);
    }
    
    function timbre() {        
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array('png','jpg','gif');
        // max file size in bytes
        $sizeLimit = 20 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload('uploads/timbres/');
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
    
    function timbre_get($filename){
        readfile('uploads/timbres/'.$filename);
    }
    
    function logo_certificado() {        
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array('png','jpg','gif');
        // max file size in bytes
        $sizeLimit = 20 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload('uploads/logos_certificados/');
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
    
    function logo_certificado_get($filename){
        readfile('uploads/logos_certificados/'.$filename);
    }


}

?>
