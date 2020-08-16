@extends('layouts.master')

@section('content')
            <div class="content">
                {{Html::image('imgs/search_logo.png','logo', ['style' => 'opacity:0.5; margin-top:20px;'])}}
                <div class="title m-b-md">
                    {{config('app.name')}}
                </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Upload file</div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    {!! Form::open(['route' => 'upload', 'files' => true, 'id' => 'upload'])!!}
                                        <div class="form-group">
                                            {!! Form::file('plates[]', array('multiple')) !!}
                                        </div>
                                        <div class="form-group {{ $errors->has('find') ? ' has-error' : '' }}">
                                            <div class="checkbox">
                                                <label>
                                                {!! Form::checkbox('find', true, null, ['id' => 'find']) !!}
                                                Find saved file
                                                </label>
                                            </div>
                                            @if(count($errors) > 0)
                                                @foreach ($errors->all() as $error)
                                                    <span class="help-block" style="color: red;">
                                                        <strong>{{ $error }}</strong>
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Upload</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>          
                    </div>
                </div>
            </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            if($("#find").prop('checked') == true) {
                        $("#upload").find('button[type="submit"]').text('Find');
                        $("#upload").find('input[type="file"]').hide();
            }
            $("#find").change(function() {
                    if(this.checked) {
                        $("#upload").find('button[type="submit"]').text('Find');
                        $("#upload").find('input[type="file"]').hide();
                    }
                    else{
                        $("#upload").find('button[type="submit"]').text('Upload');
                        $("#upload").find('input[type="file"]').show();
                    }
            });
        });
    </script>
@endpush