<?php
require './vendor/autoload.php';
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$IAM_KEY = 'AKIAVLSEBUAJXLPCLWGM';
$IAM_SECRET = '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';
// $p_id = $_GET["pid"];
$p_id = '(string)';


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
        $msg1 = "";
        $result = $dynamodb->query($params);

            echo "Query succeeded.\n";

        
        
        foreach ($result['Items'] as $user) {
            // echo $marshaler->unmarshalValue($user['ID']) . ': ' .
            //     $marshaler->unmarshalValue($user['ip']) . ': ' .
            //     $marshaler->unmarshalValue($user['date']) . ': ' .
            //     $marshaler->unmarshalValue($user['time']) . ': ' .
            //     $marshaler->unmarshalValue($user['pname']) . 
            //      "\n";

            $tmp1 = $marshaler->unmarshalValue($user['ID']);
            $tmp2 = $marshaler->unmarshalValue($user['ip']);
            $tmp3 = $marshaler->unmarshalValue($user['date']);
            $tmp4 = $marshaler->unmarshalValue($user['time']);
            $tmp5 = $marshaler->unmarshalValue($user['pname']);
        }


        $p_list = array($tmp1,$tmp2,$tmp3,$tmp4,$tmp5);

        $tmpJson = json_encode($p_list);

        echo $tmpJson;

        

        
        
        
        // echo $response;
        }catch (DynamoDbException $e){
            die('Error:' . $e->getMessage());
        }


?>