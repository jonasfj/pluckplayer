<?php


$datadir = "data/settings/modules/pluckplayer/music/";
if(!is_dir($datadir)){
	$old = umask(0);
    mkdir($datadir, 0777, true);
	umask($old);
}

//Make sure the file isn't accessed directly
if((!ereg("index.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("admin.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("install.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("login.php", $_SERVER['SCRIPT_FILENAME']))){
    //Give out an "access denied" error
    echo "access denied";
    //Block all other code
    exit();
}

//Usefull function for making a good error code
function file_upload_error_message($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}

if(isset($_GET["m_delete"]) && file_exists($datadir . $_GET["m_delete"])){
    unlink($datadir . $_GET["m_delete"]);
    print "<p><b>The track \"".$_GET["m_delete"]."\" has been deleted.</b></p>";
    ?><br><a href="?action=pluckplayer"><<< <?php echo $lang_theme12; ?></a></p><?
    redirect("admin.php?module=pluckplayer", 5);
}else{

?>
<p><b>upload tracks to the music player and delete uploaded tracks.</b></p>

<span class="kop2">upload new track</span><br>
<form method="post" enctype="multipart/form-data">
    <b>Select new track:</b><br>
    <input type="file" name="track"><br><input type="submit" name="action" value="upload">
</form>
<?
if(isset($_FILES["track"])){
    if($_FILES["track"]["error"] > 0){
        print "<p><span style='color: red;'>Upload failed: " . file_upload_error_message($_FILES["track"]["error"]) .".</span></p>";
    }else{
        $filename = $datadir . $_FILES["track"]["name"];
        if(file_exists($filename)){
            print "<p><span style='color: red;'>Files: " . $_FILES["track"]["name"] ." already exists!</span></p>";
        }else{
            move_uploaded_file($_FILES["track"]["tmp_name"], $filename);
        }
    }
}
?><br>
<span class="kop2">delete uploaded track</span><br><p>
<?
$tracks = 0;
$music_dir = dir($datadir);
while(($track = $music_dir->read()) !== false){
    if($track == "." || $track == "..")
        continue;
    $tracks += 1; //count tracks to know if there were any..
?>
<div class='menudiv' style='margin: 20px;'><table>
<tr><td>
<img src="data/modules/pluckplayer/images/track.png" border="0" alt="">
</td><td style="width: 350px;">
<span style="font-size: 17pt;"><? print $track ?></span>
</td><td>
<a href="?module=pluckplayer&m_delete=<? print $track ?>"><img src="data/image/delete_from_trash.png" border="0" title="delete track" alt="delete track"></a>		
</td></tr>
</table></div>
<?

}

//If there was not tracks
if($tracks == 0){
    print "<span class='kop4'>no tracks uploaded yet...</span>";
}
?>
</p>

<?
#Load settings
require_once("data/modules/pluckplayer/settings.php");
$m_settings = load_music_settings("");

function m_check($key){
    global $m_settings;
    if($m_settings[$key])
        return "CHECKED";
}


function m_checked($val){
    if($val == "on")
        return true;
    else
        return false;
}

#Save settings if posted
if(isset($_POST["action"]) && $_POST["action"] == "save settings"){
    $m_settings["autoload"] = m_checked($_POST["autoload"]);
    $m_settings["autoplay"] = m_checked($_POST["autoplay"]);
    $m_settings["repeat_playlist"] = m_checked($_POST["repeat_playlist"]);
    $m_settings["repeat"] = m_checked($_POST["repeat"]);
    $m_settings["shuffle"] = m_checked($_POST["shuffle"]);
    $m_settings["activeDownload"] = m_checked($_POST["activeDownload"]);
    $m_settings["alphabetize"] = m_checked($_POST["alphabetize"]);
    if($_POST["crossFade"] == "false")
        $m_settings["crossFade"] = false;
    else
        $m_settings["crossFade"] = $_POST["crossFade"];
    $m_settings["width"] = intval($_POST["width"]);
    $m_settings["height"] = intval($_POST["height"]);
    $m_settings["skin"] = $_POST["skin"];
    save_music_settings($m_settings, "");
}

?>
<span class="kop2">player settings</span><br><p>
<form method="post">
<table>
<tr><td>Autoload:</td><td><input type="checkbox" name="autoload" <?print m_check("autoload");?> ></td></tr>
<tr><td>Autoplay:</td><td><input type="checkbox" name="autoplay" <?print m_check("autoplay");?> ></td></tr>
<tr><td>Repeat playlist:</td><td><input type="checkbox" name="repeat_playlist" <?print m_check("repeat_playlist");?> ></td></tr>
<tr><td>Repeat track:</td><td><input type="checkbox" name="repeat" <?print m_check("repeat");?> ></td></tr>
<tr><td>Shuffle:</td><td><input type="checkbox" name="shuffle" <?print m_check("shuffle");?> ></td></tr>

<tr><td>Cross fade:</td><td>
<select name="crossFade">
<option value="false" <? if($m_settings["crossFade"] == false) print "SELECTED";?>>Disabled</option>
<option value="1" <? if($m_settings["crossFade"] == 1) print "SELECTED";?>>1 sec.</option>
<option value="2" <? if($m_settings["crossFade"] == 2) print "SELECTED";?>>2 sec.</option>
<option value="3" <? if($m_settings["crossFade"] == 3) print "SELECTED";?>>3 sec.</option>
<option value="4" <? if($m_settings["crossFade"] == 4) print "SELECTED";?>>4 sec.</option>
<option value="5" <? if($m_settings["crossFade"] == 5) print "SELECTED";?>>5 sec.</option>
<option value="6" <? if($m_settings["crossFade"] == 6) print "SELECTED";?>>6 sec.</option>
<option value="7" <? if($m_settings["crossFade"] == 7) print "SELECTED";?>>7 sec.</option>
<option value="8" <? if($m_settings["crossFade"] == 8) print "SELECTED";?>>8 sec.</option>
<option value="9" <? if($m_settings["crossFade"] == 9) print "SELECTED";?>>9 sec.</option>
<option value="10" <? if($m_settings["crossFade"] == 10) print "SELECTED";?>>10 sec.</option>
<option value="11" <? if($m_settings["crossFade"] == 11) print "SELECTED";?>>11 sec.</option>
<option value="12" <? if($m_settings["crossFade"] == 12) print "SELECTED";?>>12 sec.</option>
</select>
</td></tr>
<tr><td>Allow downloading:</td><td><input type="checkbox" name="activeDownload" <?print m_check("activeDownload");?> ></td></tr>
<tr><td>Alphabetize:</td><td><input type="checkbox" name="alphabetize" <?print m_check("alphabetize");?> ></td></tr>
<tr><td>Width:</td><td><input type="text" name="width" value="<?print $m_settings["width"];?>"> <span class='kop4'>px</span></td></tr>
<tr><td>Height:</td><td><input type="text" name="height" value="<?print $m_settings["height"];?>"> <span class='kop4'>px</span></td></tr>
<tr><td>Skin:</td><td>
<select name="skin">
<?
$m_skin_dir = dir("data/modules/pluckplayer/player/skins/");
while(($skin = $m_skin_dir->read()) !== false){
    if($skin == "." || $skin == "..")
        continue;
    if($m_settings["skin"] == $skin)
        print "<option value=\"" . $skin . "\" SELECTED>" . $skin . "</option>\n";
    else
        print "<option value=\"" . $skin . "\">" . $skin . "</option>\n";
}
?>
</select>
</td></tr>
</table>
<input type="submit" name="action" value="save settings">
</form>
<br><a href="?action=modules"><<< <?php echo $lang_theme12; ?></a></p>

<? } //End the else that skips everything if we just deleted a file ?>
