<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Model for the file element. It represents how the representation of an uploaded file should look like
class File extends Model
{
    public $incrementing = false;

    // Set the primary key and define a type of that key
    protected $primaryKey = 'file_link';
    protected $keyType = 'string';

    // Define all the fields that are fillable and therefore can be changed in the Controllers
    protected $fillable = ['file_link', 'admin_link', 'file_storage_path', 'original_name', 'extension', 'number_of_downloads', 'delete_date'];
    use HasFactory;
}
