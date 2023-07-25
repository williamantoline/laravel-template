<?php

namespace App\Http\Controllers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function put(Request $request): array
    {
        $extension = ".png";
        $fileName = Str::ulid()->toRfc4122() . $extension;
//        while (File::where('name', $fileName)->exists()) {
//            $fileName = Str::ulid()->toRfc4122() . $extension;
//        }

        $config = [
            'projectid' => config('filesystems.disks.gcs.project_id'),
            'keyFile' => json_decode(file_get_contents(config('filesystems.disks.gcs.key_file_path')), true),
        ];
        $storage = new StorageClient($config);
        $bucket = $storage->bucket(config('filesystems.disks.gcs.bucket'));
        $object = $bucket->object("temp/" . $fileName);

        $url = $object->signedUrl(new DateTime('5 min'), [
            'method'      => 'PUT',
            'contentType' => $request->get('contentType'),
            'version'     => 'v4',
            'headers'     => [
                'x-goog-acl' => 'public-read'
            ],
        ]);

        return [
            'url'  => $url,
            'name' => $fileName,
        ];
    }
}
