<?php
require './vendor/autoload.php';	
	use Aws\S3\S3Client;
	use Aws\DynamoDb\DynamoDbClient;
	use Aws\DynamoDb\Exception\DynamoDbException;
	use Aws\S3\Exception\S3Exception;

    $p_id = $_GET["pid"];
    $new_cmt = $_GET["comment"];
    $comment_list = array();
	array_push( $comment_list, $new_cmt );
	
	// AWS Info
	$bucketName = 'hire2020';
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
		
	} catch (Exception $e) {
		// if this fails. It stops here. Typically this is a REST call so this would
		// return a json object.
		die("Error: " . $e->getMessage());
	}
	


	// Add it to S3
	try {
		// Uploaded:
		$file = $_FILES["fileToUpload"]['tmp_name'];
		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);
	
	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} 
	
	
//将信息上传至数据库
//put item to dynamodb
try {
	

	$result = $client->updateItem([
		'TableName' => 'hire2020-hire-xiekaihan-11291129',
		'Key' => array(
			'id' => array('ID' => $p_id),
		),
		'AttributeUpdates' => array(
			'comment_list' => array(
				'Value' => array('SS' => $comment_list),
				'Action' => AttributeAction::PUT)
		),
		'ReturnValues' => 'ALL_NEW'
	]);

    // echo $response;
    }catch (DynamoDbException $e){
        die('Error:' . $e->getMessage());
    }

?>