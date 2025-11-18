<?php

use App\Models\User;

it('shows the user list with table data', function () {
    $viewer = User::factory()->create();
    $listedUsers = User::factory()->count(3)->create();

    $response = $this->actingAs($viewer)->get(route('senarai-user'));

    $response->assertOk();
    $response->assertSeeText('Senarai Pengguna');

    $listedUsers->take(2)->each(function (User $user) use ($response): void {
        $response->assertSeeText($user->name);
        $response->assertSeeText($user->email);
    });
});

