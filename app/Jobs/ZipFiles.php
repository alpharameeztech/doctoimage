<?php

namespace App\Jobs;

use App\Repositories\Interfaces\ZipFilesInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ZipFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename, $source, $destination;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $source, $destination)
    {
        $this->filename = $fileName;
        $this->source = $source;
        $this->destination = $destination;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ZipFilesInterface $zip)
    {
        $zip->execute($this->filename,$this->source,$this->destination);
    }
}
