<?php
require './vendor/autoload.php';	
	use Aws\S3\S3Client;
	use Aws\DynamoDb\DynamoDbClient;
	use Aws\DynamoDb\Exception\DynamoDbException;
	use Aws\S3\Exception\S3Exception;

	//ip是用户上传时的ip，日期和时间是用户上传时的时间
	$id = 'ip_'.$_SERVER["REMOTE_ADDR"];
	$ipAddr = $_SERVER["REMOTE_ADDR"];
	$date = date("d/m/Y");
	$time = date("h:i:sa");
	//文件名，路径都不需要改动
	$pname = basename($_FILES["fileToUpload"]['name']);
	$keyName = 'hire2020-hire-xiekaihan-11291129/pictures/' . basename($_FILES["fileToUpload"]['name']);
	$pathInS3 = 'https://s3.cn-north-1.amazonaws.com/' . $bucketName . '/' .  $keyName;

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
	
	

//这段代码上传到本地uploads文件夹里，可以忽略
//Check if image file is a actual image or fake image
// $target_dir = "uploads/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//     if($check !== false) {
//         echo "File is an image - " . $check["mime"] . ".";
//         $uploadOk = 1;
//     } else {
//         echo "File is not an image.";
//         $uploadOk = 0;
//     }
// }
// // Check if file already exists
// if (file_exists($target_file)) {
//     echo "Sorry, file already exists.";
//     $uploadOk = 0;
// }
// // Check file size
// if ($_FILES["fileToUpload"]["size"] > 500000) {
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
// }
// // Allow certain file formats
// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
// && $imageFileType != "gif" ) {
//     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//     $uploadOk = 0;
// }
// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//     echo "Sorry, your file was not uploaded.";
// // if everything is ok, try to upload file
// } else {
//     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//         echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
//     } else {
//         echo "Sorry, there was an error uploading your file.";
//     }
// }

//将信息上传至数据库
//put item to dynamodb
try {
	$result = $client->putItem([
		'Item' => [
			'ID' => [
				'S' => "(string)$number",
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
	
	echo $result;
	}catch (DynamoDbException $e){
		die('Error:' . $e->getMessage());
	}

?>