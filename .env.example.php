<?php
  $variables = [
      'BASE_URL' => 'https://yourdomain.com/', //https://facebook.com/
      'START_URL' => '/specfic_page.aspx?display=50&page=1', //page to scrap 
  ];
  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
?>