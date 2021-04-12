<?php

namespace App\Jobs;

use App\Repositories\Interfaces\PdfToImageInterface;
use App\Services\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PdfToImageConverter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $source;
    protected $folderNameToHoldImages;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($source)
    {
        $this->source = $source;
        $this->folderNameToHoldImages = Helper::$folderNameToHoldImages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PdfToImageInterface $pdfToImage)
    {

        //interface method
        $result = $pdfToImage->convertFiles($this->source,$this->folderNameToHoldImages);

    }
}
