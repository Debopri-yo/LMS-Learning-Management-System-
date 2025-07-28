<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stream_id',
        'start_date',
        'end_date',
        'teacher_id',
        'is_active',
        'type',
        'price',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'integer',
    ];


    // Relationships
    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function publishedContents()
    {
        return $this->hasMany(Content::class)->where('is_published', true)->orderBy('order');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    // Query scopes for free and paid courses
    public function scopeFree($query)
    {
        return $query->where('type', 'free');
    }

    public function scopePaid($query)
    {
        return $query->where('type', 'paid');
    }

    // Accessor for 'type'
    public function getTypeDisplayAttribute()
    {
        return ucfirst($this->type);
    }
}
