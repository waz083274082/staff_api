<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id(); // Automatically creates an auto-incrementing UNSIGNED BIGINT (primary key) named `id`
            $table->string('email')->unique(); // Email column that must be unique
            $table->string('password'); // Password column
            $table->string('first_name'); // First name column
            $table->string('last_name'); // Last name column
            $table->enum('status', ['Active', 'Inactive']); // Status column with specified enum values
            $table->enum('squad', ['squad1', 'squad2', 'squad3', 'squad4', 'squad5', 'NA']); // Squad column with specified enum values
            $table->date('start_date'); // Start date column
            $table->text('notes')->nullable(); // Notes column, which is optional (nullable)
            $table->timestamps(); // Creates `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
