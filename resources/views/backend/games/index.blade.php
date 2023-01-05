<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Games') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                <h1>webhook 或 輸入 game id 更新比賽</h1>
            </div>
            <div class="bg-white mt-6 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row">
                        <form method="GET" action="{{env('APP_URL')}}/admin/games/search">
                            <div class="inline-flex mr-3">
                                <x-calendar>
                                    <x-slot name="name">
                                        date
                                    </x-slot>
                                </x-calendar>
                            </div>
                            <div class="inline-flex mr-3">
                                <x-button>
                                    {{ __('查詢') }}
                                </x-button>
                            </div>
                        </form>

                        <form method="POST" action="{{env('APP_URL')}}/admin/games/update">
                            @csrf

                            <div class="inline-flex mr-3 mb-5">
                                <x-input id="game_id" type="text" name="game_id" autofocus class="text-sm"/>
                            </div>
                            <div class="inline-flex">
                                <x-button>
                                    {{ __('更新NBA數據') }}
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
                                                GameID
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                比賽日期(Asia)
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                比賽更新
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">player</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($games as $game)
                                            <tr class="@if (!$game->status) bg-red-100 @endif">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{$game->nba_game_id}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{$game->date_only}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($game->status) 已更新
                                                    @else 未更新
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{env('APP_URL')}}/admin/games/{{$game->id}}" class="text-indigo-600 hover:text-indigo-900">球員數據</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{$games->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
