<?php
$protocol = $_SERVER["SERVER_PROTOCOL"];
if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol ) $protocol = 'HTTP/1.0';
header( "$protocol 503 Service Unavailable", true, 503 );
header( 'Content-Type: text/html; charset=utf-8' );
header( 'Retry-After: 600' ); // 10 minutes
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
  <title>Temporarily Under Maintenance</title>
  <meta charset="utf-8" />
  <style>
  body { background-color:#E5E5E5;}
  #content { max-width:600px; margin:50px auto; text-align:center; }
  h1 {}
  p {}
  </style>
</head>
<body>

<div id="content">
  <div class="text">
    <h1>Down for Maintenance</h1>
    <p>We are temporarily down and shall return shortly. Sorry for the inconvenience.</p>
  </div>
</div>

</body>
</html>
<?php die(); ?>