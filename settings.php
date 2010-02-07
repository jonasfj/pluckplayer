<?php

require_once("spyc.php");

//Some idiot on the the test server I had disabled copy() WTF!!!
function copyemz($file1,$file2){
      $contentx =@file_get_contents($file1);
               $openedfile = fopen($file2, "w");
               fwrite($openedfile, $contentx);
               fclose($openedfile);
                if ($contentx === FALSE) {
                $status=false;
                }else $status=true;
               
                return $status;
}

 
function load_music_settings($rel_root){
	$music_settings_file = "data/settings/modules/pluckplayer/settings.yaml";
    if(!file_exists($rel_root . $music_settings_file)){
        copyemz($rel_root . "data/modules/pluckplayer/default.yaml", $rel_root . $music_settings_file);
    }

   return Spyc::YAMLLoad($rel_root . $music_settings_file);
}

function save_music_settings($m_settings, $rel_root){
	$music_settings_file = "data/settings/modules/pluckplayer/settings.yaml";
    $m_yaml = Spyc::YAMLDump($m_settings);
    file_put_contents($rel_root . $music_settings_file, $m_yaml);
}

?>
