<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Log;
Use Storage;
use Alert;
use Flash;

class BackupController extends Controller
{
   public function index()
    {
        $disk = Storage::disk(config('laravel.backup.destination.disks')[0]);
        $files = $disk->files(config('laravel.backup.name'));
        $backups = [];
        foreach ($files as $k => $f) {
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace(config('larave.backup.name') . '/', '', $f),
                   	'file_size' => $this->human_filesize($disk->size($f)),
                	'last_modified' => $this->getDate($disk->lastModified($f)),
                ];
            }
        }
        $backups = array_reverse($backups);
        return response()->json($backups);
    }

    public function create()
    {
        try {
            Artisan::call('backup:run', ['--only-db'=>true]);
            $output = Artisan::output();
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);

            $from = storage_path('app/Laravel');
			$to = storage_path('app');
            //Abro el directorio que voy a leer
			$dir = opendir($from);
			//Recorro el directorio para leer los archivos que tiene
			while(($file = readdir($dir)) !== false){
			    //Leo todos los archivos excepto . y ..
			    if(strpos($file, '.') !== 0){
			        //Copio el archivo manteniendo el mismo nombre en la nueva carpeta
			        rename($from.'/'.$file, $to.'/'.$file);
			    }
			}
        } catch (Exception $e) {
            //Flash::error($e->getMessage());
        }
    }

    public function getDate($date_modify){
        return \Carbon\Carbon::createFromTimeStamp($date_modify)->formatLocalized('%d %B %Y - %H:%M');
    }

    public function human_filesize($bytes, $decimals = 2) {
        if ($bytes < 1024) return $bytes . ' B';
        $factor = floor(log($bytes,1024));
        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . ['B', 'KB', 'MB', 'GB', 'TB', 'PB'][$factor];
    }

     public function download($file_name)
    {
        ob_end_clean();
        $file = config('laravel.backup.name') . '/' . $file_name;
        $disk = Storage::disk(config('laravel.backup.destination.disks')[0]);
        if ($disk->exists($file)) {
            $fs = Storage::disk(config('laravel.backup.destination.disks')[0])->getDriver();
            $stream = $fs->readStream($file);

            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "Esta Copia de Seguridad no Existe.");
        }
    }

    public function delete($file_name)
    {
        $disk = Storage::disk(config('laravel.backup.destination.disks')[0]);
        if ($disk->exists(config('laravel.backup.name') . '/' . $file_name)) {
            $disk->delete(config('laravel.backup.name') . '/' . $file_name);
        } else {
            abort(404, "El archivo de copia de seguridad no existe.");
        }
    }


}
