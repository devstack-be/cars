@extends('layouts.master')
@section('title', '- Word')
@section('content')
            <div class="content">
            {{Html::image('imgs/search_logo.png','logo', ['style' => 'opacity:0.5; margin-top:20px;'])}}
                <div class="title m-b-md">
                    {{config('app.name')}}
                </div>
                    <p class="text-center"><span style="text-decoration:underline;">Number of lines:</span> <span style="font-weight:bold;">{{$countPlates}}</span></p>
                    <p class="text-center"><span style="text-decoration:underline;">Words searched:</span> <span id="countPlatesSearched" style="font-weight:bold;">{{$countPlatesSearched}}</span></p>
                    <div class="panel panel-default">
                        <div class="panel-heading">Verify word</div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    {!! Form::open(['route' => 'verify', 'id' => 'verify-form'])!!}
                                    <p class="alert hidden"></p>
                                    {{Html::image('imgs/loader.gif', 'loader', ['class' => 'hidden', 'id' => 'loader'])}}
                                        <div class="form-group">
                                            {!! Form::text('plate', null, ['class' => 'form-control', 'id' => 'plate']) !!}
                                                <span class="help-block hidden">
                                                    <strong></strong>
                                                </span>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Verify</button>
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
                       $( "#verify-form" ).on( "submit", function( event ) {
                        event.preventDefault();
                        var $this = $(this);
                        var datas = $this.serialize();
                        var alert = $this.find('p.alert');
                        alert.val('').addClass('hidden').removeClass('alert-danger').removeClass('alert-success');
                        var formgroup = $this.find('div.form-group');
                        formgroup.removeClass('has-error');
                        var helpblock = $this.find('span.help-block');
                        helpblock.addClass('hidden');
                        var countPlatesSearched = $( "#countPlatesSearched" );
                        var countPlatesSearchedValue = parseInt($( "#countPlatesSearched" ).text());
                        $.ajax({
                            method: 'POST',
                            url: $this.attr("action"),
                            data: datas,
                            beforeSend: function(){
                                $('#loader').removeClass('hidden');
                            },
                            complete: function(){
                                $('#loader').addClass('hidden');
                                $(document).scrollTop( $("#verify-form").offset().top ); 
                            },
                            success: function (msg) {  
                                var plate = $('#plate').val();
                                $('#plate').val('');
                                alert.text(plate).addClass('alert-'+msg.result).removeClass('hidden');
                                var errorsHtml;
                                if(msg.matches)
                                {
                                    errorsHtml = plate+'<br>Result found:<br>'+msg.matches[0];
                                    alert.html(errorsHtml)
                                }
                                countPlatesSearched.text(parseInt(countPlatesSearchedValue + 1));
                            },
        
                            error: function (jqXhr, json, errorThrown) {
                                var errors = jqXhr.responseJSON;
                                var errorsHtml;
                                if(errors)
                                {
                                    errorsHtml= '';
                                    $.each( errors, function( key, value ) {
                                        errorsHtml += value[0];
                                    });
                                }
                                else
                                {
                                    errorsHtml = 'Unknow error';
                                }
                                formgroup.addClass('has-error');
                                helpblock.removeClass('hidden').find('strong').text(errorsHtml);
                            }
                        });
                    });
        });
    </script>
@endpush