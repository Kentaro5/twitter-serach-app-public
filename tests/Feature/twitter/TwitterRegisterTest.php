<?php

namespace Tests\Feature\twitter;

use App\User;
use Mockery;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TwitterRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->providerName = 'twitter';

    }
    /**
     * @test
     */
    public function Homeページ表示()
    {
        // URLをコール
        $responce = $this->get( '/auth/redirect/'.$this->providerName );

        $this->assertThat( $responce->getContent(), $this->stringStartsWith('https://api.twitter.com/oauth/authenticate') );

        $redirect_url = $responce->getContent();

        $twitter_page = $this->get( $redirect_url );
        $twitter_page->assertStatus(200);

    }


    /**
     * @test
     */
    public function Tiwtterアカウントでユーザー登録できる()
    {
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('redirect')->andReturn('Redirected');
        $providerName = class_basename($provider);
        //Call your model factory here
        $socialAccount = factory(User::class)->create(['provider' => $providerName]);

        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');

        // Get the api user object here
        $abstractUser->shouldReceive('getId')
                ->andReturn($socialAccount->provider_user_id)
                ->shouldReceive('getEmail')
                ->andReturn(str_random(10).'@noemail.app')
                ->shouldReceive('getNickname')
                ->andReturn('Laztopaz')
                ->shouldReceive('getAvatar')
                ->andReturn('https://en.gravatar.com/userimage')
                ->shouldReceive('get_provider_Id')
                ->andReturn(123);


        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('twitter')->andReturn($provider);

        // After Oauth redirect back to the route
        $this->get( '/auth/testcallback/'.$this->providerName )
                ->assertStatus(302)
                ->assertRedirect( '/' );

        //登録されているユーザーデータを取得
        $user = User::where( ['email' => $abstractUser->getEmail()] )->firstOrFail();

        //各データが正しく登録されているかチェック
        $this->assertEquals($user->provider_id, $abstractUser->get_provider_Id());
        $this->assertEquals($user->provider, $this->providerName);
        $this->assertEquals($user->name, $abstractUser->getNickName());
        $this->assertEquals($user->email, $abstractUser->getEmail());

    }
}
