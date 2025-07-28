<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            // Add new columns after the existing ones
            $table->enum('type', ['lesson', 'video', 'document', 'assignment', 'quiz', 'link'])->after('title');
            $table->text('description')->nullable()->after('type');
            $table->longText('content')->nullable()->after('description');
            $table->string('file_path')->nullable()->after('content');
            $table->string('file_type')->nullable()->after('file_path');
            $table->integer('file_size')->nullable()->after('file_type');
            $table->integer('order')->default(0)->after('file_size');
            $table->boolean('is_published')->default(false)->after('order');
            $table->json('settings')->nullable()->after('is_published');
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn([
                'type', 'description', 'content',
                'file_path', 'file_type', 'file_size',
                'order', 'is_published', 'settings'
            ]);
        });
    }
};
