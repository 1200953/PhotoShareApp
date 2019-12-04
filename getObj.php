    <?php

    require './vendor/autoload.php';

    use Aws\S3\S3Client;  
    use Aws\S3\Exception\S3Exception;

    // AWS Info
    $bucket = 'hire2020';
    // $fileName = "需要loop一遍数据库，得到所有file name";
    $fileName = 'download.jpg';
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
        //显示所有在数据库中的对象名称
        //display all objects in s3 bucket
        // $objects = $s3forloop->listObjects([
        //     'Bucket' => $bucket,
        //     "Prefix" => "hire2020-hire-xiekaihan-11291129/pictures"
        // ]);
        // $x = 0;
        // foreach ($objects['Contents']  as $object) {
        //     $x++;
        //     echo $object['Key'] . PHP_EOL;
        // }

        //创建分享链接，链接在一分钟后会失效
        //Creating a presigned URL
        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key,
        ]);

        $request = $s3->createPresignedRequest($cmd, '+1 minutes');

        // Get the actual presigned-url
        $presignedUrl = (string)$request->getUri();


        //下载指定的文件
        // Save object to a file.
        // $result = $s3->getObject(array(
        //     'Bucket' => $bucket,
        //     'Key' => $key,
        // ));
        // // Display the object in the browser.
        // header("Content-Type: {$result['ContentType']}");
        // echo $result['Body'];
        echo $presignedUrl;
    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }

    ?>