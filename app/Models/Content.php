<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body', 'course_id', 'teacher_id','type', 'description', 'content',
        'file_path', 'file_type', 'file_size', 'order', 'is_published', 'settings'];
    protected $casts = [
        'is_published' => 'boolean',
        'settings' => 'array',
    ];
    public function files()
    {
        return $this->hasMany(ContentFile::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function getFileUrl()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
