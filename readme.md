# Filehelper


<p align="center">
<a href="https://packagist.org/packages/keltron/filehelper"><img src="https://img.shields.io/packagist/dt/keltron/filehelper" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/keltron/filehelper"><img src="https://img.shields.io/packagist/v/keltron/filehelper" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/keltron/filehelper"><img src="https://img.shields.io/packagist/l/keltron/filehelper" alt="License"></a>
</p>

## Installation

Via Composer

``` bash
composer require keltron/filehelper
```
```bash
php artisan vendor:publish --tag=migration
```
```bash
php artisan vendor:publish --tag=filehelper.config
```

## Usage

### Keltron\Filehelper\Filehelper::putFile
#### Insert a file into the storage.


``` php

public static function putFile(
    $folder,
    $file,
    $file_name = '',
    $file_types = ['image', 'pdf', 'doc'],
    $max_file_size = 0
) { }

```

``` java
@param string $folder
The folder to store the file. If the folder does not exist, it will be created.

@param \Illuminate\Http\File|\Illuminate\Http\UploadedFile|string $file
The file to store. If the file is a string, it will be converted to a file.

@param string $file_name
(optional) The name of the file. If the file name is not provided, the file name will be the original file name.

@param array $file_types
(optional) File types to be accepted. If not provided, image, pdf and doc files will be accepted. Example: ['image', 'pdf']. Default: ['image', 'pdf', 'doc']

@param array $max_file_size
(optional) File size to be accepted. If not provided, max_file_size parameter in filehelper config file will be used.

@return array
The file information.['status' => true|false, 'message' => '', 'file_name' => '', 'file_path' => '', 'file_url' => '']

```

### Keltron\Filehelper\Filehelper::getFile

#### Get a file from the storage by file id.

``` php

public static function getFile($encrypted_file_id, $get_type = 0) { }

```

``` java
@param string $encrypted_file_id — The encrypted file id.

@param int $get_type
(optional) If get_type is 0 it will return file response, If get_type is 1 the file is forcefully download. By default get_type is 0

@param string $file_extension
(optional) The file extension. If the file extension is not provided, the file extension will be the original file extension.

@return \Illuminate\Http\Response

```

### Keltron\Filehelper\Filehelper::getFileFromPath

#### Get a file from the storage by file path.

``` php

public static function getFileFromPath($encrypted_file_path, $get_type = 0) { }

```

``` java
@param string $encrypted_file_path — The encrypted file path.

@param int $get_type
(optional) If get_type is 0 it will return file response, If get_type is 1 the file is forcefully download. By default get_type is 0

@return \Illuminate\Http\Response
```

### Keltron\Filehelper\Filehelper::getFileInfo

#### Get information of the file by file id.
 ``` php

public static function getFileInfo($encrypted_file_id) { }

```

``` java
@param string $encrypted_file_id — The encrypted file id.

@return array — [ 'status' => true/false, ]
```

### Keltron\Filehelper\Filehelper::getFileBinary
 
 ``` php

public static function getFileBinary($encrypted_file_id) { }

```

``` java
@param mixed $encrypted_file_id

@return string
```

### Keltron\Filehelper\Filehelper::deleteFile

#### Delete the file by file id.

``` php

public static function deleteFile($encrypted_file_id) { }

```

``` java
@param string $encrypted_file_id — The encrypted file id.

@return array — [ 'status' => true/false, ]

```
## Helpers (Can use in blade and use without namespace in controller)
### Can call from any blade or any controller
``` php
put_file($folder, $file, $file_name = '', $file_types = ['image', 'pdf', 'doc'], $max_file_size = 0)

get_file($encrypted_file_id, $get_type = 0)

get_file_from_path($encrypted_file_path, $get_type = 0)

get_file_info($encrypted_file_id)

get_file_binary($encrypted_file_id)

delete_file($encrypted_file_id)
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email  instead of using the issue tracker.

## Credits
- <a href="https://hareendran.ml">Hareendran M G</a>


## License

Please see the [license file](license.md) for more information.

