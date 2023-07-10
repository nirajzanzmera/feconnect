<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ListSettingsTest extends DuskTestCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $browser->visit('/lists');

            // Confirm login
            if($browser->assertPathIs('/login')) {
                $browser->value('#email', env('TEST_EMAIL'))
                    ->value('#password', env('TEST_PASSWORD'))
                    ->click('button[type="submit"]');
                // End login
            }

        });
    }

    public function testList()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/lists/14018/settings')
                ->assertPathIs('/lists/14018/settings');
        });
    }
}
