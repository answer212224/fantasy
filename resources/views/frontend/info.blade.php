@extends('frontend.layouts.app')
@section('content')
    <main class="main">
        <div class="container main-container">
            <div id='div-gpt-ad-1541142132668-0' style='height:90px; width:728px;' class="banner-ads desktop-ads">
                <script>
                    googletag.cmd.push(function() {
                        googletag.display('div-gpt-ad-1541142132668-0');
                    });
                </script>
            </div>

            <div id='div-gpt-ad-1541142159376-0' style='height:100px; width:300px;' class="banner-ads mobile-ads">
                <script>
                    googletag.cmd.push(function() {
                        googletag.display('div-gpt-ad-1541142159376-0');
                    });
                </script>
            </div>


            <!-- 2019 -->
            <div class="common-section">
                <h1 class="heading">遊戲規則 <span class="en">Game Rules </span></h1>
                <div class="section-info section-info__rules">
                    <p>從附加賽、季後賽、總冠軍賽球隊中選出自己喜歡的 5 位球員，進行每天的積分統計。每週、每輪積分第一名玩家可以贏得獎品季後賽總積分排名前 10 名可以獲得獎品。</p>

                    <section class="rules-holder">
                        <h2 class="sub-heading">登入方式</h2>

                        <ol class="rules-list">
                            <li>使用Facebook登入。</li>
                            <li>請同意Facebook帳號授權並開放主辦單位蒐集並使用公開資訊 (包含:姓名、E-Mail)。</li>
                        </ol>
                    </section>

                    <section class="rules-holder">
                        <h2 class="sub-heading">選球員的規則</h2>

                        <div class="rules-items">
                            您有430點的能力值，可以依照球員的能力值來選擇您想要的球員！ <br>
                            ※ 可以不用選到430，但一定不能大於430 <br>
                            ※ 選擇的球員必須符合可以打的位置（後衛／前鋒／中鋒） <br>
                        </div>

                    </section>

                    <section class="rules-holder">
                        <h2 class="sub-heading">積分計算方式</h2>

                        <div class="rules-items">

                            <ol class="rules-list">
                                <li>依照NBA球員每場球賽的比賽數據而有不同的加權。 <br>
                                    得分*{{ $weight->point }}、籃板*{{ $weight->reb }}、助攻*{{ $weight->assist }}、抄截*{{ $weight->steal }}、阻攻*{{ $weight->block }}、失誤*{{ $weight->turnover }}
                                </li>

                                <span class="rules-tips">
                                    【舉例】<br>
                                    快艇球員 Kawhi Leonard 本日得到30分、10籃板 、5助攻 、3抄截、0阻攻、5失誤<br>
                                    依照加權計算出的積分為
                                    {{ $weight->point * 30 }}+{{ $weight->reb * 10 }}+{{ $weight->assist * 5 }}+{{ $weight->steal * 3 }}+{{ $weight->block * 0 }}{{ $weight->turnover * 5 }}
                                    =
                                    {{ round($weight->point * 30 +$weight->reb * 10 +$weight->assist * 5 +$weight->steal * 3 +$weight->block * 0 +$weight->turnover * 5) }}
                                    分<br>
                                </span>

                                <li>傷兵或是沒有被登錄、上場時間為 0 的都會被計算為 0 分 <br> ※上場後數據為 0 的，該球員加權積分為 0</li>
                                <li>需每日更新比賽球員，才會被計算當日積分。<br>※隨著每輪開打，被淘汰的球隊球員依然可以被選擇，但以 0 分計算。</li>
                            </ol>

                        </div>

                    </section>

                    <section class="rules-holder">
                        <h2 class="sub-heading">比賽輪替</h2>

                        <div class="rules-items">
                            <p>於有賽程的當天皆可以使用自己已經選擇好的五位球員出賽，並累計積分！</p>
                        </div>

                    </section>

                    <section class="rules-holder">
                        <h2 class="sub-heading">選擇球員的時間</h2>

                        <div class="rules-items">
                            <p>台灣時間早上06:00~23:59選擇隔天出賽的球員。</p>
                            <small>＊若非比賽前一天所送出的球員，分數不予以計算。</small>

                            <span class="rules-tips">
                                【舉例】<br>
                                如果10/18-10/22 有球賽，則10/18 06:00 後可選擇19日的比賽球員，直到 10/18 23:59 為止。 <br>
                                如果10/20-10/21 無球賽，則10/21 06:00~23:59 即可選擇 10/22 的球賽出場球員，並以此類推 <br>

                            </span>

                        </div>

                    </section>

                    <section class="rules-holder">
                        <h2 class="sub-heading">注意事項</h2>

                        <div class="rules-items">

                            <ol class="rules-list">
                                <li>需自行注意真實世界的NBA傷兵球員，若無上場卻被選到了，該球員的加權積分為0。</li>
                                <li>若積分相同，排名則相同。實際抽獎的資格則以主辦單位抽籤決定。</li>
                                <li>傷兵球員與被淘汰的隊伍球員需自行更換，否則不予以計算積分。</li>
                                <li>為確保得獎後的領獎權益，請同意 Facebook 帳號授權並開放主辦單位蒐集公開資訊(包含:姓名、E-Mail、Facebook
                                    ID等)。若主辦單位無法聯繫到得獎玩家，得獎玩家視同放棄得獎資格。
                                </li>
                                <li>
                                    若不同意主辦單位使用公開資訊或其他活動相關問題，請來信至vaservice@udn.com告知。
                                </li>
                            </ol>

                        </div>

                    </section>

                    <section class="rules-holder">
                        <h2 class="sub-heading">獎勵方式</h2>

                        <div class="rules-items">
                            <ol class="rules-list">
                                @foreach ($prizes as $prize)
                                    <li>{{ $prize->name }} - {{ $prize->title }}</li>
                                @endforeach

                            </ol>
                        </div>

                        <div class="rules-items">
                            ※每週排名的計算範圍是每週一開始至週日的7天區間。<br>
                            ※若積分相同，排名則相同。實際抽獎的資格則以主辦單位抽籤決定。<br>
                            ※主辦單位保留更改權利，無須事前通知，亦有權對本活動之所有事宜作出最終解釋或裁決。<br>
                            ※活動獎項以實品為準，恕不提供挑選款式及尺寸，如遇不可抗拒或非可歸責於聯合線上之因素，聯合線上保留更換其他等值獎項之權利。<br>
                            ※獎項寄送地區僅限台、澎、金、馬，聯合線上不處理郵寄獎品至海外地區之事宜。本活動之獎品不得轉換、轉讓或折換現金。 <br>
                        </div>

                    </section>

                    <section class="rules-holder">
                        <h2 class="sub-heading">得獎公布時間</h2>

                        <div class="rules-items">
                            <p>每週三公布上週積分第一名的玩家；6/30 前公布季後賽所有獎項贏家。主辦單位將透過 E-Mail 聯絡中獎事宜。</p>
                        </div>

                    </section>
                </div>

            </div>

            <div class="common-section" id="prize">
                <h1 class="heading">遊戲獎項 <span class="en"> </span></h1>
                <div class="section-info section-info__prize">
                    <section class="prize-holder">
                        @foreach ($prizes as $prize)
                            <div class="prize">
                                <img src="https://p.udn.com.tw/upf/fantasy_image/{{ $prize->img }}" alt="">
                                <h2 class="sub-heading">{{ $prize->name }} :<br>
                                    {{ $prize->title }}</h2>
                            </div>
                        @endforeach
                    </section>

                </div>

            </div>





        </div>
        <canvas id="particles"></canvas>
    </main>
@endsection
