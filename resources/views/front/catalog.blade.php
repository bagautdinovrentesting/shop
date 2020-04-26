@extends('layouts.front.app', ['title' => 'Каталог'])

@section('content')
    <div class="row d-flex">
        @foreach($sections as $section)
            <div class="section-block col-md-6 p-0">
                <div class="section-block__item">
                    <table class="item-inner">
                        <tbody>
                            <tr>
                                <td class="image">
                                    <a href="/catalog/avtoelektronika/" class="thumb">
                                        <img src="{{ Storage::url($section->photo) }}" alt="{{ $section->name }}" title="{{ $section->name }}">
                                    </a>
                                </td>
                                <td class="sub-sections">
                                    <ul class="p-0">
                                        <li class="name">
                                            <a href="{{ route('front.section.id', $section->id) }}"><span>{{ $section->name }}</span></a>
                                        </li>
                                        <li class="sub"><a href="#">GPS-навигаторы&nbsp;<span>6</span></a></li>
                                        <li class="sub"><a href="#">Видеорегистраторы&nbsp;<span>5</span></a></li>
                                        <li class="sub"><a href="#">Автозвук&nbsp;<span>10</span></a></li>
                                        <li class="sub"><a href="#">Радары-детекторы&nbsp;<span>4</span></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td class="desc" colspan="2">
                                    <span class="desc-wrap">{{ $section->description }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
