<?php

	header('HTTP/1.1 503 Service Temporarily Unavailable');
	header('Status: 503 Service Temporarily Unavailable');
	header('Retry-After: 3600');

?>
<!DOCTYPE HTML>
<html lang="en-US">
  <head>
    <title>503 Service Temporarily Unavailable</title>
      <style type="text/css">
        body { font-family: Helvetica, sans-serif; color: #333; }
        h1, p { font-size: 24px; text-align: center; }
        p { font-size: 16px; line-height: 1.8em; font-weight: 700; }
        ul { width: 80%; margin: 0 auto; background-color: #eee; padding: 20px 20px 20px 50px; }
        ul li { margin-bottom: 15px; }
        pre { display: inline-block; margin: 0; padding: 0; }
      </style>
  </head>
  <body>
    <h1>Don't Panic.</h1>
    <p>Seems we can't establish a connection to the database. One of these may be your problem:</p>
    <ul>
      <li>You didn't install the Wordpress submodule or run the <pre>init.sh</pre> script.</li>
      <li>You forgot to create an empty file named <pre>env_local</pre> or <pre>env_staging</pre> in the web root folder.</li>
      <li>You didn't create the database.</li>
      <li>It's not your day.</li>
    </ul>
  </body>
</html>