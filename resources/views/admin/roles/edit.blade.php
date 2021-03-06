@extends('layouts.backend') 
@section('content')
<div class="block">
     <div class="block-content">
        <div class="block-header">
            <h3 class="block-title">
               Edit this Role
            </h3>
        </div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('admin.role.update', $role->id) }}" method="post">
                        @csrf @method('patch')
                        <div class="form-group">
                            <label for="role">Role Name</label>
                            <input type="text" value="{{ $role->name }}" name="name" class="form-control" id="role">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Change</button>
                        <a href="{{ route('admin.roles') }}" class="btn btn-danger btn-sm float-right">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection