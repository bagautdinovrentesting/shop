<nav class="nav nav-pills flex-column flex-sm-row">
    @foreach($sections as $section)
        <div class="flex-sm-fill text-sm-center outer-nav-link">
            @if(!empty($section['children']))
                <a href="{{ route('front.section.id', $section['id']) }}" class="btn" id="dropdownMenu_{{ $section['id'] }}" style="color: #cbbde2">
                    {{ $section['name'] }}
                </a>
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
