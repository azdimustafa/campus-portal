<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
        <img src="{{ asset('locale/'.app()->currentLocale().'.png') }}" alt="" width="30"> {{ array_search(app()->currentLocale(), config('app.available_locales')) }}
    </a>
    <div class="dropdown-menu dropdown-menu dropdown-menu-right">
        @foreach(config('app.available_locales') as $locale_name => $available_locale)
            @if (app()->currentLocale() == $available_locale)
            <a href="#" class="dropdown-item text-bold">
                <img src="{{ asset('locale/'.$available_locale.'.png') }}" alt="" width="30"> {{ $locale_name }}
            </a>
            @else    
            <a href="{{ route('language', $available_locale) }}" class="dropdown-item">
                <img src="{{ asset('locale/'.$available_locale.'.png') }}" alt="" width="30"> {{ $locale_name }}
            </a>
            @endif
        @endforeach
    </div>
  </li>