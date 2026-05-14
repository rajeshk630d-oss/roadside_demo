<?php

namespace App\Http\Controllers;

use App\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
use Exception;
use ZipArchive;

class BackupController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', '0');
        ini_set("memory_limit", "-1");
    }

    public function index(Request $request){
        $backups = Backup::with('user')->get();
        return view('backups.index',compact('backups'));
    }
    public function get_backup (){
        $backup_folder = uniqid(rand());
        $backup = new Backup();
        $backup->backup_folder = $backup_folder;
        $backup->user_id = Auth::user()->id;
        $backup->save();

        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table_key => $table){
            $html = "";
            $key = "Tables_in_".env('DB_DATABASE' , 'roadside');
            $table_name = $table->$key;
            if($table_name == 'job_data'){
                continue;
            }
            $show_table_query = "SHOW CREATE TABLE " . $table_name . "";
            $table_names_query = DB::select(DB::raw($show_table_query));
            $show_table_row = (array) $table_names_query[0];
            $create_table_values = array_values($show_table_row);
            $create_table_query = $create_table_values[1];
            $create_table_query = (string) $create_table_query;
            $html .= "\n\n" . $create_table_query. ";\n\n";
            $table_data = DB::table($table_name)
//                ->limit(1000)
                ->get()->toArray();
            if(count($table_data) > 0){
                $quary_values_array = array();
                $query = "";
                foreach ($table_data as $line_data) {
                    $record = (array)$line_data;
                    $record = (array)$record;
                    $table_column_array = array_keys($record);
                    foreach ($table_column_array as $table_column_key => $name) {
                        $table_column_array[$table_column_key] = '`' . $table_column_array[$table_column_key] . '`';
                    }

                    $table_value_array = array_values($record);

                    $query = "\nINSERT INTO $table_name (" . implode(", ", $table_column_array) . ") VALUES \n";

                    foreach($table_value_array as $table_value_key => $record_column)
                        $table_value_array[$table_value_key] = addslashes($record_column);
                    $quary_values_array[] = "('" . implode("','", $table_value_array) . "')";
                }
//                $html .= $query;
                $array_count = 100;
                foreach($quary_values_array as $quary_value_key => $quary_value){
                    if($quary_value_key%$array_count == 0){
                        $html .= "\n";
                        $html .= $query;
                    }
                    if($quary_value_key%$array_count == ($array_count - 1)){
                        $html .= $quary_value  . " ; \n";
                    }else {
                        $html .= $quary_value  . " ,\n";
                    }
                }
            }
            $file = $table_name. '_file.sql';
            $destinationPath=base_path('storage/app/backup/'.$backup_folder."/");
            if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
            File::put($destinationPath.$file,$html);
        }
        return back()->with('flash_success' , 'Backup created successfully.');
//        return response()->download($destinationPath.$file);
//        dd($html);
    }
    public function download_backup($id){
        try{
            $backup = Backup::findOrFail($id);
            $folder = base_path('storage/app/backup/'.$backup->backup_folder);
            $zip = new ZipArchive();
            $fileName = $backup->backup_folder.'.zip';
            //dd(public_path("backups/".$fileName));
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
            {
                $files = File::files($folder);
                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
                $zip->close();
            }
            return response()->download(public_path($fileName));
            return back()->with('flash_success','Downloaded successfully.');
        }catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!')->withInput();
        }
    }
}
