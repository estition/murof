<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
	use RefreshDatabase;
	
	/**	
     * @test
     */
    public function an_user_can_not_favorited_anything()
	{
		$this->withExceptionHandling()->post("replies/1/favorites")->assertRedirect("/login");
	}
	
	/**	
     * @test
     */
    public function an_authenticated_user_can_favorite_any_reply()
    {
		$this->signIn();
		// replies/id/favorites
		$reply = create('App\Reply'); // <-- create automatic a thread
		$this->post("replies/".$reply->id."/favorites");
		
//		dd(\App\Favorite::all());
		//it should be recorded in database
		$this->assertCount(1, $reply->favorites);
        
		
    }
	/**	
     * @test
     */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
		$this->signIn();
		$reply = create('App\Reply'); // <-- create automatic a thread
		try {
		$this->post("replies/".$reply->id."/favorites");
		$this->post("replies/".$reply->id."/favorites");
			
		} catch (Exception $ex) {
			$this->fail("Did not expect to insert the same record set twice!");	
		}
		
		$this->assertCount(1, $reply->favorites);
        
		
    }
	
     /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->favorites);
    }
}