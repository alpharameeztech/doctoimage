<?php

namespace App\Http\Livewire;

use App\Jobs\DockToPdfConverter;
use App\Jobs\PdfToImageConverter;
use App\Jobs\ZipFiles;
use App\Models\Conversion;
use App\Models\File;
use App\Models\StorageFolder;
use App\Repositories\Interfaces\DocToPdfInterface;
use App\Repositories\Interfaces\PdfToImageInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
use App\Services\Helper;
use Carbon\Carbon;
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

    public $folderNameHoldingPdfFiles = '';

    public $folderNameToHoldImages = '';

    public $downloadLink = '';
    public $zipName = '';

    public $maxFilesAllowed;

    public $storageFolder;
    public $conversion;

    protected $docToPdf;

    public function mount(){
        $this->folderNameHoldingPdfFiles = Helper::$folderNameHoldingPdfFiles;
        $this->folderNameToHoldImages = Helper::$folderNameToHoldImages;
        $this->maxFilesAllowed = config('app.max_files_allowed');
    }

    public function save(DocToPdfInterface $docToPdf,  PdfToImageInterface $pdfToImage, ZipFilesInterface $zip)
    {
        $this->validate([
            'files.*' => "file",
        ]);

        $validationPassed = $this->validateFiles();

        if($validationPassed){

            //unique name for the directory to store files
            $directoryName = Helper::uniqueName();

            $this->zipName = $directoryName;

            $this->folderName = 'uploaded/' . $directoryName;

            //create a storage folder record
            $storageFolder = new StorageFolder;
            $storageFolder->name = $directoryName;
            $storageFolder->save();

            $this->storageFolder = $storageFolder;

            foreach ($this->files as $file) {
                $fileName = $file->storePublicly($this->folderName);

                //add the file record
                //and attach it with the storage folder
                $storageFolder->files()->create([
                  'name' => $fileName
                ]);
            }

            //create a new conversion record
           $conversion =  $storageFolder->conversion()->create([
                'from_type' => 'doc',
                'to_type' => 'jpg'
            ]);

            $this->conversion = Conversion::find($conversion->id);

            DockToPdfConverter::dispatch($this->folderName)->delay(now()->addMinutes(1)); //->delay(now()->addMinutes(5))

            $sourceOfPdfs = Storage::path($this->folderName) . "/$this->folderNameHoldingPdfFiles";

            PdfToImageConverter::dispatch($sourceOfPdfs)->delay(now()->addMinutes(2));

            $zipSource = Storage::path($this->folderName) . "/$this->folderNameHoldingPdfFiles/$this->folderNameToHoldImages";
            $destination = storage_path();

            ZipFiles::dispatch($this->zipName, $zipSource,$destination)->delay(now()->addMinutes(3));

           // $this->convertFilesToPdf($docToPdf, $pdfToImage, $this->folderName, $zip);

            session()->flash('success', 'Converted Successfully!');

            $this->resetData();
        }else{
            \Log::info('validation failed');
        }
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
//        $path = $uploadedPath . "/*";
//
//        $file =  Storage::path("$path");
//        $output = Storage::path("$uploadedPath/$this->folderNameHoldingPdfFiles");
//
//        //interface method
//        $docToPdf->convertFiles($file, $output);
//
//        $this->convertFilesToImage($pdfToImage,$uploadedPath, $zip);

       // return $result;
    }

    protected function convertFilesToImage($pdfToImage,$uploadedPath, $zip){
        $path = $uploadedPath ;

        $file =  Storage::path("$path");
        $output = Storage::path("$uploadedPath") . "/$this->folderNameHoldingPdfFiles";

        //interface method
        $result = $pdfToImage->convertFiles($output,$this->folderNameToHoldImages);

        //same the time when the files are converted
        $this->conversion->converted_at = Carbon::now();
        $this->conversion->status = "converted";
        $this->conversion->save();

        //zip files
        $this->zipFiles($uploadedPath, $zip);

        return $result;
    }

    protected function zipFiles($folderName, $zip){

        $path = Storage::path($folderName) . "/$this->folderNameHoldingPdfFiles/$this->folderNameToHoldImages";

        $destination = storage_path();

        $zip->execute($this->zipName, $path, $destination);

        $publicPath = public_path();

        //save the time when the zipping is done
        $this->conversion->zipped_at = Carbon::now();
        $this->conversion->save();


        //these are files that just uploaded
        //for the conversion
        //once they are converted and zipped
        //these files should be removed
        //$this->removeUploadedFiles();
    }

    public function download()
    {
        $path = storage_path()  . '/' . $this->zipName . '.zip';

        $this->conversion->downloaded_at = Carbon::now();
        $this->conversion->save();

        return response()->download($path);

    }

    protected function removeUploadedFiles(){
        $path = Storage::path($this->folderName);
        Helper::deleteDiretory($path);
    }

    protected function validateFiles(){
        if(count($this->files)  <= $this->maxFilesAllowed ){
            return true;
        }else{
            return false;
        }
    }
}
