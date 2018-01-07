<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
	use RefreshDatabase;
	
	public function setUp() {
		parent::setUp();
		$this->thread = factory('App\Thread')->create();
	}

	/**
     * @test
     */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')->assertSee($this->thread->title);
        
		
    }
	
    /**
     * @test
     */
	public function a_user_can_read_a_single_thread(){
		 $this->get($this->thread->path())->assertSee($this->thread->title);
		
	}
      /**
     * @test
     */
	public function a_user_can_filter_threads_according_to_a_channel(){
		$channel = create("App\Channel");
		$threadInChannel = create("App\Thread", ["channel_id" => $channel->id]);
		$threadnotInChannel = create("App\Thread");
		$this->get("/threads/".$channel->slug)->assertSee($threadInChannel->title)->assertDontSee($threadnotInChannel->title);
		
	}
	
//	public function a_user_can_read_replies_that_are_associated_whith_a_thread(){
//		$replay = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
//		$this->get($this->thread->path())->assertSee($replay->body);
//	}
     /**
     * @test
     */
	public function a_user_can_filter_threads_by_any_username(){
		$this->signIn(create('App\User', ['name' => "JohnDoe"]));
		$threadbyJohn = create("App\Thread", ["user_id" => auth()->id()]);
		$threadNotbyJohn = create("App\Thread");
		$this->get("threads?by=JohnDoe/")->assertSee($threadbyJohn->title)->assertDontSee($threadNotbyJohn->title);
		
	}
     /**
     * @test
     */
	public function a_user_can_filter_threads_by_popularity(){
		$threadsWithTwoReplies = create("App\Thread");
		create("App\Reply", ["thread_id" => $threadsWithTwoReplies->id], 2);
		$threadsWithThreeReplies = create("App\Thread");
		create("App\Reply", ["thread_id" => $threadsWithThreeReplies->id], 3);
		$threadsWithNoReplies = $this->thread;
		$response = $this->getJson("threads?popular=1")->json();
		$this->assertEquals([3,2,0], array_column($response['data'], 'replies_count'));
		
		
	}
	
	/** @test */
    function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
	
	/** @test */
    function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }
}
