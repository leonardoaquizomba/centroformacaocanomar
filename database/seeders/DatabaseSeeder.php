<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CourseCategorySeeder::class,
            CourseSeeder::class,
            CourseClassSeeder::class,   // teachers + classes + schedules
            PostCategorySeeder::class,
            BlogSeeder::class,
            TestimonialSeeder::class,
            StudentSeeder::class,       // students + enrollments + payments + certificates
        ]);
    }
}
