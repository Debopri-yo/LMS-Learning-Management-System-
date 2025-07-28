<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentFile extends Model
{
     protected $fillable = ['content_id', 'original_name', 'file_name', 'file_path', 'mime_type', 'file_size'];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function getUrl()
    {
        return Storage::url($this->file_path);
    }

    public function getFormattedSize()
    {
        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
}
