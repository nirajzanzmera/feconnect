<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateEmailTest extends DuskTestCase
{


    /**
     * Sender Email Address
     *
     * @return void
     * 
     * To be able to schedule email, there is need to create sender email address, through https://connect.dataczar.com/emails/senders, which 
     * the below setup() function will run/check each time you run this test 
     * 
     * Go to your email inbox, to confirm your email before the dusk test get to schedule email page.
     * 
     * Please note, dusk is very fast. 
     * Check if the sender status is active through the aforementioned link for more confirmation
     *
     */

    public function setup(): void
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $browser->visit('/emails/senders');

            // Confirm login
            if($browser->assertPathIs('/login')) {
                $browser->value('#email', env('TEST_EMAIL'))
                        ->value('#password', env('TEST_PASSWORD'))
                        ->click('button[type="submit"]');
                    // End login 
            }                 
                
//            $browser->assertPathIs('/emails/senders')
//                    ->clickLink('Create sender')
//                    ->type('email', env('SENDER_EMAIL'))
//                    ->value('input[name=from_name]', 'Dusk_test')
//                    ->value('#address', env('SENDER_ADDRESS'))
//                    ->value('#city', env('SENDER_CITY'))
//                    ->value('#state', env('SENDER_STATE'))
//                    ->value('#zip', env('SENDER_ZIP_CODE'))
//                    ->value('#country', env('SENDER_COUNTRY'))
//                    ->clickLink('Add Sender')
//                    ->pause(1000);
//            if ($browser->script('return jQuery(".invalid-feedback").html')==null ) {
//                $browser->value('#from_name', 'Dusk_test')
//                        ->clickLink('Add Sender')
//                        ->pause(15000);
//            }
        });
        

    }
    /**
     * A Dusk test example.
     *
     * @return void
     * 
         * You can run this test alone through the command: php artisan --filter CreateEmailTest
     */

    public function testExample() {
//        $this->browse(function (Browser $browser) {
//
//            $browser->visit('/emails')
//                    ->assertPathIs('/emails')
//                    ->click('#btnGroupDrop1')
//                    ->clickLink('Create Blank Email')
//                    ->pause(1000)
//                    ->assertSee('Email Blasts - Create')
//                    ->value('input[name=send_date]', '02/25/2021') //Change date to current or future date
//                    ->value('input[name=send_time]', '11:00 AM') //Change time to future time
//                    ->select('#sender_id')
//                    ->value('input[name="subject"]', 'Email Test Title')
//                    ->driver->executeScript('window.scrollTo(0, 500);');
//
//            $browser->waitFor('#html_ifr')
//                    ->withinFrame('#html_ifr', function($browser) {
//                        $browser->value('p.mceNonEditable', 'Welcome to our Newsletter!');
//                    });
//
//            $browser->click('button[type="submit"]')
//                    ->waitForText('Current Status: Draft', 10)
//                    ->value('#test_email', env('TEST_EMAIL'))
//                    ->click('#send_test_email')
//                    ->waitForText('Message Sent');
//
//            $browser->click('.schedule-btn');
//
//            if ($browser->driver->executeScript('document.querySelector(".alert")') != null) {
//                $browser->driver->executeScript('console.log(document.querySelector(".alert").innerText)');
//            } else {
//                $browser->clickLink('Schedule Send');
//            }
//        });

        $this->browse(function (Browser $browser) {

            $browser->visit('/emails/senders')
                //->clickLink('Create Blank Page')
                ->assertPathIs('/emails/senders');
        });
    }
}
