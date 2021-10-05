<?php

namespace Keltron\Filehelper\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilehelperModel extends Model
{
    use SoftDeletes;

    protected $table = 'filehelper';

    protected $primaryKey = 'id';

    protected $fillable = [
        'file_name',
        'folder',
        'file_path',
        'mime_type',
        'file_extension',
        'original_file_name',
        'is_valid',
        'is_public',
        'created_by',
        'updated_by',
    ];
}
