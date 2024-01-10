<?php
    use Aws\S3\S3Client;
    /** Function **/
    //$x=$this->cdnupload($_FILES, "document", "luminous/uploads/","uploads/");
    
    /*Response */
    //$x['dbPath']
    function CdnUpload($_MyFILES, $key, $folderPath="luminous/uploads/",$folderdbPath="uploads/"){ //$key= FileName

        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => $GLOBALS['AppConfig']['CdnRegion'],
            'credentials' => [
                'key'    => $GLOBALS['AppConfig']['CdnKey'],
                'secret' => $GLOBALS['AppConfig']['CdnSecret']
            ]
        ]);
        $image=$key."_".date('Y_m_d_H_i_s')."_".rand(1000,9999);
        $sourcePath = $_MyFILES[$key]['tmp_name'];
        $extension = explode("/", $_MyFILES[$key]["type"]);
        $targetPath = $folderPath.$image.".".$extension[1]; // Target path where file is to be stored
        $dbPath = $folderdbPath.$image.".".$extension[1];
        if($extension[1]=="pdf"){
            $result = $s3Client->putObject([
                'Bucket' => $GLOBALS['AppConfig']['CdnBucket'],
                'Key'    => $targetPath,
                'SourceFile' => $sourcePath	,
                'ACL'    => 'public-read',	
                'ContentType' => 'application/pdf',
                'ContentDisposition' => 'inline',	
            ]);
        }else{
            $result = $s3Client->putObject([
                'Bucket' => $GLOBALS['AppConfig']['CdnBucket'],
                'Key'    => $targetPath,
                'SourceFile' => $sourcePath	,
                'ACL'    => 'public-read',	
            ]);
        }
        

        // print_r($result);
        if($result->get('ObjectURL')){
            return ['status'=>true, 'targetPath'=>$targetPath,'dbPath'=>$dbPath];
        }else{
            return false;
        }
    }
    function CdnMultiUpload($_MyFILES, $key, $folderPath="luminous/uploads/",$folderdbPath="uploads/"){ //$key= FileName

        $targetPath=array();
        $dbPath=array();
        foreach($_MyFILES[$key]['tmp_name'] as $k=>$v){
            $s3Client = new S3Client([
                'version' => 'latest',
                'region'  => $GLOBALS['AppConfig']['CdnRegion'],
                'credentials' => [
                    'key'    => $GLOBALS['AppConfig']['CdnKey'],
                    'secret' => $GLOBALS['AppConfig']['CdnSecret']
                ]
            ]);
            $image=$key."_".date('Y_m_d_H_i_s')."_".rand(1000,9999);
            $sourcePath = $_MyFILES[$key]['tmp_name'][$k];
            $extension = explode("/", $_MyFILES[$key]["type"][$k]);
            $targetPath[$k] = $folderPath.$image.".".$extension[1]; // Target path where file is to be stored
            $dbPath[$k] = $folderdbPath.$image.".".$extension[1];
            if($extension[1]=="pdf"){
                $result = $s3Client->putObject([
                    'Bucket' => $GLOBALS['AppConfig']['CdnBucket'],
                    'Key'    => $targetPath[$k],
                    'SourceFile' => $sourcePath	,
                    'ACL'    => 'public-read',	
                    'ContentType' => 'application/pdf',
                    'ContentDisposition' => 'inline',	
                ]);
            }else{
                $result = $s3Client->putObject([
                    'Bucket' => $GLOBALS['AppConfig']['CdnBucket'],
                    'Key'    => $targetPath[$k],
                    'SourceFile' => $sourcePath	,
                    'ACL'    => 'public-read',	
                ]);
            }
        }
        
        

        // print_r($result);
        if($result->get('ObjectURL')){
            return ['status'=>true, 'targetPath'=>$targetPath,'dbPath'=>$dbPath];
        }else{
            return false;
        }
    }

    function CdnDelete($file_path){ //$key= FileName

        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => $GLOBALS['AppConfig']['CdnRegion'],
            'credentials' => [
                'key'    => $GLOBALS['AppConfig']['CdnKey'],
                'secret' => $GLOBALS['AppConfig']['CdnSecret']
            ]
        ]);
        $result = $s3Client->deleteObject([
            'Bucket' => $GLOBALS['AppConfig']['CdnBucket'],
            'Key' =>  $GLOBALS['AppConfig']['CdnUploadDir'].$file_path,
        ]);
    }

?>