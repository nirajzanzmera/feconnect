<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WebTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function test_login()  // LOGIN
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')               
                ->assertSee('E-Mail Address')
                ->type('#email', env('TEST_EMAIL'))        
                ->type('#password', env('TEST_PASSWORD'))
                ->press('Login')
                ->pause(2000)
                ->assertPathIs('/');                
        });
    }


    public function test_dashboard()  // DASHBOARD
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Dashboard');
        });
    }

    public function test_websites()  // WEBSITE
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/websites')
                ->assertPathIs('/websites')
                ->assertSee('Website');
        });
    }
}
