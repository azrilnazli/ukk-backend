@extends('layouts.master')

@section('title', 'Update Role')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/users">{{ __('Users') }}</a></li>
        <li class="breadcrumb-item"><a href="/roles">{{ __('Roles') }}</a></li>
        <li class="breadcrumb-item active">{{ $role->name }}</li>

    </ol>
</nav>
@stop

@section('content')
<form id="update_role" method="POST" action="{{ route('roles.update',$role->name) }}">
    @csrf
    @method('PUT')


    <div class="card card-secondary">
        <div class="card-header">
          ROLE : <strong><span class="text-uppercase">{{ $role->name }}</span></strong>
        </div>
        <div class="card-body">


            <div class="row">

                @foreach($controllers as $key => $value)
                <div class="col-lg-4">
                    <div class="card card-dark ">
                        <div class="card-header">
                            <span class="h5 text-uppercase">{{ str_replace('_',' ',$key) }}</span>
                        </div>
                        <div class="card-body">
                            @foreach($value as $controller )
                                <div class="form-check">

                                    @if( $role->permissions->count() > 0 )
                                        @foreach($role->permissions as $permission)
                                            {{-- <span style="color:red"> {{ $permission->name  }}</span> <br /> --}}
                                            @if($controller == $permission->name)
                                            <input checked value="{{ $controller }} " name="controllers[]" class="form-check-input" type="checkbox" value="1" />
                                            @break
                                            @else
                                            <input value="{{ $controller }} " name="controllers[]" class="form-check-input" type="checkbox" value="0" />
                                            @endif
                                        @endforeach
                                    @else
                                    <input value="{{ $controller }} " name="controllers[]" class="form-check-input" type="checkbox" value="0" />
                                    @endif


                                    <label class="form-check-label text-muted">
                                        {{ str_replace($key . '-','', $controller) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


        </div>
        <div class="card-footer">
            <button id="submit" class="btn btn-primary" >Submit</button>

            <button type="button" class="btn btn-secondary" onclick="window.location.href='/roles'">
                Cancel
            </button>
        </div>
      </div>
</form>

<script>
    $( document ).ready(function() {
          $( "#submit" ).click(function() {
          //alert( "Handler for .click() called." );
          $("#update_role").submit();
        });
    });
</script>
@stop
