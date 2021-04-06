<?php

namespace App\Repositories;

use App\Advertisement;
use App\Repositories\Interfaces\AdvertisementRepositoryInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
use Illuminate\Support\Facades\Storage;

class Zip implements ZipFilesInterface
{

    public function execute($fileName, $filesPath)
    {
        // upload zip file to the public folder
//        $public = public_path();
//        shell_exec("cd $public && mkdir converted");
//        $public = public_path() . '/converted';
//
//        //after zipping the files
//        //move the folder to the public directory
//        return shell_exec("cd $filesPath && zip $fileName.zip * && mv $fileName.zip $public");

       //save the files on the same storage folder directory

        $path = Storage::path($fileName) . '/pdf/images';
        $pathOfZip = Storage::path($fileName);
        //after zipping the files
        return shell_exec("cd $path && zip $fileName.zip * && mv $fileName.zip $pathOfZip");
    }

}
