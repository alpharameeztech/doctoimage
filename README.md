
## File Converter

## About

Laravel based file converted. DOC, DOCX to JPG.

## Technology Stack
- [Laravel](https://laravel.com/).
- [Livewire](https://laravel-livewire.com/).
- Laravel Queues.
- LibreOfficeDocToPdf(Linux software)
- Pdftoppm (Linux software)

Laravel is accessible, powerful, and provides tools required for large, robust applications.

![alt-text](https://user-images.githubusercontent.com/36469012/116814670-84a61e00-ab73-11eb-838b-7424f40ccaf8.gif)

## Supported Conversions

Right now only the Word documents can be converted to image. This can be further extended to allow
more conversion types.

## Schema

- uploaded file location - path or file name
- session_id - unique id that would be used for connecting visitor from the side of API client and this specific file
- submit_time - date and time of the file submit
- in_progress - the field that would be used for letting the API know that file is in process of converting already. Null by default (means progress never started
- done_time - date and time that would be filled after the conversion is complete. Null by default.
- Success - boolean, null by defaul
- Download_time - null by default


## Frontend Flow

- User is able to upload several files. Config file where can specify how many files and of which maximum size could be uploaded.
- Frontend receives the files, puts it in a folder that is accessible for the backend only
- Each file should be stored in the unique folder in order to avoid the conflicts
- Frontend records to the database the fact that files are received. Saves the unique session_id, file name, date-time, etc.
- Now frontend turns into a “waiting” state displaying the loading icon indicating that file conversion is in progress
- The backend starts converting the files, also makes a record in the database that the conversion is in progress
- When conversion is done  the database is updated identifying the date-time of finished conversion
- After converting PDF to JPG system would return a set of images and delivered as a zipped archive.
- When the file is converted the download link is provided

## Backend Flow

- Queue workers are running
- Queue workers checks the database and grabs the paths of the files that are not converted and not in progress
- Tries to convert the file using Linux tools (LibreOfficeDocToPdf + pdftoppm).
- When PDF is converted to JPG each page is saved to a stand-alone JPG file. So in many cases we’ll have many JPG files after the conversion is done. Those files gets zipped
- Records “converted_at” in the database and fills “converted”

