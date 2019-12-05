<?php
require './vendor/autoload.php';
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$IAM_KEY = 'AKIAVLSEBUAJXLPCLWGM';
$IAM_SECRET = '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';
$p_id = $_GET["pid"];

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
        ":ID" : "' . $p_id . '"
    }
    ');

    $params = [
        'TableName' => 'hire2020-hire-xiekaihan-11291129',
        'KeyConditionExpression' => '#id = :ID',
        'ExpressionAttributeNames'=> [ '#id' => 'ID' ],
        'ExpressionAttributeValues'=> $eav
    ];

    try {
        $comment_list = array();
        $result = $dynamodb->query($params);

            echo "Query succeeded.\n";

        
        
        foreach ($result['Items'] as $user) {
            $data = $marshaler->unmarshalValue($user['comment']);
            // echo $data;
            foreach ($data as $record) {
                array_push( $comment_list, $record );
            }
        }
             

        $tmpJson = json_encode($comment_list);

        echo $tmpJson;
          
        // echo $response;
        }catch (DynamoDbException $e){
            die('Error:' . $e->getMessage());
        }

?>