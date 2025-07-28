<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Stream;

class StreamSeeder extends Seeder
{
    public function run()
    {
        $streams = [
            ['name' => 'Computer Science Engineering', 'description' => 'Focuses on computing, programming, and algorithms.'],
            ['name' => 'Electrical Engineering', 'description' => 'Deals with electrical systems, power, and circuits.'],
            ['name' => 'Information Technology', 'description' => 'Covers networking, databases, and information systems.'],
            ['name' => 'Mechanical Engineering', 'description' => 'Emphasizes mechanics, thermodynamics, and machines.'],
            ['name' => 'Civil Engineering', 'description' => 'Specializes in construction, structures, and infrastructure.'],
            ['name' => 'Electronics and Communication Engineering', 'description' => 'Focuses on electronic systems and telecommunications.'],
        ];

        foreach ($streams as $stream) {
            Stream::create($stream);
        }
    }
}

