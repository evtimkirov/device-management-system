<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Device;
use App\Models\Measurement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeasurementModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to get the available measurements by device and per user
     *
     * @test
     * @return void
     */
    public function it_returns_devices_with_measurements(): void
    {
        $user = User::factory()->create();
        $device = Device::factory()->create();

        $user->devices()->attach($device->id);

        $m1 = Measurement::factory()->create([
            'device_id'   => $device->id,
            'temperature' => 20,
            'measured_at' => now()->subHour(),
        ]);

        $m2 = Measurement::factory()->create([
            'device_id'   => $device->id,
            'temperature' => 25,
            'measured_at' => now(),
        ]);

        $result = Measurement::getMeasurementsByDevices($user->id);

        $this->assertCount(1, $result);

        $deviceData = $result->first();
        $this->assertEquals($device->name, $deviceData['device_name']);

        $measurements = $deviceData['measurements'];
        $this->assertCount(2, $measurements);

        $this->assertEquals($m2->temperature, $measurements[0]['temperature']);
        $this->assertEquals($m1->temperature, $measurements[1]['temperature']);
    }
}
