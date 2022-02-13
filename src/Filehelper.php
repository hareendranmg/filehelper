<?php

namespace Keltron\Filehelper;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Keltron\Filehelper\Models\FilehelperModel;

class Filehelper
{
    /**
     * Insert a file into the storage.
     *
     * @param string $folder The folder to store the file. If the folder does not exist, it will be created.
     * @param \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string $file The file to store. If the file is a string, it will be converted to a file.
     * @param string $file_name (optional) The name of the file. If the file name is not provided, the file name will be the original file name.
     * @param array $file_types (optional) File types to be accepted. If not provided, image, pdf and doc files will be accepted. Example: ['image', 'pdf']. Default: ['image', 'pdf', 'doc']
     * @param array $max_file_size (optional) File size to be accepted. If not provided, max_file_size parameter in filehelper config file will be used.
     *
     * @return array The file information.['status' => true|false, 'message' => '', 'file_name' => '', 'file_path' => '', 'file_url' => '']
     *
     */

    public static function putFile($folder, $file, $file_name = '', $file_types = ['image', 'pdf', 'doc'], $max_file_size = 0): array
    {
        try {

            $max_file_size = ($max_file_size == 0) ? (int) config('filehelper.max_upload_filesize') : $max_file_size;
            $file_size = $file->getSize();

            if ($file_size > $max_file_size) {

                return [
                    'status' => false,
                    'message' => 'File size exceeds maximum allowed file size',
                ];

            } else {

                $org_filename = $file->getClientOriginalName();
                $file_extension = $file->getClientOriginalExtension();
                $path = realpath($file);
                $file_mime_type = mime_content_type($path);

                $file_type_res = self::checkFileType($file, $file_extension, $file_mime_type, $file_types);

                if ($file_type_res['status'] == true) {

                    $created_by = (session()->get('userid')) ? session()->get('userid') : 0; // 0 => if the file uploaded by any unlogged user

                    $file_name = ($file_name == '') ? $org_filename : $file_name . '.' . $file_extension;
                    $path = Storage::putFileAs($folder, $file, $file_name);

                    $data = [
                        'file_name' => $file_name,
                        'folder' => $folder,
                        'file_path' => $path,
                        'mime_type' => $file_mime_type,
                        'file_extension' => $file_extension,
                        'original_file_name' => $org_filename,
                        'is_valid' => 1,
                        'is_public' => 1,
                        'created_by' => $created_by,
                        'updated_by' => $created_by,
                    ];

                    $file_det = FileHelperModel::create($data);

                    if ($file_det) {

                        $encrypted_file_id = encrypt($file_det->id);

                        $url = url('/files/get_file?file_id=' . $encrypted_file_id);

                        return [
                            'status' => true,
                            'file_id' => $file_det->id,
                            'message' => 'File uploaded successfully',
                            'url' => $url,
                            'file_name' => $file_name,
                        ];
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Server error occured. Please try again',
                        ];
                    }

                } else {

                    return [
                        'status' => false,
                        'message' => $file_type_res['message'],
                    ];

                }
            }
        } catch (\Throwable $th) {

            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];

        }
    }

    /**
     * Get a file from the storage by file id.
     *
     * @param string $encrypted_file_id The encrypted file id.
     * @param int $get_type (optional) If get_type is 0 it will return file response, If get_type is 1 the file is forcefully download. By default get_type is 0
     * @param string $file_extension (optional) The file extension. If the file extension is not provided, the file extension will be the original file extension.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public static function getFile($encrypted_file_id, $get_type = 0)
    {

        try {

            $file_id = decrypt($encrypted_file_id);

            $file = FileHelperModel::find($file_id);

            if ($file) {

                if ($file->is_valid) {

                    if ($get_type == 0) {
                        $file_content = Storage::get($file->file_path);
                        $file = Response::make($file_content, '200', array(
                            'Content-Type' => $file->mime_type,
                            'Content-Disposition' => 'inline; filename="' . $file->file_name . '"',
                        ));
                        return $file;
                    } else {
                        return Storage::download($file->file_path, $file->file_name);
                    }

                } else {
                    return response()->file(public_path('keltron/filehelper/img/file_not_found.jpg'));
                }
            } else {
                return response()->file(public_path('keltron/filehelper/img/file_not_found.jpg'));
            }

        } catch (\Throwable $th) {

            return response()->file(public_path('keltron/filehelper/img/file_not_found.jpg'));

        }
    }

    /**
     * Get a file from the storage by file path.
     *
     * @param string $encrypted_file_path The encrypted file path.
     * @param int $get_type (optional) If get_type is 0 it will return file response, If get_type is 1 the file is forcefully download. By default get_type is 0
     *
     * @return \Illuminate\Http\Response
     *
     */

    public static function getFileFromPath($encrypted_file_path, $get_type = 0)
    {

        try {

            $file_id = FileHelperModel::where('file_path', base64_decode($encrypted_file_path))->value('id');
            return self::getFile(encrypt($file_id), $get_type);

        } catch (\Throwable $th) {

            return response()->file(public_path('keltron/filehelper/img/file_not_found.jpg'));

        }
    }

    /**
     * Get information of the file by file id.
     *
     * @param string $encrypted_file_id The encrypted file id.
     *
     * @return array [
     *  'status' => true/false,
     * ]
     *
     */

    public static function getFileInfo($encrypted_file_id): array
    {
        try {
            $file_id = decrypt($encrypted_file_id);

            $file = FileHelperModel::find($file_id);

            if ($file) {
                if ($file->is_valid) {
                    return [
                        'status' => true,
                        'file_name' => $file->file_name,
                        'folder' => $file->folder,
                        'file_path' => $file->file_path,
                        'mime_type' => $file->mime_type,
                        'file_extension' => $file->file_extension,
                        'original_file_name' => $file->original_file_name,
                        'is_valid' => $file->is_valid,
                        'is_public' => $file->is_public,
                        'created_by' => $file->created_by,
                        'updated_by' => $file->updated_by,
                        'url' => url('files/get_file?file_id=' . $encrypted_file_id),
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'Validity of the requested file is expired. ',
                        'error_url' => url('files/get_file?file_id=' . $encrypted_file_id),
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'message' => 'The requested file is not available',
                    'error_url' => url('files/get_file?file_id=' . $encrypted_file_id),
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
                'error_url' => url('files/get_file?file_id=' . $encrypted_file_id),
            ];
        }
    }

    /**
     * Get file url from encrypted file id.
     *
     * @param string $encrypted_file_id The encrypted file id.
     *
     * @return string The file url.
     *
     */

    public static function getFileUrl($encrypted_file_id): string
    {
        try {
            return url('files/get_file?file_id=' . $encrypted_file_id);
        } catch (\Throwable $th) {
            return url('files/get_file?file_id=' . $encrypted_file_id);
        }
    }

    public static function getFileBinary($encrypted_file_id): string
    {
        try {
            $file_id = decrypt($encrypted_file_id);

            $file = FileHelperModel::find($file_id);

            return Storage::get($file->file_path);

        } catch (\Throwable $th) {
            return Storage::get(public_path('keltron/filehelper/img/file_not_found.jpg'));
        }
    }

    /**
     * Delete the file by file id.
     *
     * @param string $encrypted_file_id The encrypted file id.
     *
     * @return array [
     *  'status' => true/false,
     * ]
     *
     */
    public static function deleteFile($encrypted_file_id): array
    {
        try {
            $file_id = decrypt($encrypted_file_id);

            $destroyed = FileHelperModel::destroy($file_id);

            if ($destroyed) {
                return ([
                    'status' => true,
                    'message' => 'File removed successfully',
                ]);
            } else {
                return ([
                    'status' => false,
                    'message' => 'Failed to remove file.',
                ]);
            }
        } catch (\Throwable $th) {
            return ([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public static function checkFileType($file, $file_extension, $file_mime_type, $file_types): array
    {
        try {

            $file_types_array = [
                'png' => ['image', 'image/png'],
                'jpe' => ['image', 'image/jpeg'],
                'jpeg' => ['image', 'image/jpeg'],
                'jpg' => ['image', 'image/jpeg'],
                'gif' => ['image', 'image/gif'],
                'bmp' => ['image', 'image/bmp'],
                'ico' => ['image', 'image/vnd.microsoft.icon'],
                'svg' => ['image', 'image/svg+xml'],
                'svgz' => ['image', 'image/svg+xml'],

                // pdf
                'pdf' => ['pdf', 'application/pdf'],

                // ms office
                'doc' => ['doc', 'application/msword'],
                'docx' => ['doc', 'application/msword'],
                // open office
                'odt' => ['doc', 'application/vnd.oasis.opendocument.text'],

                // excell
                'xls' => ['excel', 'application/vnd.ms-excel'],
                'xlsx' => ['excel', 'application/vnd.ms-excel'],
                // open office
                'ods' => ['excel', 'application/vnd.oasis.opendocument.spreadsheet'],

            ];

            $file_extension = strtolower($file_extension);

            if (isset($file_types_array[$file_extension])) {
                $file_type_det = $file_types_array[$file_extension];
                if (in_array($file_type_det[0], $file_types)) {
                    if ($file_type_det[1] == $file_mime_type) {
                        return [
                            'status' => true,
                        ];
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Invalid mime type',
                        ];
                    }
                } else {
                    return [
                        'status' => false,
                        'message' => 'Invalid file type is passed',
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'message' => 'Invalid file extension is given',
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage(),
            ];
        }
    }
}
