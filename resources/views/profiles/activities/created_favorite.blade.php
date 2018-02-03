@component('profiles.activities.activity')
    @slot('heading')
	<?php // dd($activity); ?>
	<a href="{{$activity->subject->favorited->path()}}">
		
        {{ $profilesUser->name }} favorited a reply
	</a>
    @endslot

    @slot('body')
        {!! $activity->subject->favorited->body !!}
    @endslot
@endcomponent