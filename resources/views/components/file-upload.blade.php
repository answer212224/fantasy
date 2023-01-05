
<form class="mt-8 space-y-3" action="{{$url}}" method="POST">
    @csrf
    <!-- Create By Joker Banny -->
    <div class="bg-gray-100 flex items-center justify-center">
        <div class="w-80 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl hover:scale-105 duration-500 transform transition cursor-pointer">
            <img src="{{$img}}" alt="" id="blah{{$id}}">
            <div class="p-5">
                <h1 class="text-2xl font-bold">{{$slot}}</h1>
                <p class="mt-2 text-lg font-semibold text-gray-600">
                    <label for="title" class="mr-3">標題</label>
                    <input class="text-base p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="" placeholder="" name="title" value="{{$title}}"></p>
                <p class="mt-2 text-lg font-semibold text-gray-600">
                    <label for="title" class="mr-3">圖片</label>
                    <input class="text-base p-2 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500" type="" placeholder="" name="img" value="{{$name}}">
                </p>
                <p class="mt-2 text-lg font-semibold text-gray-600 text-center">
                    <x-button>
                        {{ __('儲存') }}
                    </x-button>
                </p>

            </div>


        </div>

    </div>
</form>





