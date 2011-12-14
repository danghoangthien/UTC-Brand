<?php
if(isset ($GLOBALS["HTTP_RAW_POST_DATA"])) {
$im = $GLOBALS["HTTP_RAW_POST_DATA"];
$rn = rand();
$fp = fopen('../../uploads/'.$rn.'.jpg', 'wb');
fwrite($fp, $im);
fclose($fp);
//if (exif_imagetype($rn.'.jpg') == IMAGETYPE_JPEG) {
echo 'http://adidasisallin.com.vn/uploads/'.$rn.'.jpg';
exit();
//}
}
echo "There has been an error";
?>