<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User; // Import User model if you need to populate data

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new columns after the 'id' column (or choose another position)
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');

            // Optional: If you want to try and populate existing data
            // This is a basic split, adjust logic if needed
            // Consider running this logic in a separate script/seeder for large datasets
            // User::whereNotNull('name')->get()->each(function ($user) {
            //     $parts = explode(' ', $user->name, 2);
            //     $user->first_name = $parts[0];
            //     $user->last_name = $parts[1] ?? ''; // Handle cases with no space
            //     $user->saveQuietly(); // Avoid triggering events
            // });

             // Make the original name column nullable temporarily if migrating data
            // $table->string('name')->nullable()->change();
        });

        // Optional: Second step to remove the original name column after data migration
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('name');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the name column back if it was removed
            // $table->string('name')->after('id');

            // Optional: Repopulate the name column if needed
            // User::all()->each(function ($user) {
            //     $user->name = trim($user->first_name . ' ' . $user->last_name);
            //     $user->saveQuietly();
            // });

            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};