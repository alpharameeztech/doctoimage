<?php

namespace App\Http\Livewire;

use App\Services\Helper;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Fileupload extends Component
{
    use WithFileUploads;

    public $files = [];

    public $error = "";

    public $text = "Convert";

    public function save()
    {
        $this->validate([
            'files.*' => 'file|max:1024', // 1MB Max
        ]);

        //unique name for the directory to store files
        $directoryName = Helper::uniqueName();

        foreach ($this->files as $file) {
            $file->storePublicly("$directoryName");
        }

        $this->convertFilesToPdf($directoryName);

        session()->flash('success', 'Converted Successfully!');

        $this->resetData();
    }

    public function resetData()
    {
        $this->files = [];
    }

    public function render()
    {
        return view('livewire.fileupload');
    }

    protected function convertFilesToPdf($uploadedPath){
        $path = $uploadedPath . "/*";

        $file =  Storage::path("$path");
        $output = Storage::path("$uploadedPath/pdf");

        $result = shell_exec("libreoffice --headless --convert-to pdf $file --outdir $output");

        $this->convertFilesToImage($uploadedPath);

        return $result;
    }

    protected function convertFilesToImage($uploadedPath){
        $path = $uploadedPath ;

        $file =  Storage::path("$path");
        $output = Storage::path("$uploadedPath") . '/pdf';

        $result = shell_exec("cd $output && find . -maxdepth 1 -type f -name '*.pdf' -exec pdftoppm -jpeg {} {} \;");
        $result = shell_exec("cd $output && mkdir images && mv *.jpg images/");

        $imagesPath = $uploadedPath . "/pdf/images";
        //zip files
        $this->zipFiles($uploadedPath);
        return $result;
    }

    protected function zipFiles($uploadedPath){
        $path = Storage::path($uploadedPath) . '/pdf/images';
        return shell_exec("cd $path && zip converted.zip *");
    }
}
