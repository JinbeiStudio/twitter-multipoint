<?php

 function deleteDirectory($path)
    {
        //Liste les noms des fichiers
        $files = glob($path . '/*');

        //Supprime les fichiers
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
        //suppression du dossier vide
        if (is_dir('../' . $path)) {
            rmdir('../' . $path);
        }
    }

    //si le token est absent ou date d'au moins un jour
    if((!isset($_SESSION['token'])) || (date('Ymd') >  explode('_',$_SESSION['token'])[2]))
    {
        $_SESSION['token'] = 't_' . rand(0,999999) . '_' . date('Ymd');
    }
   
        //Liste les noms des dossiers de tmp
        $folders = glob('../tmp/*');
        
        //Parcours les dossiers
        foreach ($folders as $folder) {
            //si le dosseir est trop vieux
            if (date('Ymd') > explode('_',$folder)[2]) {
                // vide le dossier
                deleteDirectory($folder); 
                
                //Suppression du dossier vide
                if (is_dir($folder)) {
                    rmdir($folder);
                }
            }
            
        }



