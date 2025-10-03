<?php

namespace Tests\Feature;

use App\Http\Controllers\DeviceController;
use App\Http\Requests\Devices\AttachOrDetachDeviceRequest;
use App\Http\Requests\Devices\CreateDeviceRequest;
use App\Http\Requests\Devices\DeleteDeviceRequest;
use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected DeviceController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user       = User::factory()->create();
        $this->controller = new DeviceController();
    }

    /** @test */
    public function store_creates_device()
    {
        $request = new CreateDeviceRequest([
            'name'          => 'Device 1',
            'serial_number' => 'ABC123',
        ]);

        $response = $this->controller->store($request);

        $this->assertDatabaseHas('devices', [
            'name'          => 'Device 1',
            'serial_number' => 'ABC123',
        ]);

        $this->assertEquals('success', $response->getData()->status);
    }

    /** @test */
    public function destroy_deletes_device()
    {
        $device = Device::factory()->create();

        $request = new DeleteDeviceRequest(['id' => $device->id]);

        $response = $this->controller->destroy($request);

        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
        $this->assertEquals('success', $response->getData()->status);
    }

    /** @test */
    public function attach_device_to_user()
    {
        $device = Device::factory()->create();

        $request = new AttachOrDetachDeviceRequest([
            'user_id'   => $this->user->id,
            'device_id' => $device->id,
        ]);

        $response = $this->controller->attachDevice($request);

        $this->assertTrue($this->user->devices()->where('device_id', $device->id)->exists());
        $this->assertEquals('success', $response->getData()->status);
    }

    /** @test */
    public function detach_device_from_user()
    {
        $device = Device::factory()->create();
        $this->user->devices()->attach($device->id);

        $request = new AttachOrDetachDeviceRequest([
            'user_id'   => $this->user->id,
            'device_id' => $device->id,
        ]);

        $response = $this->controller->detachDevice($request);

        $this->assertFalse($this->user->devices()->where('device_id', $device->id)->exists());
        $this->assertEquals('success', $response->getData()->status);
    }
}
