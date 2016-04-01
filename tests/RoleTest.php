<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoleCreation()
    {
        /** @var App\Role $role */
        $role = factory(App\Role::class)->create();
        $this->assertTrue($role->exists);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDefaultRolesSeeds()
    {
        $this->assertNotNull(\App\Role::whereName('admin')->first());
        $this->assertNotNull(\App\Role::whereName('manager')->first());
    }
}
