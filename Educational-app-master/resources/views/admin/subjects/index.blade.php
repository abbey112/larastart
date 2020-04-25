@extends('admin.layouts.head')
@section('section')
<div class="modal-body">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible">
      {{ session('success') }}  
      <button type="button" class="close" aria-label="Close">
        <span arial-hidden="true">&times;</span>
      </button>
    </div>
  @endif
<h2 class="text-center">Subjects panel</h2>
<div class="row justify-content-md-center">
    <div class="col-sm-4 mb-3 ">
      <div class="card text-white bg-info">
        <div class="card-body">
          <h5 class="col-xs-3">No of subjects</h5>
          <div class="col-xs-3 float-right">
            <i class="fa fa-fw fa-book fa-5x"></i>
        </div>
          <h2 class="card-text text-center">{{count($subjects)}}</h2>
          <a href="#!" class="btn btn-primary">Go somewhere</a>
        </div>
      </div>
    </div>
    {{-- <div class="col-sm-4 mb-3 ">
        <div class="card text-white bg-info">
          <div class="card-body">
            <h5 class="col-xs-3">No of Subjects</h5>
            <div class="col-xs-3 float-right">
              <i class="fa fa-fw fa-user-md fa-5x"></i>
          </div>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#!" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
    </div> --}}
    <div class="container">
        <button class="btn btn-primary" data-toggle="modal" data-target="#Newstudent">Add new</button>
        <table class="table table-hover ">
            <thead>

            </thead>
            <tbody>
                <tr>
                <th>S/N</th>
                <th>St. No</th>
                <th>Name</th>
                <th>Delete</th>
                </tr>
                    
                    @forelse ($subjects as $subj)
                    <tr>
                    <td>{{$subj->name}}</td>
                    <td>{{$subj->email}}</td>
                    <td>{{$subj->name}}</td>
                    <td>{{$subj->created_at}}</td>  
                    @empty
                        <td>   No subjects available</td>
                    @endforelse
                   
                </tr>
                
            </tbody>
        </table>
        <!-- Create new students -->
        <div class="modal fade" id="Newstudent" tabindex="-1" role="dialog" aria-labelledby="newstudent" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="newstudent">Add new Students</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                  @if($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                      <li>{{$error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                <form action="/admin/students" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">File input</label>
                            <input type="text"  class="form-control" placeholder="name" value="{{ old('full_name') }}" name="full_name" id="name">
                        </div>
                        <div class="form-group">
                          <label for="email">Email address</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" value="{{ old('email') }}" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                          <label for="password1">Password</label>
                          <input type="password" name="password" class="form-control" id="exampleInputPassword1"  placeholder="Password">
                        </div>
                        <input class="form-control" id="disabledInput" name="role" value="students" type="text" placeholder="students" readonly>
                        {{-- <button type="submit" class="btn btn-default">Submit</button> --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                        
                </div>
                
            </div>
            </div>
        </div>
    </div>
</div>    
@endsection