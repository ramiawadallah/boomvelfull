@extends('layouts.backend') 
@section('content')

<form action="{{route('admin.update',[$admin->id])}}" method="post">
    @csrf @method('patch')
    <!-- Material Design -->
    <h2 class="content-heading">
        <button type="submit" class="btn btn-info btn-md">
            Submite
        </button>
    </h2>

    <div class="row">
        <div class="col-md-8">
            <!-- Static Labels -->
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title">Register New {{ ucfirst(config('multiauth.prefix')) }}</h3>
                </div>
                <div class="block-content block-content-narrow">
                    <div class="form-group">
                        <div class="form-material form-material-info floating">
                             <label>Name</label>
                             <input  id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $admin->name }}"
                            required autofocus>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="form-material form-material-info floating">
                            <label>Email</label>
                            <input  id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $admin->email }}"
                                required>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END Static Labels -->
        </div>
        <div class="col-md-4">
            <!-- Floating Labels -->
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title">Options</h3>
                </div>
                <div class="block-content block-content-narrow">
                  <div class="form-group">
                        <label>Select Role</label>
                        <select name="role_id[]" id="role_id" class="form-control {{ $errors->has('role_id') ? ' is-invalid' : '' }}" multiple>
                            <option selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" 
                                    @if (in_array($role->id,$admin->roles->pluck('id')->toArray())) 
                                        selected 
                                    @endif >{{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- END Floating Labels -->
        </div>
    </div>
    <!-- END Material Design -->                                   
</form>



@endsection
