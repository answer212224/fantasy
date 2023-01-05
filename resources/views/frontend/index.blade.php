@extends('frontend.layouts.app')
@push('bottomScripts')
    <script>
        'use strict';

        function _toConsumableArray(arr) {
            if (Array.isArray(arr)) {
                for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) {
                    arr2[i] = arr[i];
                }
                return arr2;
            } else {
                return Array.from(arr);
            }
        }

        (function() {
            var modal = new tingle.modal({
                footer: true,
                stickyFooter: false,
                closeMethods: [],
                closeLabel: "關閉",
                cssClass: [],
                onClose: function() {
                    console.log('modal closed');
                },
                beforeClose: function() {
                    // here's goes some logic
                    // e.g. save content before closing the modal
                    return true; // close the modal
                    return false; // nothing happens
                }
            });

            modal.addFooterBtn('取消', 'tingle-btn tingle-btn--danger tingle-btn--pull-right', function() {
                modal.close();
            });

            // modal.addFooterBtn('中獎名單', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
            //   location.href = './info#winner';
            // });

            modal.setContent(
                '<h1>【3/18~3/24特別活動開跑！】</h1><p>在活動期間內選擇James Harden, Derrick Rose, Damian Lillard, Donovan Mitchell...等adidas球員，即有機會獲得Harden Vol. 3籃球鞋一雙！</p><style>.adidas-container { display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row wrap;flex-flow:row wrap;-ms-flex-pack:distribute;justify-content:space-around } .adidas-container img{ width: 33%; max-width: 100% }</style> <div class="adidas-container"><img src="https://nba.udn.com/assets/fantasy/img/harden1.jpg" alt=""><img src="https://nba.udn.com/assets/fantasy/img/harden2.jpg" alt=""><img src="https://nba.udn.com/assets/fantasy/img/harden3.jpg" alt=""></div>'
            );
            //modal.open();


            var players = document.querySelectorAll('.player');
            var playersId = [].concat(_toConsumableArray(players)).map(function(el) {
                return el.dataset.id;
            });
            var host = '//nba.udn.com/nba_data';
            fetch(host + "/players/" + window.NBA_SEASON_STATUS + "/" + JSON.stringify(playersId)).then(function(res) {
                return res.json();
            }).then(function(data) {
                data.players.forEach(function(el, i) {
                    var playerHolder = document.querySelector('.player[data-id="' + el.playerId + '"]');
                    playerHolder.querySelector('.points').textContent = Number(el.points);
                    playerHolder.querySelector('.rebounds').textContent = Number(el.rebounds);
                    playerHolder.querySelector('.assists').textContent = Number(el.assists);
                    playerHolder.querySelector('.steals').textContent = Number(el.steals);
                    playerHolder.querySelector('.blocks').textContent = Number(el.blocks);
                    playerHolder.querySelector('.turnovers').textContent = Number(el.turnovers);
                });
            });
        })();
    </script>
@endpush

