<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Database\Seeders\PermissionsDemoSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class rolesIssueTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The seeder has created a user with a single role "writer" and other roles
     * In certain conditions where a relationship is retrieved in a controller the user returns every role
     *
     * @return void
     */
    public function test_example()
    {
        app(DatabaseSeeder::class)->call(PermissionsDemoSeeder::class);

        $user = User::find(1); //Role: writer
        
        $this->be($user);

        list($rolesBefore, $rolesAfter) = $this->get('/test')->json();

        $this->assertCount(1,$rolesBefore);
        $this->assertCount(1,$rolesAfter);
        $this->assertEquals($rolesBefore[0]["name"], "writer");
        $this->assertEquals($rolesAfter[0]["name"], "writer");

    }
}
