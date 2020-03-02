<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSeriesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_series()
    {
        Storage::fake(config('filesystems.default'));

        $this->post('/admin/series', [
            'title' => 'The Title',
            'description' => 'The Description',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertRedirect()
        ->assertSessionHas('success', 'Series created successfully');

        Storage::disk(config('filesystems.default'))->assertExists(
            'series/' . Str::slug('The Title') . '.png'
        );

        $this->assertDatabaseHas('series', [
            'slug' => Str::slug('The Title')
        ]);
    }

    public function test_series_has_validation()
    {
        $this->post('/admin/series', [
            'title' => 'The Title',
            'description' => 'The Description',
        ])->assertSessionHasErrors('image');
    }
}
