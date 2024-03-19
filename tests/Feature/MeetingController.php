<?php

use App\Models\Meeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('index method returns all meetings', function () {
    // Given we have meetings
    $meetings = Meeting::factory()->count(5)->create();

    // When we hit the meeting index route
    $response = get(route('meeting.index'));

    // We should receive a 200 OK
    $response->assertStatus(200);

    // We get all meetings
    $response->assertJson($meetings->toArray());
});

it('store method validates inputs and creates new meeting', function () {
    // Create a valid request data
    $requestData = [
        'room_id' => 1,
        'start_time' => '2023-01-31 09:00:00',
        'end_time' => '2023-01-31 11:00:00',
    ];

    // Ensure meeting does not exist prior to test
    $this->assertDatabaseMissing('meetings', $requestData);

    // When we hit the store route
    $response = $this->json('POST', route('meeting.store'), $requestData);

    // We receive a 201 Created
    $response->assertStatus(201);

    // And the meeting was stored in the database
    $this->assertDatabaseHas('meetings', $requestData);
});

it('update method updates an existing meeting', function () {
    // Given we have a meeting
    $meeting = Meeting::factory()->create();

    // And new valid request data
    $requestData = [
        'room_id' => 2,
        'start_time' => '2023-02-10 10:00:00',
        'end_time' => '2023-02-10 12:00:00',
    ];

    // When we hit the update route
    $response = $this->json('PUT', route('meeting.update', $meeting->id), $requestData);

    // We should receive a 200 OK
    $response->assertStatus(200);

    // And the meeting was updated in the database
    $this->assertDatabaseHas('meetings', $requestData);
});

it('destroy method removes a meeting', function () {
    // Given we have a meeting
    $meeting = Meeting::factory()->create();

    // When we hit the destroy route
    $response = $this->json('DELETE', route('meeting.destroy', $meeting->id));

    // We should receive a 204 No Content
    $response->assertStatus(204);

    // And the meeting is absent in the database
    $this->assertDatabaseMissing('meetings', ['id' => $meeting->id]);
});
