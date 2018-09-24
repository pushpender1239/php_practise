<?php
require 'pdfcrowd.php';

try
{
    // create the API client instance
    //username and key
    $client = new \Pdfcrowd\HtmlToPdfClient("egyan", "efbc5eed7f6aad221a49a2eb82a31356");

    // run the conversion and write the result to a file
    $client->convertUrlToFile("http://www.example.com", "example.pdf");
}
catch(\Pdfcrowd\Error $why)
{
    // report the error
    error_log("Pdfcrowd Error: {$why}\n");

    // handle the exception here or rethrow and handle it at a higher level
    throw $why;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    
</body>
</html>