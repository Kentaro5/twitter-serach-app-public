<?php

namespace Tests\Feature\twitter;

use App\User;
use Mockery;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class TwitterLoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->providerName = 'twitter';
        $this->provider_id = env('TWITTER_PROVIDER_ID');

        $this->user = factory(User::class)->create(['provider' => $this->providerName, 'provider_id' =>  $this->provider_id]);
    }

    /**
     * @test
     */
    public function ユーザーをログイン()
    {

        $this->actingAs($this->user);

        //ログインしているかどうかをチェックする。
        $this->assertTrue(Auth::check());

    }

    /**
     * @test
     */
    public function ユーザーをログアウト()
    {

        $this->actingAs($this->user);

        //ログインしているかどうかをチェックする。
        $this->assertTrue(Auth::check());

        //ログアウト処理
        $reponse = $this->post( route( 'logout' ) );
        //ログアウトしているかどうかをチェックする。
        $this->assertFalse(Auth::check());


    }
}
