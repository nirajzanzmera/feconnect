<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WebsitePageTest extends DuskTestCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $browser->visit('/websites/13294/pages');

            // Confirm login
            if($browser->assertPathIs('/login')) {
                $browser->value('#email', env('TEST_EMAIL'))
                    ->value('#password', env('TEST_PASSWORD'))
                    ->click('button[type="submit"]');
                // End login
            }

//            $browser->assertPathIs('/websites/13294/pages')
//                ->clickLink('Create Blank Page');

        });
    }

    public function testWebsite()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/websites/13294/pages')
                ->assertPathIs('/websites/13294/pages');
        });
    }
}
