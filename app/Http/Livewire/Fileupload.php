<?php

namespace App\Http\Livewire;

use App\Repositories\Interfaces\DocToPdfInterface;
use App\Repositories\Interfaces\PdfToImageInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
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

    public $folderName = '';

    public $folderNameHoldingPdfFiles = 'pdf';

    public $folderNameToHoldImages = 'images';

    public $downloadLink = '';

    protected $docToPdf;

    public function save(DocToPdfInterface $docToPdf,  PdfToImageInterface $pdfToImage, ZipFilesInterface $zip)
    {
        $this->validate([
            'files.*' => 'file|max:1024', // 1MB Max
        ]);

        //unique name for the directory to store files
        $directoryName = Helper::uniqueName();

        $this->folderName = $directoryName;

        foreach ($this->files as $file) {
            $file->storePublicly("$directoryName");
        }

        $this->convertFilesToPdf($docToPdf, $pdfToImage,$directoryName,$zip);

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

    public function convertFilesToPdf($docToPdf,$pdfToImage,$uploadedPath,$zip){
        $path = $uploadedPath . "/*";

        $file =  Storage::path("$path");
        $output = Storage::path("$uploadedPath/$this->folderNameHoldingPdfFiles");

        //interface method
        $docToPdf->convertFiles($file, $output);

        $this->convertFilesToImage($pdfToImage,$uploadedPath, $zip);

       // return $result;
    }

    protected function convertFilesToImage($pdfToImage,$uploadedPath, $zip){
        $path = $uploadedPath ;

        $file =  Storage::path("$path");
        $output = Storage::path("$uploadedPath") . "/$this->folderNameHoldingPdfFiles";

        //interface method
        $result = $pdfToImage->convertFiles($output,$this->folderNameToHoldImages);

        //zip files
        $this->zipFiles($uploadedPath, $zip);

        return $result;
    }

    protected function zipFiles($folderName, $zip){

        $path = Storage::path($folderName) . "/$this->folderNameHoldingPdfFiles/$this->folderNameToHoldImages";

        $zip->execute($folderName,$path);

        $publicPath = public_path();

    }

    public function download()
    {
        $path = storage_path() . '/app/' . $this->folderName . '/'. $this->folderName . '.zip';
        return response()->download($path);
    }
}
