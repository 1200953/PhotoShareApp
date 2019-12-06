<?php
function getdir($dir){
    static $str = '';
    if(is_file($dir)){
        $str.=$dir.'<br>';
    }else{
        //check if it is fake dir or not
        if(is_dir($dir)){
            //open dir
            $openDir = opendir($dir);
            while(($file = readdir($openDir)) !==false ){
                //echo $file.'<br>';
                if($file != '.' && $file != '..'){
                    if(is_file($dir.'/'.$file)){
                        $str.=$file.'<br>';
                    }elseif(is_dir($dir.'/'.$file)){
                        getdir($dir.'/'.$file);
                    }
                }
            }
            closedir($openDir);
        }
    }
    return $str;
}

echo getdir('./uploads');

?>