<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserHasAProfile()
    {
        $user = create('App\User');

        $this->get('/profile/' . $user->name)
            ->assertSee($user->name);
    }
}
