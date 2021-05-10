<?php


class Upload
{

    public static function uploadPost(array $files, string $fileNewName,int $id,int $i,int $advId): bool
    {
        if(!is_dir('../pictures/Adds')){
            mkdir('../pictures/Adds');
        }
        if(!is_dir('../pictures/Adds/'.$advId)){
            mkdir('../pictures/Adds/'.$advId );
        }
        $tmpPath='../pictures/Adds/'.$advId;
        if(!is_dir($tmpPath.'/full/')){
            mkdir( $tmpPath.'/full/');
        }
        if(!is_dir($tmpPath.'/thumbnail/')){
            mkdir( $tmpPath.'/thumbnail/');
        }
        if(!is_dir($tmpPath.'/half/')){
            mkdir( $tmpPath.'/half/');
        }
        $file = $files['picture']['tmp_name'][$i];
        var_dump($file);
        $sourceProperties = getimagesize($file);
        $folderPathDash = $tmpPath.'/half/';
        $folderPathThumb = $tmpPath.'/thumbnail/';
        $folderPathFull = $tmpPath.'/full/';
        $fullPathDash = $_SESSION["path"] . "/" . $folderPathDash;
        $fullPathThumb = $_SESSION["path"] . "/" . $folderPathThumb;
        $fullPath = $_SESSION["path"] . "/" . $folderPathFull;
        $ext = pathinfo($files['picture']['name'][$i], PATHINFO_EXTENSION);
        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file);
                $targetLayer = self::imageResizeThump($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                imagepng($targetLayer, $fullPathThumb . $fileNewName );
                $imageResourceId1 = imagecreatefrompng($file);
                $targetLayer1 = self::imageResizeDash($imageResourceId1, $sourceProperties[0], $sourceProperties[1]);
                imagepng($targetLayer1, $fullPathDash . $fileNewName );

                break;


            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file);
                $targetLayer = self::imageResizeThump($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                imagejpeg($targetLayer, $fullPathThumb . $fileNewName );
                $imageResourceId1 = imagecreatefromjpeg($file);
                $targetLayer1 = self::imageResizeDash($imageResourceId1, $sourceProperties[0], $sourceProperties[1]);
                imagejpeg($targetLayer1, $fullPathDash . $fileNewName );

                break;


            default:
                echo "Invalid Image type.";
                return false;
        }


        move_uploaded_file($file, $fullPath . $fileNewName );
        return true;
    }

    public static function uploadProfilePicture(array $files, int $uid): string
    {
        $file = $files['picture']['tmp_name'];
        $sourceProperties = getimagesize($file);
        $fullPath = $_SESSION["path"] . "/pictures/users/";
        $ext = pathinfo($files['picture']['name'], PATHINFO_EXTENSION);
        $imageType = $sourceProperties[2];

        if (!is_dir($_SESSION["path"] . "/pictures")) {
            mkdir($_SESSION["path"] . "/pictures");
        }
        if (!is_dir($_SESSION["path"] . "/pictures/users")) {
            mkdir($_SESSION["path"] . "/pictures/users");
        }

        if (is_file($_SESSION["path"] . "/pictures/users/" . $uid . ".jpg")) {
            unlink($_SESSION["path"] . "/pictures/users/" . $uid . ".jpg");
        }
        if (is_file($_SESSION["path"] . "/pictures/users/" . $uid . ".png")) {
            unlink($_SESSION["path"] . "/pictures/users/" . $uid . ".png");
        }


        switch ($imageType) {


            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($file);
                $targetLayer = self::imageResizeThump($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                imagepng($targetLayer, $fullPath . $uid . "." . $ext);
                break;


            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($file);
                $targetLayer = self::imageResizeThump($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                imagepng($targetLayer, $fullPath . $uid . "." . $ext);
                break;


            default:
                echo "Invalid Image type.";
                return "";
        }

        return "pictures/users/" . $uid . "." . $ext;
    }

    private static function imageResizeThump($imageResourceId, $width, $height)
    {


        $targetWidth = 200;
        $targetHeight = 200;


        $targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);


        return $targetLayer;

    }

    private static function imageResizeDash($imageResourceId, $width, $height)
    {

        if (($width * 1.5) < $height) {
            $targetWidth = 600;
            $targetHeight = 800;
        } else {
            $targetWidth = 1000;
            $targetHeight = 500;
        }


        $targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);


        return $targetLayer;

    }

}