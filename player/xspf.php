<?php
#XSPF playlist generator

#Data folder
$reldatadir = "../../../settings/modules/pluckplayer/music/";
$datadir = "data/settings/modules/pluckplayer/music/";

if(!is_dir($reldatadir)){
	$old = umask(0);
	mkdir($reldatadir, 0777, true);
	umask($old);
}

header("Content-type: text/xml");

#Simple function to get filename without exention
function getFilenameWithoutExt($filename){
    $pos = strripos($filename, '.');
    if($pos === false){
        return $filename;
    }else{
        return substr($filename, 0, $pos);
    }
}

print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ;?>
<playlist version="0" xmlns="http://xspf.org/ns/0/">
    <title>Playlist</title>
    <trackList>
<?
$music_dir = dir($reldatadir);
while(($track = $music_dir->read()) !== false){
    if($track == "." || $track == "..")
        continue;
    ?>
    <track>
        <title><? print getFilenameWithoutExt($track) ?></title>
        <location><? print $datadir . $track ?></location>
    </track>
<?
}
?>
    </trackList>
</playlist>
