<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        (new \Database\Seeders\DatabaseSeeder())->callWith(\Database\Seeders\CartSeeder::class);
    }
}