@section('content')
    <main class="main">
        <div class="container main-container index-container">
            <div class="kv-container">
                <div class="action">
                    @isset($member)
                        <!--no login render-->
                        <div class="login-button">
                            <a href="{{ env('APP_URL') }}/member" class="btn btn-transparent btn-play">即刻開打</a>
                            <!-- <a href="info#winner" class="btn btn-transparent btn-serial">得獎名單</a> -->
                        </div>
                    @endisset
                    @empty($member)
                        <div class="no-login">
                            <a href="{{ env('APP_URL') }}/fblogin" class="btn btn-fb">
                                <i class="i-fb-round"></i><span>以 Facebook 帳號繼續</span>
                            </a>
                        </div>
                    @endempty
                </div>

                <div id='div-gpt-ad-1541142132668-0' style='height:90px; width:728px;' class="desktop-ads banner-ads">
                    <script>
                        googletag.cmd.push(function() {
                            googletag.display('div-gpt-ad-1541142132668-0');
                        });
                    </script>
                </div>

                <div id='div-gpt-ad-1541142159376-0' style='height:100px; width:300px;' class="mobile-ads banner-ads">
                    <script>
                        googletag.cmd.push(function() {
                            googletag.display('div-gpt-ad-1541142159376-0');
                        });
                    </script>
                </div>

            </div>


            <!--common section-->
            <section class="common-section">
                <h1 class="heading" id="news">焦點新聞 <span class="en">news</span></h1>
                <div class="section-info section-flex">
                    @foreach ($fantasyNews as $key => $value)
                        @if ($key == 0)
                            <figure class="figure">
                                <img src="{{ $value['url'] }}" alt="">
                                <figcaption>
                                    <a href="{{ $value['titleLink'] }}">
                                        <span class="title">{{ $value['title'] }}</span>
                                        <time>{{ substr($value['time']['date'], 0, 10) }}</time>
                                    </a>
                                </figcaption>
                            </figure>
                            <div class="news-holder">
                            @else


                                <a href="{{ $value['titleLink'] }}" class="news" target="_blank">
                                    <span class="title">{{ $value['title'] }}</span>
                                    <time>{{ substr($value['time']['date'], 0, 10) }}</time>
                                </a>
                        @endif

                    @endforeach

                    <a href="{{ $fantasyRankNew['titleLink'] ?? null }}" class="news" target="_blank">
                        <span class="title">{{ $fantasyRankNew['title'] ?? null }}</span>
                        <time>{{ substr($fantasyRankNew['time']['date'] ?? null, 0, 10) }}</time>
                    </a>

                </div>
        </div>
        </section>


        <!--common section-->
        <section class="common-section">
            <h1 class="heading" id="players">最夯球員 <span class="en">top players </span></h1>
            <div class="section-info section-flex">
                @foreach ($topPlayers as $topPlayer)
                    <div class="section-player">
                        <a href="//tw.global.nba.com/players/#!/{{ $topPlayer->fullName }}" class="player"
                            data-id="{{ $topPlayer->nba_player_id }}">
                            <div class="player-img"><img
                                    src="//nba.udn.com/assets/img/players/{{ $topPlayer->nba_player_id }}.png" alt="">
                            </div>
                            <div class="player-stats">
                                <h3 class="player-heading"> <span class="player-no east">{{ $topPlayer->jersey }}</span>
                                    <span class="player-name-first">{{ $topPlayer->first_name }}</span> <span
                                        class="player-name-last">{{ $topPlayer->last_name }}</span>
                                </h3>
                                <h6 class="position-team"> <span
                                        class="region {{ $topPlayer->team->conference }}">{{ $topPlayer->team->conferenceZH }}</span>
                                    <span class="team-name">{{ $topPlayer->team->team_name_zh }}</span>
                                    <span class="player-position">
                                        @foreach ($topPlayer->postions as $postion)
                                            {{ $postion->zHtitle }}
                                        @endforeach
                                    </span>
                                </h6>
                                <section class="player-score">
                                    <span class="points"></span>
                                    <span class="rebounds"></span> <span class="assists"></span>
                                    <span class="steals"></span>
                                    <span class="blocks"></span>
                                    <span class="turnovers"></span>
                                </section>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        <!--common section-->
        <section class="common-section">

            <h1 class="heading" id="rank">積分風雲榜 <span class="en">expert rankings </span></h1>
            <div class="section-info section-flex section-tp">


                @if (count($weeklyRankingMembers))
                    <section class="ranking-holder">
                        <h2 class="ranking-heading" data-tooltip="上次更新時間為：{{ $weeklyRankingMembers[0]['now'] ?? '' }}">本週排名 
                            <span class="en">Weekly Rankings</span>
                        </h2>
                        <div class="ranking-list">
                            @foreach ($weeklyRankingMembers as $weeklyRankingMember)
                                <div class="rank">
                                    <div class="fb-thumbs"><img
                                            src="//graph.facebook.com/{{ $weeklyRankingMember['member']->fb }}/picture?type=large"
                                            alt="">
                                    </div>
                                    <div class="rank-details">
                                        <div class="facebook-name">{{ $weeklyRankingMember['member']->name }}</div>
                                        <div class="score">{{ $weeklyRankingMember['total'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (count($overallRankingMembers))
                    <section class="ranking-holder">
                        <h2 class="ranking-heading" data-tooltip="上次更新時間為：{{ $overallRankingMembers[0]['now'] ?? '' }}">總積分排名
                            <span class="en">total rankings</span>
                        </h2>
                        <div class="ranking-list">
                            @foreach ($overallRankingMembers as $overallRankingMember)
                                <div class="rank">
                                    <div class="fb-thumbs"><img
                                            src="//graph.facebook.com/{{ $overallRankingMember['member']->fb }}/picture?type=large"
                                            alt=""></div>
                                    <div class="rank-details">
                                        <div class="facebook-name">{{ $overallRankingMember['member']->name }}</div>
                                        <div class="score">{{ $overallRankingMember['total'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

            </div>
        </section>

        </div>
        <canvas id="particles"></canvas>
    </main>
@endsection
