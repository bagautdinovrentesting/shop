<nav class="nav nav-pills flex-column flex-sm-row">
    @foreach($sections as $section)
        <div class="flex-sm-fill text-sm-center">
            @if(!empty($section['children']))
                <button type="button" class="btn dropdown-toggle" id="dropdownMenu_{{ $section['id'] }}" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" style="color: #cbbde2"
                >
                    {{ $section['name'] }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu_{{ $section['id'] }}">
                    @foreach($section['children'] as $child)
                        <a class="dropdown-item" href="{{ route('front.section.id', $child['id']) }}">{{ $child['name'] }}</a>
                    @endforeach
                </div>
            @else
                <a class="nav-link @if(request()->segment(2) == $section['id']) active @endif"
                   href="{{ route('front.section.id', $section['id']) }}"
                >
                    {{ $section['name'] }}
                </a>
            @endif
        </div>
    @endforeach
</nav>
