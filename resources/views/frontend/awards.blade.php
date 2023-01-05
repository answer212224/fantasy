@extends('frontend.layouts.app')
@section('content')
    <main class="main">
        <div class="container main-container">
            <div id='div-gpt-ad-1541142132668-0' style='height:90px; width:728px;' class="banner-ads desktop-ads">
            <script>
                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1541142132668-0'); });
            </script>
        </div>

        <div id='div-gpt-ad-1541142159376-0' style='height:100px; width:300px;' class="banner-ads mobile-ads">
            <script>
                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1541142159376-0'); });
            </script>
        </div>

        <!-- 2019 -->
        {{-- <div class="common-section">
                <h1 class="heading">例行賽 <span class="en">Fantasy</span></h1>
                <div class="section-info section-info__rules">
                    <p>感謝您的參加！2021-22 賽季 NBA 例行賽 Fantasy 活動已經於 5/22 結束。謝謝所有玩家參與，希望您喜歡 NBA Fantasy 遊戲。現在則是季後賽 Fantasy 的時刻，持續每天選球員、賺積分、贏得更多大獎！</p>

                    <section class="rules-holder">
                        <h2 class="sub-heading">領獎方式</h2>

                        <ol class="rules-list">
                            <li>例行賽總排名前 10 名中獎通知將於 6/1 起陸續發至得獎者參加NBA Fantasy使用的Facebook帳號的Email。</li>
                            <li>得獎者請於中獎通知中規定的期限前回覆相關資訊，完成領獎流程。</li>
                        </ol>
                    </section>
                </div>

        </div> --}}
        <div class="common-section" id="winner">
            <h1 class="heading">得獎名單</h1>
            @if(($seasonRankingAwards))
                <div class="section-info">
                    <div class="winner-block">
                        <h2 class="winner-heading">例行賽總排名</h2>
                        <div class="winner-lists">
                            @foreach ($seasonRankingAwards->awardDetails as $awardDetail)
                                <div class="person">
                                    <div class="person-thumb">
                                        <img src="https://graph.facebook.com/{{$awardDetail->member->fb}}/picture?type=large" alt="">
                                    </div>
                                    <div class="person-name">{{$awardDetail->title}}
                                        <br> {{$awardDetail->member->name}}
                                        <span class="prize-value">{{$awardDetail->score}}分</span>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="winner-prize">NBA Store 線上禮券</div>
                    </div>
                </div>
            @endif
            @if(($seasonChampionAwards))
                <div class="section-info">
                    <div class="winner-block">

                                <h2 class="winner-heading">例行賽每週冠軍</h2>
                                <div class="winner-lists">
                                    @foreach ($seasonChampionAwards->awardDetails as $awardDetail)
                                        <div class="person">
                                            <div class="person-thumb">
                                                <img src="https://graph.facebook.com/{{$awardDetail->member->fb}}/picture?type=large" alt="">
                                            </div>
                                            <div class="person-name">{{$awardDetail->title}}
                                                <br> {{$awardDetail->member->name}}
                                                <span class="prize-value">{{$awardDetail->score}}分</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="winner-prize">{{$prizes[8]->title}}</div>

                    </div>
                </div>
            @endif
            @if(($playoffRankingAwards))
                <div class="section-info">
                    <div class="winner-block">

                                <h2 class="winner-heading">季後賽總排名</h2>
                                <div class="winner-lists">
                                    @foreach ($playoffRankingAwards->awardDetails as $awardDetail)
                                        <div class="person">
                                            <div class="person-thumb">
                                                <img src="https://graph.facebook.com/{{$awardDetail->member->fb}}/picture?type=large" alt="">
                                            </div>
                                            <div class="person-name">{{$awardDetail->title}}
                                                <br> {{$awardDetail->member->name}}
                                                <span class="prize-value">{{$awardDetail->score}}分</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="winner-prize">{{$prizes[1]->title}}</div>

                    </div>
                </div>
            @endif
            @if(($playoffChampionAwards))
                <div class="section-info">
                    <div class="winner-block">

                                <h2 class="winner-heading">季後賽每週冠軍</h2>
                                <div class="winner-lists">
                                    @foreach ($playoffChampionAwards->awardDetails as $awardDetail)
                                        <div class="person">
                                            <div class="person-thumb">
                                                <img src="https://graph.facebook.com/{{$awardDetail->member->fb}}/picture?type=large" alt="">
                                            </div>
                                            <div class="person-name">{{$awardDetail->title}}
                                                <br> {{$awardDetail->member->name}}
                                                <span class="prize-value">{{$awardDetail->score}}分</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="winner-prize">{{$prizes[2]->title}}</div>

                    </div>
                </div>
            @endif
            @if(($playoffRoundAwards))
                <div class="section-info">
                    <div class="winner-block">

                                <h2 class="winner-heading">季後賽每輪冠軍</h2>
                                <div class="winner-lists">
                                    @foreach ($playoffRoundAwards->awardDetails as $awardDetail)
                                        <div class="person">
                                            <div class="person-thumb">
                                                <img src="https://graph.facebook.com/{{$awardDetail->member->fb}}/picture?type=large" alt="">
                                            </div>
                                            <div class="person-name">{{$awardDetail->title}}
                                                <br> {{$awardDetail->member->name}}
                                                <span class="prize-value">{{$awardDetail->score}}分</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="winner-prize">{{$prizes[3]->title}}</div>

                    </div>
                </div>
            @endif
        </div>
        <canvas id="particles"></canvas>
    </main>
@endsection
