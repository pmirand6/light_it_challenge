<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }
    /**
     * A basic feature test example.
     */
    public function test_data_required_validation(): void
    {
        $response = $this->post('/api/v1/patients', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'email',
                    'phone_number',
                    'identification_photo',
                ],
            ]);
    }

    public function test_can_create_a_new_record():void
    {
        $file = UploadedFile::fake()->image('image.png');

        $request = $this->post('/api/v1/patients', [
            'name' => 'Phil Colling',
            'email' => 'pcolling@gmail.com',
            'phone_number' => '541132556688',
            'identification_photo' => $file,
        ]);

        $request->assertStatus(201);
    }

    public function test_duplicate_email():void
    {
        $file = UploadedFile::fake()->image('image.png');

        $request = $this->post('/api/v1/patients', [
            'name' => 'Phil Colling',
            'email' => 'pcolling@gmail.com',
            'phone_number' => '541132556688',
            'identification_photo' => $file,
        ]);

        $request = $this->post('/api/v1/patients', [
            'name' => 'Phil Colling',
            'email' => 'pcolling@gmail.com',
            'phone_number' => '541132556688',
            'identification_photo' => $file,
        ]);

        $request->assertStatus(422);
    }

    public function test_reject_invalid_file():void
    {
        $file = UploadedFile::fake()->image('image.txt');

        $request = $this->post('/api/v1/patients', [
            'name' => 'Phil Colling',
            'email' => 'pcolling@gmail.com',
            'phone_number' => '541132556688',
            'identification_photo' => $file,
        ]);

        $request
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'identification_photo',
                ],
            ]);
    }


}
