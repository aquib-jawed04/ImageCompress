<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    protected $table = 'image_uploads';
    public $primarykey = 'id';
    public $timestamp = true;
}
