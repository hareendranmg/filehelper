<?php

use Keltron\Filehelper\Filehelper;

if (!function_exists('put_file')) {
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

    function put_file($folder, $file, $file_name = '', $file_types = ['image', 'pdf', 'doc'], $max_file_size = 0)
    {
        return Filehelper::putFile($folder, $file, $file_name, $file_types, $max_file_size);
    }
}

if (!function_exists('get_file')) {
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

    function get_file($encrypted_file_id, $get_type = 0)
    {
        return Filehelper::getFile($encrypted_file_id, $get_type);
    }
}

if (!function_exists('get_file_from_path')) {
    /**
     * Get a file from the storage by file path.
     *
     * @param string $encrypted_file_path The encrypted file path.
     * @param int $get_type (optional) If get_type is 0 it will return file response, If get_type is 1 the file is forcefully download. By default get_type is 0
     *
     * @return \Illuminate\Http\Response
     *
     */

    function get_file_from_path($encrypted_file_path, $get_type = 0)
    {
        return Filehelper::getFileFromPath($encrypted_file_path, $get_type);
    }
}

if (!function_exists('get_file_info')) {
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

    function get_file_info($encrypted_file_id)
    {
        return Filehelper::getFileInfo($encrypted_file_id);

    }
}

if (!function_exists('get_file_url')) {
    /**
     * Get a file from the storage by file path.
     *
     * @param string $encrypted_file_path The encrypted file path.
     *
     * @return string The file url.
     *
     */

    function get_file_url($encrypted_file_path)
    {
        return Filehelper::getFileUrl($encrypted_file_path);
    }
}

if (!function_exists('get_file_binary')) {

    function get_file_binary($encrypted_file_id)
    {
        return Filehelper::getFileBinary($encrypted_file_id);
    }
}

if (!function_exists('delete_file')) {
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

    function delete_file($encrypted_file_id)
    {
        return Filehelper::deleteFile($encrypted_file_id);

    }
}
