<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Validator;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function plates(Request $request)
    {
        if(Cache::get('file_'.$request->ip()))
        {
            $countPlates = count(explode(' ',Cache::get('file_'.$request->ip())));
            $countPlatesSearched = Cache::get('count_'.$request->ip()) ? Cache::get('count_'.$request->ip()) : 0;
            return view('plates', compact('countPlates', 'countPlatesSearched'));
        }
        else
            return redirect()->route('home');
    }

    public function upload(Request $request)
    {
        $rules = [
            'find' => 'sometimes|boolean'
        ];
        if($request->plates)
        {
            $plates = count($request->plates);
            foreach($request->plates as $k => $plate) {
                $rules['plates.' . $k] = 'sometimes|file|mimetypes:text/plain|mimes:txt';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $ip = $request->ip();

        if($request->plates)
        {
            $file = '';
            foreach($request->plates as $plate)
            {
                if(!$plate->isValid() || $plate->extension() != 'txt')
                    return redirect()->back()->withErrors(['find' => 'File is not valid'])->withInput();
                else
                {
                    $filetemp = File::get($plate);
                    $filetemp = str_replace("\r\n", " ", $filetemp);
                    $filetemp = str_replace("\n", " ", $filetemp);
                    $file = $file .' '. $filetemp;
                }
            }
            $expiresAt = Carbon::now()->addMinutes(60);
            Cache::put('file_'.$ip, $file, $expiresAt);
            Cache::put('count_'.$ip, 0, $expiresAt);
            
            return redirect()->route('plates');
              
        }
        if($request->has('find'))
        {
            $plates = Cache::get('file_'.$ip);
            if($plates)
                return redirect()->route('plates');
            else
                return redirect()->back()->withErrors(['find' => 'No file found, please upload a new file'])->withInput();

        }
        return redirect()->back()->withErrors(['plates' => 'Please, do something'])->withInput();
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate' => 'required|alpha_num',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $expiresAt = Carbon::now()->addMinutes(60);
        $ip = $request->ip();
        $plates = Cache::get('file_'.$ip);
        $countPlatesSearched = Cache::get('count_'.$ip);
        Cache::put('count_'.$ip, $countPlatesSearched + 1, $expiresAt);
        Cache::put('file_'.$ip, $plates, $expiresAt);

        if(!$plates)
            return response()->json(['file' => [0 => 'File is not loaded anymore, please reload']], 404);

            if(preg_match('^\b('.strtoupper($request->plate).')\b^', $plates))
            {
                $matches = [0 => $request->plate];
                return response()->json(['result' => 'danger', 'matches' => $matches], 200);
            }
            
        return response()->json(['result' => 'success'], 200);


    }
}
