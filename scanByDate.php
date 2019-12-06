<?php
require './vendor/autoload.php';
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$IAM_KEY = 'AKIAVLSEBUAJXLPCLWGM';
$IAM_SECRET = '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';
$date = $_GET["date"];

$sdk = new Aws\Sdk([
    'region'   => 'cn-north-1',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

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
        die("Error: " . $e->getMessage());
    }

    


    $eav = $marshaler->marshalJson('
    {
        ":date" : "' . $date .'"' . '
    }
    ');

    $params = [
        'TableName' => 'hire2020-hire-xiekaihan-11291129',
        'FilterExpression' => '#dt = :date',
        'ExpressionAttributeNames'=> [ '#dt' => 'date' ],
        'ExpressionAttributeValues'=> $eav

        
    ];

    try {
        $clist = array();
        $result = $dynamodb->scan($params);

            echo "Query succeeded.\n";

        
        
        foreach ($result['Items'] as $user) {
            echo $data = $marshaler->unmarshalValue($user['ID']);
            array_push( $clist, $data);
        }
             

        $tmpJson = json_encode($clist);

        echo $tmpJson;
          
        // echo $response;
        }catch (DynamoDbException $e){
            die('Error:' . $e->getMessage());
        }

?>