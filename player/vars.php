<?php

//Generate variables for the player
//See: http://lacymorrow.com/projects/jukebox/xspfdoc.html

require_once("../settings.php");

$settings = load_music_settings("../../../../");
function m_v_bool_out($val){
    if($val)
        return "true";
    else
        return "false";
}

print "&activeDownload=" . m_v_bool_out($settings["activeDownload"]);
print "&alphabetize=" . m_v_bool_out($settings["alphabetize"]);
print "&autoload=" . m_v_bool_out($settings["autoload"]);
print "&autoplay=" . m_v_bool_out($settings["autoplay"]);
print "&repeat=" . m_v_bool_out($settings["repeat"]);
print "&repeat_playlist=" . m_v_bool_out($settings["repeat_playlist"]);
print "&shuffle=" . m_v_bool_out($settings["shuffle"]);
print "&crossFade=" . m_v_bool_out($settings["crossFade"]);


print "&loaded=true";

?>
