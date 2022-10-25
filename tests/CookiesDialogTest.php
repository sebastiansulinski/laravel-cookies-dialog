<?php

namespace SSD\Test;

use Orchestra\Testbench\TestCase;
use SSD\CookiesDialog\ServiceProvider;
use SSD\CookiesDialog\Utilities\Share;

class CookiesDialogTest extends TestCase
{
    protected $enablesPackageDiscoveries = true;

    protected function defineEnvironment($app): void
    {
        $app['config']->set(
            'cookies-dialog',
            require __DIR__.'/../src/CookiesDialog/config/cookies-dialog.php'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function validates_input(): void
    {
        $this->postJson(route('ssd.cookie'))
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'third_party',
            ])
            ->assertCookieMissing('third_party_cookies');

        $this->postJson(route('ssd.cookie'), ['third_party' => 'a'])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'third_party',
            ])
            ->assertCookieMissing('third_party_cookies');
    }

    /**
     * @test
     */
    public function sets_cookie(): void
    {
        $this->postJson(route('ssd.cookie'), ['third_party' => 0])
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertCookie('third_party_cookies', 0);
    }

    /**
     * @test
     */
    public function returns_correct_initial_variables(): void
    {
        $this->assertEquals([
            'showCookiesDialog' => true,
            'thirdPartyCookies' => true,
        ], app(Share::class)->all());
    }

    /**
     * @test
     */
    public function adds_variables_to_share(): void
    {
        Share::set('googleTagID', 123);

        $this->assertEquals([
            'showCookiesDialog' => true,
            'thirdPartyCookies' => true,
            'googleTagID' => 123,
        ], app(Share::class)->all());
    }
}