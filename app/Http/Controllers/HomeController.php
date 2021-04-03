<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\DocToPdfInterface;
use App\Repositories\Interfaces\PdfToImageInterface;
use App\Repositories\Interfaces\ZipFilesInterface;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class HomeController extends Controller
{
    protected $docToPdf;
    protected $pdfToImage;
    protected $zip;

    public function __construct(
        DocToPdfInterface $docToPdf,
        PdfToImageInterface $pdfToImage,
        ZipFilesInterface $zip
    ){
        $this->docToPdf = $docToPdf;
        $this->pdfToImage = $pdfToImage;
        $this->zip = $zip;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function convertDocToPdf(){
        $file = 'good.docx';

        $result = $this->docToPdf->execute($file);

        print_r($result);
    }

    public function convertPdfToImage(){

        $file = 'good.pdf';

        $result = $this->pdfToImage->execute($file);

        print_r($result);
    }

    public function zipFiles(){
        $files = "*"; //default path = public
        $result = $this->zip->execute($files);
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
