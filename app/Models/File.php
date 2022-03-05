<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = ['file_link', 'admin_link', 'file_storage_path', 'original_name', 'extension', 'number_of_downloads', 'delete_date'];
    use HasFactory;
}
