<?php
require './vendor/autoload.php';
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\S3\S3Client;  
use Aws\S3\Exception\S3Exception;

$IAM_KEY = 'AKIAVLSEBUAJXLPCLWGM';
$IAM_SECRET = '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';

//$pathInS3 = 'https://s3.cn-north-1.amazonaws.com/' . $bucketName . '/' .  $keyName;
$pathInS3 = "www.asdas.com";

$id = '4';
$ipAddr = $_SERVER["REMOTE_ADDR"];;
$date = date("d/m/Y");
$time = date("h:i:sa");
$pname = "gg.jpg";


try{
$client = \Aws\DynamoDb\DynamoDbClient::factory(
    array(
        'credentials' => array(
            'key' => $IAM_KEY,
            'secret' => $IAM_SECRET
        ),
    'version' => 'latest',
    'region' => 'cn-north-1',
    // 'endpoint' => 'http://localhost:8000'
));
} catch (Exception $e){
    // if this fails. It stops here. Typically this is a REST call so this would
    // return a json object.
    die("Error: " . $e->getMessage());
}

try{
    //display all objects in s3 bucket
$bucket = 'hire2020';
$objects = $client->listObjects([
    'Bucket' => $bucket,
    "Prefix" => "hire2020-hire-xiekaihan-11291129/pictures"
]);
$x = 0;
foreach ($objects['Contents']  as $object) {
    $x++;
    echo $object['Key'] . PHP_EOL;
}
}catch(S3Exception $e)
    {
        die('Error:' . $e->getMessage());
    }



// create test table    
try {

$result = $client->putItem([
    'Item' => [
        'ID' => [
            'S' => "1",
        ],
        'ip' => [
            'S' => $ipAddr,
        ],
        'date' => [
            'S' => $date,
        ],
        'time' => [
            'S' => $time,
        ],
        'pname' => [
            'S' => $pname,
        ],
        'purl' => [
            'S' => $pathInS3,
        ],
    ],
    'ReturnConsumedCapacity' => 'TOTAL',
    'TableName' => 'hire2020-hire-xiekaihan-11291129',
]);

// $result = $client->describeTable([
//     'TableName' => 'hire2020-hire-xiekaihan-11291129', // REQUIRED
// ]);



echo $result;
}catch (DynamoDbException $e){
    die('Error:' . $e->getMessage());
}

?>