<?php
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);

#Create the player...

//Get some settings
require_once("data/modules/pluckplayer/settings.php");
$m_setting = load_music_settings("");

//The skin folder
$skin =         "data/modules/pluckplayer/player/skins/" . $m_setting["skin"];
//The xspf playlist
$playlist =     "data/modules/pluckplayer/player/xspf.php";
//The flash file
$swf =          "data/modules/pluckplayer/player/xspf_jukebox.swf";
//Player settings
$variables =    "data/modules/pluckplayer/player/vars.php";

$p_w = $m_setting["width"];
$p_h = $m_setting["height"];
?>

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="<?print $p_w?>" height="<?print $p_h?>" id="flashObject" align="middle">
<param name="movie" 
       value="<?print $swf?>?playlist_url=<?print $playlist?>&skin_url=<?print $skin?>&loadurl=<?print $variables?>" />
<param name="wmode" value="transparent" />
<embed 
    src="<?print $swf?>?playlist_url=<?print $playlist?>&skin_url=<?print $skin?>&loadurl=<?print $variables?>"
    wmode="transparent"
    width="<?print $p_w?>"
    height="<?print $p_h?>"
    name="flashObject"
    align="middle"
    type="application/x-shockwave-flash"
    pluginspage="http://www.macromedia.com/go/getflashplayer" />

</object>



