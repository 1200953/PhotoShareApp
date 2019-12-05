<?php

require './vendor/autoload.php';

use Aws\S3\S3Client;  
use Aws\S3\Exception\S3Exception;

// AWS Info
$bucket = 'hire2020';
$fileName = $_GET["fname"];
$key = 'hire2020-hire-xiekaihan-11291129/pictures/'.$fileName;
$pathInS3 = 'https://s3.cn-north-1.amazonaws.com/' . $bucketName . '/' .  $keyName;


$IAM_KEY = 'AKIAVLSEBUAJXLPCLWGM';
$IAM_SECRET = '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';

    // Connect to AWS
    try {
        
        $s3 = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => $IAM_KEY,
                    'secret' => $IAM_SECRET
                ),
                'version' => 'latest',
                'region'  => 'cn-north-1'
            )
        );

        $s3forloop = S3Client::factory(
            array(
                'credentials' => array(
                    'key' => $IAM_KEY,
                    'secret' => $IAM_SECRET
                ),
                'version' => 'latest',
                'region'  => 'cn-north-1'
            )
        );
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }


//Use the plain API (returns ONLY up to 1000 of objects).
try {
    
    //Creating a presigned URL
    $cmd = $s3->getCommand('GetObject', [
        'Bucket' => $bucket,
        'Key' => $key,
    ]);

    $request = $s3->createPresignedRequest($cmd, '+1 minutes');

    // Get the actual presigned-url
    $presignedUrl = (string)$request->getUri();

    $tmpArr = array(
        'presignedUrl' => $presignedUrl,
    );

    $tmpJson = json_encode($tmpArr);

    echo $tmpJson;

 
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

?>