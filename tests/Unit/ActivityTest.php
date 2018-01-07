<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvtivityTest extends TestCase
{
	use RefreshDatabase;
	
	/** @test */
    public function it_records_activity_when_a_record_is_created()
    {
		$this->signIn();
		$thread = create("App\Thread");
		$this->assertDatabaseHas("activities", [
			'type' => "created_thread",
			'user_id' => auth()->id(),
			'subject_id' => $thread->id,
			'subject_type' => 'App\Thread'
		]);
		
		$activity = \App\Activity::first();
		$this->assertEquals($activity->subject->id, $thread->id);
    }
	/** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
		$this->signIn();
		$reply = create("App\Reply");
		
		$this->assertEquals(2, \App\Activity::count());
    }
	/** @test */
    public function it_fetches_a_feed_for_any_user()
    {
		$this->signIn();
		 create("App\Thread", ['user_id' => auth()->id()], 2);
//		 create("App\Thread", ['user_id' => auth()->id(), 'created_at' => \Carbon\Carbon::now()->subWeek()]);
		 auth()->user()->activity()->first()->update(['created_at' => \Carbon\Carbon::now()->subWeek()]);
		 $feed = \App\Activity::feed(auth()->user());
		
		$this->asserttrue($feed->keys()->contains(
						\Carbon\Carbon::now()->format('Y-m-d')
				));
		$this->asserttrue($feed->keys()->contains(
						\Carbon\Carbon::now()->subWeek()->format('Y-m-d')
				));
    }
	
}
