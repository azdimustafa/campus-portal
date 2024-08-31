<ul class="nav custom-nav card-header-pills">
    <li class="nav-item">
        <a class="nav-link @if($filter == null) active @endif" href="{{ route('site.users.index', ['filter' => null]) }}">
            ALL
        </a>
    </li>
    @foreach ($roles as $role)
    <li class="nav-item">
        <a class="nav-link @if($filter == $role['name']) active @endif" href="{{ route('site.users.index', ['filter' => $role['name']]) }}">
            {{ $role['name'] }} 
            <label class="badge badge-secondary">{{ $role['total'] }}</label>
        </a>
    </li>
    @endforeach
</ul>