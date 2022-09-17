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
    
    public function getUrlAttribute()
    {
        return url('files/get_file?file_id=' . encrypt($this->id));
    }

    public function getDownloadUrlAttribute()
    {
        return url('files/get_file?file_id=' . encrypt($this->id) . '&get_type=1');
    }

    // append attributes to the response
    protected $appends = [
        'url',
        'download_url',
    ];
}
