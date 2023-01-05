<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <h1>webhook 或 選擇日期 更新當天比賽</h1>
            </div>
            <div class="bg-white mt-6 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row">
                        <form method="GET" action="{{env('APP_URL')}}/admin/scores/search">
                            <div class="inline-flex mx-3">
                                <x-calendar>
                                    <x-slot name="name">
                                        date
                                    </x-slot>
                                </x-calendar>
                            </div>
                            <div class="inline-flex">
                                <x-button>
                                    {{ __('查詢') }}
                                </x-button>
                            </div>
                        </form>

                        <form method="POST" action="{{env('APP_URL')}}/admin/scores">
                            @csrf
                            <div class="inline-flex mx-3">
                                <x-calendar>
                                    <x-slot name="name">
                                        date
                                    </x-slot>
                                </x-calendar>
                            </div>
                            <div class="inline-flex">
                                <x-button>
                                    {{ __('分數加總') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                    <div class="flex flex-col">
                        <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                比賽日期(Asia)
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                狀態
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                最後更新時間
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">當天分數加總</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($scores as $score)
                                            <tr class="@if (!$score->status) bg-red-100 @endif">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{$score->date_only}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($score->status == 1) 已加總
                                                    @elseif($score->status == -1) 可加總
                                                    @elseif($score->status == -2) 不完全
                                                    @else 未加總
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{$score->updated_at}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <form method="POST" action="{{env('APP_URL')}}/admin/scores">
                                                        @csrf
                                                        <input type="text" name="date" value="{{$score->date_only}}" hidden>
                                                        <x-button>
                                                            {{ __('當天分數加總') }}
                                                        </x-button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{$scores->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
