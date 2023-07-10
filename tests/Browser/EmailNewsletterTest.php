<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EmailNewsletterTest extends DuskTestCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $browser->visit('/emails/newsletters');

            // Confirm login
            if($browser->assertPathIs('/login')) {
                $browser->value('#email', env('TEST_EMAIL'))
                    ->value('#password', env('TEST_PASSWORD'))
                    ->click('button[type="submit"]');
                // End login
            }

//            $browser->assertPathIs('/emails/newsletters')
//                ->clickLink('Get Started...');

        });
    }

    public function testEmail()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/emails/newsletters')
                ->assertPathIs('/emails/newsletters');
        });
    }
}
