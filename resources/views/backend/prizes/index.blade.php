<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prizes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @foreach ($prizes as $prize)
            <div class="inline-flex mx-6 my-6">
                <x-file-upload>
                    {{$prize->name}}
                    <x-slot name="url">
                        {{env('APP_URL')}}/admin/prizes/{{$prize->id}}
                    </x-slot>
                    <x-slot name="title">
                        {{$prize->title}}
                    </x-slot>
                    <x-slot name="img">
                        https://p.udn.com.tw/upf/fantasy_image/{{$prize->img}}
                    </x-slot>
                    <x-slot name="name">
                        {{$prize->img}}
                    </x-slot>
                    <x-slot name="id">
                        {{$prize->id}}
                    </x-slot>
                </x-file-upload>
            </div>
        @endforeach
    </div>
    @push('bottomScripts')
    <script>

        function readURL(e) {

        var pid = e.dataset.pid;

        if (e.files && e.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {

                $('#blah'+pid).attr('src', e.target.result);
            }

            reader.readAsDataURL(e.files[0]);
        }
    }

    $(".hidden").change(function(){

        readURL(this);
    });

    </script>
    @endpush

</x-app-layout>



