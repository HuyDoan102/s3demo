<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class UploadController extends Controller
{
    public function uploadS3(Request $request)
    {
        $temp = "";
        if($request->hasFile('profile_image')) {
            $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $filenametostore = $filename . '_' . time() . '.' . $extension;
//             dd($filenametostore);
            Storage::disk('s3')->put($filenametostore, fopen($request->file('profile_image'), 'r+'), 'public');
        }
        $temp_images = Storage::disk('s3')->files();
        return view('s3', compact('temp_images'));
    }

    public function uploadSDK(Request $request)
    {
        $temp = "";
        dd($request->profile_image);
        if($request->hasFile('profile_image')) {
            $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            $source = $filenametostore;
//            dd(fopen($request->file('profile_image'), 'r+'));
            /*$s3 = App::make('aws')->createClient('s3');
            $uploader = new MultipartUploader($s3, $source, [
                'Bucket' => 's3testsales',
                'Key' => fopen($request->file('profile_image'), 'r+'),
            ]);
            $uploader->upload();*/


            $s3 = App::make('aws')->createClient('s3');
            $s3->putObject(
                [
                    'Bucket' => 's3testsales',
                    'Key' => $filenametostore,
                    'Body' => fopen($request->file('profile_image'), 'r+'),
                    'ACL' => 'public-read',
                    'StorageClass' => 'REDUCED_REDUNDANCY'
                ]
            );
        }
    }

    public function createAWSSDK()
    {
        $BUCKET_NAME = config('aws.bucket_name');
        //Create a S3Client
        $s3Client = new S3Client(self::getS3Config());
        //Creating S3 Bucket
        try {
            $result = $s3Client->createBucket([
                'Bucket' => $BUCKET_NAME,
            ]);
            echo "Create SUCCESS";

        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }
    }

    private static function getS3Config()
    {
        if(config('app.env') == 'local'){

            return [
                'credentials' => [
                    'key'    => config('aws.credentials.key'),
                    'secret' => config('aws.credentials.secret')
                ],
                'region' => config('aws.region'),
                'version' => 'latest',
            ];
        }
    }

    public function UploadMulti(Request $request)
    {
        $client = new S3Client(self::getS3Config());
        $dir = base_path('storage/upload/');
//        $dir_storage = storage_path('upload/');
//        dd($dir_storage . " " . $dir);
//dd($client);
        try {
            $client->uploadDirectory($dir, config('aws.bucket_name'), 'FolderTestUpload',
                array(
                    'before' => function(\AWS\Command $command){
                        $command['ACL'] = 'public-read';
                    },
                )
            );
            echo "UPLOAD DIRECTORY SUCCESS";
        } catch (\Exception $ex) {
            throw ($ex);
            return false;
        }

    }
}
