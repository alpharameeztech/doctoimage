<?php

namespace App\Http\Livewire;

use App\Repositories\Interfaces\DocToPdfInterface;
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

    public $folderNameHoldingPdfFiles = 'pdf';

    public $folderNameToHoldImages = 'images';

    protected $docToPdf;

//    public function mount(DocToPdfInterface $docToPdf){
//        $this->docToPdf = $docToPdf;
//    }
    public function save(DocToPdfInterface $docToPdf)
    {
        $this->validate([
            'files.*' => 'file|max:1024', // 1MB Max
        ]);

        //unique name for the directory to store files
        $directoryName = Helper::uniqueName();

        foreach ($this->files as $file) {
            $file->storePublicly("$directoryName");
        }

        $this->convertFilesToPdf($docToPdf,$directoryName);

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

    public function convertFilesToPdf($docToPdf,$uploadedPath){
        $path = $uploadedPath . "/*";

        $file =  Storage::path("$path");
        $output = Storage::path("$uploadedPath/$this->folderNameHoldingPdfFiles");

      //  $result = shell_exec("libreoffice --headless --convert-to pdf $file --outdir $output");

        $docToPdf->convertFiles($file, $output);
        $this->convertFilesToImage($uploadedPath);

       // return $result;
    }

    protected function convertFilesToImage($uploadedPath){
        $path = $uploadedPath ;

        $file =  Storage::path("$path");
        $output = Storage::path("$uploadedPath") . "/$this->folderNameHoldingPdfFiles";

        $result = shell_exec("cd $output && find . -maxdepth 1 -type f -name '*.pdf' -exec pdftoppm -jpeg {} {} \;");
        $result = shell_exec("cd $output && mkdir $this->folderNameToHoldImages && mv *.jpg $this->folderNameToHoldImages/");

        $imagesPath = $uploadedPath . "/$this->folderNameHoldingPdfFiles/$this->folderNameToHoldImages";
        //zip files
        $this->zipFiles($uploadedPath);
        return $result;
    }

    protected function zipFiles($folderName){
        $public = public_path();
        \Log::info($public);
        shell_exec("cd $public && mkdir converted");
        $public = public_path() . '/converted';

        $zipFileName = $folderName;
        $path = Storage::path($folderName) . "/$this->folderNameHoldingPdfFiles/$this->folderNameToHoldImages";
        //after zipping the files
        //move the folder to the public directory
        return shell_exec("cd $path && zip $folderName.zip * && mv $folderName.zip $public");
    }
}
