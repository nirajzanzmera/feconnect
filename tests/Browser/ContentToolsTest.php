<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContentToolsTest extends DuskTestCase
{
    public function setup(): void
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $browser->visit('/content');

            // Confirm login
            if($browser->assertPathIs('/login')) {
                $browser->value('#email', env('TEST_EMAIL'))
                    ->value('#password', env('TEST_PASSWORD'))
                    ->click('button[type="submit"]');
                // End login
            }

        });
    }

    public function testExample()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/content/content-tools')
                ->assertPathIs('/content/content-tools');
        });
    }

}
