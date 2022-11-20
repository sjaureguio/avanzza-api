<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\File;
use App\Models\User;
use Tests\TestCase;

class FileTest extends TestCase
{
    /** @test */
    public function testGetAllFiles()
    {
        $login_resp = $this->post('/api/v1/login', [
            'email' => "admin@gmail.com",
            'password' => "123456",
        ]);

        $login_resp->assertStatus(200);

        $token = $login_resp['data']['token'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->get('/api/v1/files');

        $response->assertStatus(200);
    }

    /** @test */
    public function testFileUpload()
    {
        $login_resp = $this->post('/api/v1/login', [
            'email' => "admin@gmail.com",
            'password' => "123456",
        ]);

        $login_resp->assertStatus(200);

        $token = $login_resp['data']['token'];

        Storage::fake('files');

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->post('/api/v1/files', [
            'files' => [
                UploadedFile::fake()->image('fakeimage.jpg')
            ]
        ]);

        // $this->assertCount(1, File::all());

        $response->assertCreated();
    }

    /** @test */
    public function testFileSoftDelete()
    {
        $login_resp = $this->post('/api/v1/login', [
            'email' => "admin@gmail.com",
            'password' => "123456",
        ]);

        $login_resp->assertStatus(200);

        $token = $login_resp['data']['token'];

        Storage::fake('files');

        $file = File::first();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->delete('/api/v1/files/soft-delete/'. $file->id);

        $response->assertStatus(204);
    }
    
    /** @test */
    public function testFileDestroy()
    {
        $login_resp = $this->post('/api/v1/login', [
            'email' => "admin@gmail.com",
            'password' => "123456",
        ]);

        $login_resp->assertStatus(200);

        $token = $login_resp['data']['token'];

        Storage::fake('files');

        $file = File::first();

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->delete('/api/v1/files/destroy/'. $file->id);

        $response->assertStatus(204);
    }
}
