<?php

namespace Tests\Feature;

use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function store_creates_device_and_returns_success()
    {
        $response = $this->postJson('/api/v1/devices', [
            'name'          => 'Test Device',
            'serial_number' => 'ABC123',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('devices', [
            'name'          => 'Test Device',
            'serial_number' => 'ABC123',
        ]);
    }

    /** @test */
    public function destroy_deletes_device_and_returns_success()
    {
        $device = Device::factory()->create();

        $response = $this->deleteJson("/api/v1/devices/{$device->id}");

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseMissing('devices', [
            'id' => $device->id,
        ]);
    }

    /** @test */
    public function attachDevice_attaches_device_to_user_and_returns_success()
    {
        $device = Device::factory()->create();

        $response = $this->postJson("/api/v1/users/{$this->user->id}/devices/{$device->id}/attach");

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this
            ->assertTrue($this->user->devices()
            ->where('device_id', $device->id)->exists());
    }

    /** @test */
    public function detachDevice_detaches_device_from_user_and_returns_success()
    {
        $device = Device::factory()->create();
        $this->user->devices()->attach($device->id);

        $response = $this->deleteJson("/api/v1/users/{$this->user->id}/devices/{$device->id}/detach");

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertFalse($this->user->devices()->where('device_id', $device->id)->exists());
    }
}
