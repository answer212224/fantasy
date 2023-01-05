<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{env('APP_URL')}}/admin/setting" class="my-3">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    @csrf
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-3 sm:col-span-3 lg:col-span-3">
                            <label for="year" class="block text-sm font-medium text-gray-700">fantasy網站設定(總排名, 最夯球員, 會員排名) 年份: </label>
                                <select name="year"class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option @if($setting->year=='2021') selected @endif value="2021">2021</option>
                                    <option @if($setting->year=='2022') selected @endif value="2022">2022</option>
                                    <option @if($setting->year=='2023') selected @endif value="2023">2023</option>
                                    <option @if($setting->year=='2024') selected @endif value="2024">2024</option>
                                    <option @if($setting->year=='2025') selected @endif value="2025">2025</option>
                                    <option @if($setting->year=='2026') selected @endif value="2026">2026</option>
                                    <option @if($setting->year=='2027') selected @endif value="2027">2027</option>
                                    <option @if($setting->year=='2028') selected @endif value="2028">2028</option>
                                </select>
                        </div>
                        <div class="col-span-3 sm:col-span-3 lg:col-span-3">
                            <label for="type" class="block text-sm font-medium text-gray-700">fantasy網站設定(總排名, 最夯球員, 會員排名) 賽季: </label>
                            <select name="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option @if($setting->type=='playoff') selected @endif value="playoff">季後賽</option>
                                <option @if($setting->type=='season') selected @endif value="season">例行賽</option>
                            </select>
                        </div>
                        <div class="col-span-3 sm:col-span-3 lg:col-span-3">
                            <label for="award_year" class="block text-sm font-medium text-gray-700">得獎名單顯示 年分: </label>
                            <select name="award_year" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option @if($setting->award_year=='2021') selected @endif value="2021">2021</option>
                                <option @if($setting->award_year=='2022') selected @endif value="2022">2022</option>
                                <option @if($setting->award_year=='2023') selected @endif value="2023">2023</option>
                                <option @if($setting->award_year=='2024') selected @endif value="2024">2024</option>
                                <option @if($setting->award_year=='2025') selected @endif value="2025">2025</option>
                                <option @if($setting->award_year=='2026') selected @endif value="2026">2026</option>
                                <option @if($setting->award_year=='2027') selected @endif value="2027">2027</option>
                                <option @if($setting->award_year=='2028') selected @endif value="2028">2028</option>
                            </select>
                        </div>

                        <div class="col-span-3 sm:col-span-3 lg:col-span-3">
                            <label for="prize_type" class="block text-sm font-medium text-gray-700">獎品顯示 賽季: </label>
                            <select name="prize_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option @if($setting->prize_type=='playoff') selected @endif value="playoff">季後賽</option>
                                <option @if($setting->prize_type=='season') selected @endif value="season">例行賽</option>
                            </select>
                        </div>

                        <div class="col-span-3 sm:col-span-3 lg:col-span-3">
                            <label for="prize_type" class="block text-sm font-medium text-gray-700">關閉預測日期開始: </label>
                            <input type="date" class="
                                mt-1
                                block
                                w-full
                                rounded-md
                                border-gray-300
                                shadow-sm
                                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                            " value="{{$setting->shutdown_start_date->format('Y-m-d')}}" name="shutdown_start_date">
                        </div>

                        <div class="col-span-3 sm:col-span-3 lg:col-span-3">
                            <label for="prize_type" class="block text-sm font-medium text-gray-700">關閉預測日期結束: </label>
                            <input type="date" class="
                                mt-1
                                block
                                w-full
                                rounded-md
                                border-gray-300
                                shadow-sm
                                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                            " value="{{$setting->shutdown_end_date->format('Y-m-d')}}" name="shutdown_end_date">
                        </div>

                        <div class="col-span-6 sm:col-span-6 lg:col-span-6 text-right">
                            <div class="px-4 py-3 sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="bg-white mt-6 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl text-gray-800 font-semibold mb-3">規則的加權值</h1>
                    <div class="flex flex-col">
                        <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <form method="POST" action="{{env('APP_URL')}}/admin/weight">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    得分
                                                </th>
                                                <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    籃板
                                                </th>
                                                <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    助攻
                                                </th>
                                                <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    抄截
                                                </th>

                                                <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    阻攻
                                                </th>
                                                <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    失誤
                                                </th>
                                                <th scope="col" class="relative py-3">
                                                <span class="sr-only">比重</span>
                                                </th>
                                            </tr>
                                        </thead>

                                            <tbody class="bg-white divide-y divide-gray-200">
                                                    @csrf
                                                    <tr>
                                                        <td class="py-3 text-xs text-gray-500">
                                                            <input type="text" value="{{$weight->point}}"name="point"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                                        </td>
                                                        <td class="py-3 whitespace-nowrap text-xs text-gray-500">
                                                            <input type="text" value="{{$weight->reb}}"name="reb"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                                        </td>
                                                        <td class="py-3 whitespace-nowrap text-xs text-gray-500">
                                                            <input type="text" value="{{$weight->assist}}"name="assist"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                                        </td>
                                                        <td class="py-3 whitespace-nowrap text-xs text-gray-500">
                                                            <input type="text" value="{{$weight->steal}}"name="steal"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                                        </td>
                                                        <td class="py-3 whitespace-nowrap text-xs text-gray-500">
                                                            <input type="text" value="{{$weight->block}}"name="block"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                                        </td>
                                                        <td class="py-3 whitespace-nowrap text-xs text-gray-500">
                                                            <input type="text" value="{{$weight->turnover}}"name="turnover"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                                        </td>

                                                    </tr>
                                            </tbody>
                                    </table>
                                <div class="px-4 py-3 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
