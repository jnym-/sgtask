<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeOwnerImportsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    public function test_it_returns_a_validation_error_if_no_file_is_supplied(): void
    {
        $response = $this->postJson(route('home-owners.imports'));

        $response->assertStatus(422);
        $response->assertInvalid(['csv']);
    }

    public function test_it_returns_a_validation_error_if_wrong_file_type_uploaded(): void
    {
        $response = $this->postJson(route('home-owners.imports'), [
            'csv' => UploadedFile::fake()->image('notacsv.jpg'),
        ]);

        $response->assertStatus(422);
        $response->assertInvalid(['csv']);
    }

    public function test_it_returns_a_validation_error_if_file_is_too_large(): void
    {
        $response = $this->postJson(route('home-owners.imports'), [
            'csv' => UploadedFile::fake()->image('test.csv')->size(1025),
        ]);

        $response->assertStatus(422);
        $response->assertInvalid(['csv']);
    }

    public function test_it_parses_a_valid_csv_file(): void
    {
        $csvContent = (string) file_get_contents(__DIR__.'/../fixtures/test-names.csv');

        $response = $this->postJson(route('home-owners.imports'), [
            'csv' => UploadedFile::fake()->createWithContent('test-names.csv', $csvContent),
        ]);

        $response->assertOk();
        $response->assertJsonCount(8, 'names');
    }
}
