<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImageUpload;
use Image;
use ImageOptimizer;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('UploadImage.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'caption' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        if(!$validator->fails()){      
            $img = new ImageUpload;
           
            // if($request->hasFile('image')){

            //     $image = $request->file('image');
            //     //Get filename with extension
            //     $fileNameWithExt = $request->file('image')->getCLientOriginalName();
            //     // Get just filename
            //     $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //     // Get just ext
            //     $extension = $request->file('image')->getClientOriginalExtension();
            //     //File name to Store
            //     $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //     //Upload File
            //     $path = $request->file('image')->storeAs('public/image',$fileNameToStore);

            //     $imga = Image::make($image->getRealPath());
            //     $imga->crop(100, 100, 25, 25);
            //     // $croppath = public_path('storage/image/compressed/'.$fileNameToStore);
            //     // $imga->resize(100, 100, function ($constraint) {
            //     //     $constraint->aspectRatio();
            //     // });
            //     $destinationPath = public_path('/image');
            //     // $imga->move($destinationPath, $fileNameToStore);
            //     $imga->save($destinationPath, $fileNameToStore);
            // }
            if($request->hasFile('image')) {
                //get filename with extension
                $image = $request->file('image');

                $filenamewithextension = $request->file('image')->getClientOriginalName();
         
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
         
                //get file extension
                $extension = $request->file('image')->getClientOriginalExtension();
         
                //filename to store
                $filenametostore = $filename.'_'.time().'.'.$extension;
         
                //Upload File
                $request->file('image')->storeAs('public/image', $filenametostore);
         
                //Compress Image Code Here
         
                $filepath = public_path('storage/image/'.$filenametostore);
                
                try {
                    \Tinify\setKey(env("TINIFY_API_KEY"));
                    $source = \Tinify\fromFile($filepath);
                    $source->toFile($filepath);
                } catch(\Tinify\AccountException $e) {
                    // Verify your API key and account limit.
                    return redirect()->back()->with('error', $e->getMessage());
                } catch(\Tinify\ClientException $e) {
                    // Check your source image and request options.
                    return redirect()->back()->with('error', $e->getMessage());
                } catch(\Tinify\ServerException $e) {
                    // Temporary issue with the Tinify API.
                    return redirect()->back()->with('error', $e->getMessage());
                } catch(\Tinify\ConnectionException $e) {
                    // A network connection error occurred.
                    return redirect()->back()->with('error', $e->getMessage());
                } catch(Exception $e) {
                    // Something else went wrong, unrelated to the Tinify API.
                    return redirect()->back()->with('error', $e->getMessage());
                }

            }
            $img->image = $filenametostore;
            // $img->image = $fileNameToStore;
            $img->caption = $request['caption'];
            $img->save();
            return redirect()->back()->with('success', 'Image Uploaded');
        }
        else{
            return redirect()->back()->withInputs()->with('error', $validator);
        }


    }




    public function smush(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'caption' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        if(!$validator->fails()){      
            $img = new ImageUpload;

           
            // if($request->hasFile('image')){

            //     $image = $request->file('image');
            //     //Get filename with extension
            //     $fileNameWithExt = $request->file('image')->getCLientOriginalName();
            //     // Get just filename
            //     $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //     // Get just ext
            //     $extension = $request->file('image')->getClientOriginalExtension();
            //     //File name to Store
            //     $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //     //Upload File
            //     $path = $request->file('image')->storeAs('public/image',$fileNameToStore);

            //     $imga = Image::make($image->getRealPath());
            //     $imga->crop(100, 100, 25, 25);
            //     // $croppath = public_path('storage/image/compressed/'.$fileNameToStore);
            //     // $imga->resize(100, 100, function ($constraint) {
            //     //     $constraint->aspectRatio();
            //     // });
            //     $destinationPath = public_path('/image');
            //     // $imga->move($destinationPath, $fileNameToStore);
            //     $imga->save($destinationPath, $fileNameToStore);
            // }



            if($request->hasFile('image')) {
                //get filename with extension
                $filenamewithextension = $request->file('image')->getClientOriginalName();
         
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
         
                //get file extension
                $extension = $request->file('image')->getClientOriginalExtension();
         
                //filename to store
                $filenametostore = $filename.'_'.time().'.'.$extension;
         
                //Upload File
                $request->file('image')->storeAs('public/image', $filenametostore);
         
                //Compress Image Code Here
         
                $filepath = public_path('storage/image/'.$filenametostore);
                
                $mime = mime_content_type($filepath);
                $output = new \CURLFile($filepath, $mime, $filenametostore);
                $data = ["files" => $output];
                 
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty=60');
                curl_setopt($ch, CURLOPT_POST,1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    $result = curl_error($ch);
                }
                curl_close ($ch);
                 
                $arr_result = json_decode($result);
                 
                // store the optimized version of the image
                $ch = curl_init($arr_result->dest);
                $fp = fopen($filepath, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);

                // return redirect()->back()->with('success', "Image uploaded successfully.");
            }


            $img->image = $filenametostore;
            // $img->image = $fileNameToStore;
            $img->caption = $request['caption'];
            $img->save();
            return redirect()->back()->with('success', 'Image Uploaded');
        }
        else{
            return redirect()->back()->withInputs()->with('error', $validator);
        }


    }




    public function spatie(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'caption' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        if(!$validator->fails()){      
            $img = new ImageUpload;


            if($request->hasFile('image')) {
                //get filename with extension
                $filenamewithextension = $request->file('image')->getClientOriginalName();
         
                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
         
                //get file extension
                $extension = $request->file('image')->getClientOriginalExtension();
         
                //filename to store
                $filenametostore = $filename.'_'.'spatie'.'.'.$extension;
         
                //Upload File
                $request->file('image')->storeAs('public/image', $filenametostore);
         
                //Compress Image Code Here
         
                $filepath = public_path('storage/image/'.$filenametostore);


                
                ImageOptimizer::optimize($filepath);

                // return redirect()->back()->with('success', "Image uploaded successfully.");
            }

            $img->image = $filenametostore;
            // $img->image = $fileNameToStore;
            $img->caption = $request['caption'];
            $img->save();
            return redirect()->back()->with('success', 'Image Uploaded');
        }
        else{
            return redirect()->back()->withInputs()->with('error', $validator);
        }


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
