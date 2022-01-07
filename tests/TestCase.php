<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public $faker;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $this->faker = Faker\Factory::create('fr_GB');
        return require __DIR__.'/../bootstrap/app.php';
    }
}
