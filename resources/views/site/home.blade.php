@extends('layouts.site.master')
@section('content')
    <div class="container mx-auto p-8">
        <div class="flex flex-row flex-wrap -mx-2">
            <div class="relative w-full md:w-1/5 mb-4 px-2">
                <div class="peer">
                    <div class="relative bg-color2 rounded border-color1">
                        <picture class="block bg-color1 border-b">
                            <img class="block" src="images/product/IMG_20230610_102915_719-300x400.jpg" alt="Card 1">
                        </picture>
                        <div class="p-4">
                            <h3 class="text-lg font-bold">
                                <a class="stretched-link" href="#" title="Card 1">
                                    Card 1
                                </a>
                            </h3>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bx bx-star text-lg text-color4"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute left-5 top-3 items-center transition-opacity ease-in duration-500 transform h-24 hidden peer-hover:flex hover:flex w-[50px] flex-col bg-white drop-shadow-lg">
                    <a class="px-3 hover:bg-gray-200" href="#"><i class="bx bx-shopping-bag text-2xl"></i></a>
                    <a class="px-3 hover:bg-gray-200" href="#"><i class="bx bx-heart text-2xl"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
