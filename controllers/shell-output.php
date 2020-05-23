<?php
    $output = shell_exec("ls -l /media/usb/share/Music");
    echo "<pre>$output</pre>";
?>
<audio controls>
  <source src="\media\usb\share\Music\'A Horse with No Name.ogg'" type="audio/ogg">
  <source src="\media\usb\share\Music\'A Horse with No Name.mp3'" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
<form action="" method="post">
    <input type="file" name="" id="">
    <input type="submit" value="submit">
</form>