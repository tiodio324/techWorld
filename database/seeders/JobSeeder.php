<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load job listings from file
        $jobListings = include database_path('seeders/data/job_listings.php');

        // Get test and admin user id
        $testUserId = User::where('email', 'test@example.com')->value('id');
        $adminUserId = User::where('email', 'admin@gmail.com')->value('id');

        // Get all other user ids from user model
        $userIds = User::whereNotIn('email', ['test@example.com', 'admin@gmail.com'])->pluck('id')->toArray();

        foreach($jobListings as $index => &$listing) {
            if ($index === 0) {
                // Assign first listings to the admin user
                $listing['user_id'] = $adminUserId;
            } else if ($index === 1) {
                // Assign second listings to the test user
                $listing['user_id'] = $testUserId;
            } else {
                // Asign user id to listing
                $listing['user_id'] = $userIds[array_rand($userIds)];
            }

            // Add timestamps
            $listing['created_at'] = now();
            $listing['updated_at'] = now();
        }

        // Insert job listings
        DB::table('job_listings')->insert($jobListings);
        echo "Jobs created successfully!";
    }
}
