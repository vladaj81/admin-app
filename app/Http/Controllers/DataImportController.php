<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ImportDatabaseData;
use Spatie\Permission\Models\Role;

class DataImportController extends Controller
{
    private array $importTypes;

    /**
     * Construct method for getting import types configuration
     */
    public function __construct()
    {
        $this->importTypes = config('importtypes.import_types');
    }

    /**
     * Method for showing import data base view
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (auth()->user()->hasRole('Admin')) {

            $userPermissions = Role::findByName('Admin')->permissions->pluck('name')->toArray();
        
        } else {
            $userPermissions = $user->getPermissionNames()->toArray();
        }

        $types = $this->getAllowedImportTypesForCurrentUser($userPermissions);

        return view('dataimports.index', compact('types'));
    }
    
    /**
     * Method for getting allowed import types for the current user, based on permissions
     */
    public function getAllowedImportTypesForCurrentUser($userPermissions)
    {
        $types = array();
        $typeLabel = '';
        $fileTypeKey = '';

        foreach ($this->importTypes as $key => $importType) {

            if (in_array($importType['permissions_required'], $userPermissions)) {

                if (array_key_exists('files', $importType)) {

                    foreach ($importType['files'] as $key2 => $file) {

                        $fileTypeKey = $key .'_'. $key2;
                        $typeLabel = $importType['label'] .' - '. $file['label'];
                        
                        $types[$fileTypeKey]['label'] = $typeLabel;
                        $types[$fileTypeKey]['db_table'] = $file['db_table'];
                    }
                }
            }
        }

        return $types;
    }

    /**
     * Method for getting required headers, for the selected import type
     */
    public function getImportTypeRequiredHeaders(Request $request)
    {
        $requiredTypeHeaders = array();

        $importTypeData = $request->input('import_type');
        $importTypeArray = explode('_', $importTypeData);
        $importType = $importTypeArray[0];
        $fileName = $importTypeArray[1];

        if (array_key_exists($importType, $this->importTypes)) {

            if (array_key_exists('files', $this->importTypes[$importType])) {

                foreach ($this->importTypes[$importType]['files'][$fileName]['headers_to_db'] as $header) {
                    $requiredTypeHeaders[] = $header['label'];
                }
            }
        }

        return response()->json(['required_headers' => $requiredTypeHeaders]);
    }

    /**
     * Method for importing files - Not finished
     */
    public function importFiles(Request $request)
    {
        $importTypeData = $request->input('import_type');
        $importTypeArray = explode('_', $importTypeData);
        $importType = $importTypeArray[0];
        $fileName = $importTypeArray[1];

        $requiredPermission = $this->importTypes[$importType]['permissions_required']; 

        if (!auth()->user()->can($requiredPermission)) {
            return back()->with("error", "User doesn't have the " .$requiredPermission. " permission!");
        }

        $request->validate([
            'import_type' => 'required',
            'uploadFiles' => 'required|array|min:1',
            'uploadFiles.*' => 'required|mimes:xlsx,csv',
        ]);


        $fileConfig = $this->importTypes[$importType]['files'][$fileName];
    
        $headersArray = $fileConfig['headers_to_db'];
        $requiredHeaders = array_keys($headersArray);

        $requestFiles = $request->file('uploadFiles');

        foreach ($requestFiles as $file) {

            //Parse file data to array
            $fileData = Excel::toArray(null, $file)[0];
     
            $fileHeaders = $fileData[0];

            if ($fileHeaders !== $requiredHeaders) {
                return back()->with("error", "File doesn't containt all required headers for the selected import type!");
            }

            ImportDatabaseData::dispatch($fileData, $fileConfig);
        }
    }
}
