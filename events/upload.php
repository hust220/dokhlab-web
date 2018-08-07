<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

$uploaddir = '/var/www/uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
echo $uploadfile."\n";
print_r($_FILES);

if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
  echo "upload temperary file successfully!\n";
  echo "now copy file from " . $_FILES['userfile']['tmp_name'] . " to " . $uploadfile . "\n";
  if(copy($_FILES['userfile']['tmp_name'],$uploadfile)){
     echo "copy correctly\n";
  }
  else{
     echo "mistake in copy command\n";
  }
}
else{
  echo "Possible file upload attack: filename." . $_FILES['userfile']['tmp_name'];
}

print "</pre>";

?> 
