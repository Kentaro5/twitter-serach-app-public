<?php

namespace Tests\Feature\twitter;

use App\User;
use Mockery;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class getFavListTest extends TestCase
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
    public function favリスト表示()
    {

        $this->actingAs($this->user);

        $expcted_twitter_fav_data =
        [
                'created_at' => '',
                'id' => '',
                'text' => '',
                'truncated' => '',
                'favorited' => 'true',
        ];

        $reponse = $this->get( '/api/twitter' )
            ->assertStatus(200);

        $json_data = json_decode( $reponse->content() );

        //twitterのデータチェック
        for ($i=0; $i < 1; $i++) {

            foreach ($expcted_twitter_fav_data as $key => $value) {
                if( ! property_exists($json_data[$i], $key) ){
                    dd(['存在しないキーが発見されました', $key]);
                }
            }
        }

    }

}












