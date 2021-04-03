<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Fileupload extends Component
{
    use WithFileUploads;

    public $files = [];

    public $message = "message";

    public function save()
    {
        $this->validate([
            'files.*' => 'image|max:1024', // 1MB Max
        ]);

        foreach ($this->files as $file) {
            $file->store('photos');
        }

        $this->files = [];
    }
    public function render()
    {
        return view('livewire.fileupload');
    }
}
