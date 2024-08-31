@extends('adminlte::page')
@section('title', $title)

@section('content_header')
<div class="d-flex">
    <div class="mr-auto p-2"><h1>{{ $title }}</h1></div>
    <div class="p-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Developer') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Naming Conventions') }}</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')

    {{-- CONTROLLER --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>Naming Controllers</div>
            </div>
        </h5>
        <div class="card-body">
            <ol>
                <li>Controllers should be in PascalCase/CapitalCase.</li>
                <li>They should be in singular case, no spacing between words, and end with "Controller".</li>
                <li>Also, each word should be capitalised (i.e. BlogController, not blogcontroller).</li>
            </ol>
            <div class="alert alert-success">
                <i class="fa fa-check-circle" aria-hidden="true"></i> For example: BlogController, AuthController, UserController.
            </div>
            <div class="alert alert-danger">
                <i class="fa fa-times"></i> Bad examples: UsersController (because it is in plural), Users (because it is missing the Controller suffix).
            </div>
        </div>
    </div>

    {{-- BLADE --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>Blade view files</div>
            </div>
        </h5>
        <div class="card-body">
            <p>Blade files should be in lower case, snake_case (underscore between words).</p>
            <div class="alert alert-success">
                <i class="fa fa-check-circle" aria-hidden="true"></i> For example: all.blade.php, all_posts.blade.php, etc
            </div>
            <div class="alert alert-danger">
                <i class="fa fa-times"></i> Bad examples: aLL.blade.php, allPosts.blade.php, etc.
            </div>
        </div>
    </div>

    {{-- TABLE NAMES --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>Naming database tables in Laravel</div>
            </div>
        </h5>
        <div class="card-body">
            <ol>
                <li>DB tables should be in lower case, with underscores to separate words (snake_case), and should be in plural form.</li>
            </ol>
            <div class="alert alert-success">
                <i class="fa fa-check-circle" aria-hidden="true"></i> For example: posts, project_tasks, uploaded_images.
            </div>
            <div class="alert alert-danger">
                <i class="fa fa-times"></i> Bad examples: all_posts, Posts, post, blogPosts
            </div>
        </div>
    </div>

    {{-- PRIMARY / FOREIGN KEY --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>Primary / Foreign key</div>
            </div>
        </h5>
        <div class="card-body">
            <h5>Primary key</h5>
            <p>This should normally be id.</p>
            
            <h5 class="mt-3">Foreign key</h5>
            <p>Foreign keys should be the model name (singular), with '_id' appended to it (assuming the PK in the other table is 'id').</p>

            <div class="alert alert-success">
                <i class="fa fa-check-circle" aria-hidden="true"></i> For example: comment_id, user_id
            </div>
        </div>
    </div>
    

    {{-- VARIABLE --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>Variables</div>
            </div>
        </h5>
        <div class="card-body">
            <p>Normal variables should typically be in camelCase, with the first character lower case</p>
            <div class="alert alert-success">
                <i class="fa fa-check-circle" aria-hidden="true"></i> For example: $users = ..., $bannedUsers = ...
            </div>
            <div class="alert alert-danger">
                <i class="fa fa-times"></i> Bad examples: $all_banned_users = ..., $Users=...
            </div>
            
            <p>
                If the variable contains an array or collection of multiple items then the variable name should be in plural. Otherwise, it should be in singular form.
            </p>
            <div class="alert alert-success">
                <i class="fa fa-check-circle" aria-hidden="true"></i> For example: $users = User::all(); (as this will be a collection of multiple User objects), but $user = User::first() (as this is just one object)
            </div>
        </div>
    </div>

    {{-- ROUTE --}}
    <div class="{{ config('adminlte.card_default') }}">
        <h5 class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>Route</div>
            </div>
        </h5>
        <div class="card-body">
            <table class="{{ config('adminlte.table') }}">
                <thead>
                    <tr>
                        <th>METHOD</th>
                        <th>URI</th>
                        <th>TYPICAL METHOD NAME</th>
                        <th>ROUTE NAME</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>GET</td>
                        <td>/{module_name}/photos</td>
                        <td>index()</td>
                        <td>{module_name}.photos.index</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection