<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Staff;

class StaffTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test creating a staff member.
     */
    public function testCreateStaff(): void
    {
        $staffData = [
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'testpassword', // Plain text for testing purposes
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'status' => 'Active',
            'squad' => 'squad1',
            'start_date' => now()->toDateString(),
            'notes' => $this->faker->text,
        ];

        $response = $this->postJson('/api/staff', $staffData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('staff', [
            'email' => $staffData['email'],
            // Don't check the password here as it should be hashed in the database
            'first_name' => $staffData['first_name'],
            'last_name' => $staffData['last_name'],
        ]);
    }

    /**
     * Test retrieving a staff member.
     */
    public function testShowStaff(): void
    {
        // Create a new staff member using the Staff factory
        $staff = Staff::factory()->create();

        // Make a GET request to the API endpoint for showing a single staff member
        $response = $this->getJson("/api/staff/{$staff->id}");

        // Assert the response has a 200 OK status
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $staff->id,
                    'email' => $staff->email,
                    'first_name' => $staff->first_name,
                    'last_name' => $staff->last_name,
                    'status' => $staff->status,
                    'squad' => $staff->squad,
                    'start_date' => $staff->start_date->toJSON(), // Adjusted to match ISO 8601 datetime format
                    'notes' => $staff->notes,
                ]
            ]);

        // Assert the structure of the JSON response matches exactly what is expected
        $response->assertJsonStructure([
            'data' => [
                'id', 'email', 'first_name', 'last_name', 'status', 'squad', 'start_date', 'notes',
            ]
        ]);
    }



    /**
     * Test updating a staff member.
     */
    public function testUpdateStaff(): void
    {
        $staff = Staff::factory()->create();

        $updateData = [
            'first_name' => 'Updated Name',
            'last_name' => 'Updated Last Name',
        ];

        $response = $this->putJson("/api/staff/{$staff->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('staff', [
            'id' => $staff->id,
            'first_name' => $updateData['first_name'],
            'last_name' => $updateData['last_name'],
        ]);
    }

    /**
     * Test deleting a staff member.
     */
    public function testDeleteStaff(): void
    {
        $staff = Staff::factory()->create();

        $response = $this->deleteJson("/api/staff/{$staff->id}");

        $response->assertStatus(204); // No content

        // Ensure the staff record no longer exists in the database
        $this->assertDatabaseMissing('staff', [
            'id' => $staff->id,
        ]);
    }
}
