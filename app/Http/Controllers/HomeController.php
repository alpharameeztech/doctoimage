<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class HomeController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $process = new Process(['python', 'python/index.py']);
//        $process->run();
//
//// executes after the command finishes
//        if (!$process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }
//
//        echo $process->getOutput();

        $path = public_path() ;

        echo "Converting doc to pdf...";

        //working one
        //$results =  shell_exec(" libreoffice --headless --convert-to pdf /mnt/E/code/test/public/good.docx --outdir /mnt/E/code/test/public/");

        $result =  shell_exec("libreoffice --headless --convert-to pdf good.docx ");


//        $output = array();
//        exec("libreoffice --headless --convert-to pdf --outdir  /mnt/E/code/test/public/good.pdf /mnt/E/code/test/public/good.docx", $output);
//        print_r($output);

//        $process = new Process(['soffice --headless --convert-to pdf /mnt/E/code/test/public/good.docx --outdir /mnt/E/code/test/public/good.pdf']);
//        $process->run();
//
//// executes after the command finishes
//        if (!$process->isSuccessful()) {
//            throw new ProcessFailedException($process);
//        }
//
//        echo $process->getOutput();

       print_r($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
