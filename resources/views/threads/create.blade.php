@extends('layouts.app')


@section ('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new thread</div>
					<form method="POST" action="/threads">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="channel_id">Choose a Channel:</label>
							<select name="channel_id" id="channel_id" class="form-control" required>
								
								<option value="">Choose one...</option>
								@foreach($channels as $channel)
									<option  value= "{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected':'' }} > 
										 {{$channel->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" id="title" name="title" class="form-control" value="{{old('title')}}" required>
						</div>
						<div class="form-group">
							<label for="title">Body</label>
<!--							<textarea name="body" id="body" class="form-control"rows="8" required>{{old('body')}}</textarea>-->
							<wysiwyg name="body"></wysiwyg>
						</div>
						
						<div class="form-group">
                          <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                       </div>
						
						<div class="form-group">
							
						<button type="submit" class="btn btn-default">Publish</button>
							
						</div>
						
						@if(count($errors))
						<ul class="alert alert-danger">
							@foreach($errors->all() as $error)
							<li>
								{{$error}}
							</li>
							@endforeach
						</ul>
						@endif
					</form>
                <div class="panel-body">
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection