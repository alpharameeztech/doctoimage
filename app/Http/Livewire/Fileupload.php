<?php

namespace App\Http\Livewire;

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
            'files.*' => 'image|max:1024', // 1MB Max
        ]);

        foreach ($this->files as $file) {
            $file->store('photos');
        }

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
}
