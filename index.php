<?php // constants and global variables

$upload_dir = 'files';
$filefield = $_FILES['file'];
$me = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

?>
<html>
<body>

<form method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file">
<input type="submit" name="submit" value="Submit">
</form>

<pre>
curl -v -L -F file=@/path/to/file http://<?php echo $me; ?>
</pre>

<?php
if ($filefield) {
    if ($filefield["error"] > 0) {
        echo "<p>Error: " . $filefield["error"] . "</p>\n";
    }
    else {
        echo "<p>Upload: " . $filefield["name"] . "</p>\n";
        echo "<p>Type: " . $filefield["type"] . "</p>\n";
        echo "<p>Size: " . ($filefield["size"] / 1024) . " kB</p>\n";
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir)) {
                echo "<p>Error: could not create directory for file uploads.</p>\n";
            }
        }
        if (is_dir($upload_dir)) {
            $target = $upload_dir . '/' . $filefield["name"];
            move_uploaded_file($filefield["tmp_name"], $target);
            if (is_file($target)) {
                echo "<p>Successfully uploaded to ". $target ."</p>\n";
            }
        }
    }
}

$fileinfos = array();
if ($handle = opendir($upload_dir)) {
    while (false !== ($filename = readdir($handle))) {
        $path = $upload_dir.'/'.$filename;
        if (is_file($path)) {
            $info = array();
            $info['filename'] = $filename;
            $info['path'] = $path;
            array_push($fileinfos, $info);
        }
    }
    closedir($handle);
}

if ($fileinfos) {
    echo "<h1>Files</h1>\n";
    echo "<ul>\n";
    foreach ($fileinfos as $info) {
        $filesize = filesize($info['path']);
        $kbsize = floor($filesize / 1024);
        if ($filesize && ! $kbsize) {
            $kbsize = '< 1';
        }
        printf('<li><a href="%s">%s (%s kB)</a></li>'."\n", 
            $info['path'], $info['filename'], $kbsize);
    }
    echo "</ul>\n";
}
?>
</body>
</html>
