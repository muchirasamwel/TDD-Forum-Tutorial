<?php

namespace Tests\Feature;

use App\Inspections\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SpamTest extends TestCase
{
   use DatabaseMigrations;

    public function test_there_are_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Good reply'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    public function test_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('holding down kkkkkkk');

    }
}
