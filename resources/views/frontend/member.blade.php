@extends('frontend.layouts.app')
@push('css')
@endpush
@push('topScripts')
    <script>
        var tomorrow = "{{ $tomorrow }}";
        var playState = @json($playState, JSON_UNESCAPED_UNICODE);
        var previousPrediction = @json($previousPrediction, JSON_UNESCAPED_UNICODE);
        var injuredPlayers = @json($injuredPlayers, JSON_UNESCAPED_UNICODE);
        var _NBA_STATE = @json($nba, JSON_UNESCAPED_UNICODE);
        var historyObject = @json($historyObjects, JSON_UNESCAPED_UNICODE);
        var date = @json($date, JSON_UNESCAPED_UNICODE);
    </script>
@endpush
@push('bottomScripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="//unpkg.com/vue2-simplert@0.7.1/dist/simplert.bundle.js"></script>
    <script src="{{ asset('js/v-tooltip.min.js') }}"></script>
    <script src="{{ asset('js/vue-carousel.min.js') }}"></script>
    <script src='{{ asset('js/v-calendar.min.js') }}'></script>
    <script src="{{ asset('js/fantasy.js') }}"></script>

    <script src='https://tw.global.nba.com/scripts/extra/iframe/resizelistener.js'></script>
    <script>
        IframeResizeListener.allowedDomains = ["tw.glob-qa2.nba.com", "tw.glob-prev3.nba.com", "tw.global.nba.com"];
        IframeResizeListener.iframeId = 'scoreboard-iframe';
        IframeResizeListener.iframePath = '/articles/licensee_widget_scoreboard.html';
        IframeResizeListener.debug = true;
        IframeResizeListener.listen(); /* this is a closure it is bound to the current values */
    </script>
@endpush

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

            <div class="user-score common-section">
                <h1 class="heading">我的積分 <span class="en">my score & rank </span></h1>
                <div class="section-info section-fantasy" id="historyVue">

                    <simplert :useRadius="true" :useIcon="true" ref="simplert"></simplert>


                    <div class="user-section">

                        <div class="user-info">
                            <div class="fb-thumbs">
                                <img src="https:////graph.facebook.com/{{ $member->fb }}/picture?type=large" alt="">
                            </div>

                            <div class="fb-details">
                                <div class="fb-items">
                                    Hi, <span class="name blue">{{ $member->name }}</span> <br>
                                    Welcome to Fantasy!
                                </div>

                                <div class="score-today">
                                    本日積分 <span class="score blue">{{ $todayHistory ? $todayHistory->total : 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="score-total score-holder">
                            <h5>總積分</h5>
                            <div class="total">{{ $memberTotal }} 分</div>
                        </div>

                        <div class="rank-total score-holder">
                            <h5>總排名</h5>
                            <div class="total">
                                {{ $member->rank }} 名
                            </div>
                        </div>


                    </div>

                    <div class="user-section calendar">
                        <h2 class="blue">歷史積分查詢</h2>

                        <v-calendar :attributes='attrs' :min-date="minDate" :max-date="maxDate" @dayclick='dayClicked'>
                        </v-calendar>
                    </div>



                    <div class="user-section user-history"
                        :class="{
                        open: state
                    }">
                        <table class="players-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="mobile-row">位置</th>
                                    <th>得分</th>
                                    <th>籃板</th>
                                    <th>助攻</th>
                                    <th class="mobile-row">抄截</th>
                                    <th class="mobile-row">阻攻</th>
                                    <th class="mobile-row">失誤</th>
                                    <th>總分</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="player in currentData.players">
                                    <td class="player-heading">
                                        <span class="team-logo" :class="player.teamAbbr.toLowerCase()"></span>
                                        <span class="player-no" :class="player.region">@{{ player.jersey }}</span>
                                        <span class="player-name-first">@{{ player.firstname }}</span>
                                        <span class="player-name-last">@{{ player.lastname }}</span>
                                    </td>
                                    <td class="mobile-row">
                                        <span class="position"
                                            v-for="position in player.position">@{{ position |
    position }}</span>
                                    </td>
                                    <td>@{{ player.points }}</td>
                                    <td>@{{ player.rebs }}</td>
                                    <td>@{{ player.assists }}</td>
                                    <td class="mobile-row">@{{ player.steals }}</td>
                                    <td class="mobile-row">@{{ player.blocks }}</td>
                                    <td class="mobile-row">@{{ player.turnovers }}</td>
                                    <td>@{{ player.scores }}</td>
                                </tr>

                            </tbody>
                        </table>


                        <div class="user-stats">
                            <span>
                                @{{ currentData.date }} 當日積分
                                <span class="score">@{{ totalScore }}分</span>
                            </span>
                            <span>
                                當日排名
                                <span class="score">@{{ currentData.rank }}名</span>
                            </span>

                        </div>
                    </div>

                </div>

            </div>

            <div class="scoreboard common-section" style="background: white; padding: 10px 0;">
                <iframe id="scoreboard-iframe" src="//tw.global.nba.com/articles/licensee_widget_scoreboard.html"
                    scrolling="no" frameborder="0" height="120px" width="100%"></iframe>
            </div>

            <div class="fantasy-selection common-section" id="fantasyVue">
                <h1 class="heading">選擇隔日比賽出場球員 <span class="en">select your player </span></h1>
                <div class="section-info section-fantasy" v-cloak>

                    <div class="user-section">

                        <div class="user-info user-step">
                            <ul class="steps">
                                <li class="step-item">請先選擇球員位置</li>
                                <li class="step-item">再點選您指定的球員</li>
                                <li class="step-item">選定後再點選一次球員位置即可</li>
                            </ul>


                            <div class="button-holder">
                                <a href="#" class="btn btn-grey" @click.prevent="insertPreviousData"
                                    :class="{
                                            disabled: !previousData.length
                                        }">

                                    <i class="i-spin5 animate-spin" v-if="loading"></i><span v-if="!loading">匯入上筆資料</span>
                                </a>
                            </div>
                        </div>

                        <div class="energy-total score-holder">
                            <h5>總能力值</h5>

                            <div class="total total-right">
                                430
                            </div>
                        </div>

                        <div class="energy-remaining score-holder">
                            <h5>可用能力值</h5>

                            <div class="total total-right">
                                <span
                                    :class="{
                                    red: ratingCalculate < 50
                                }">@{{ ratingCalculate }}</span>


                            </div>
                        </div>


                    </div>

                    <div class="user-section">
                        <span class="user-tips">提醒您：<small class="user-tips">1.比賽日以NBA官方公布之賽程為主</small> <small
                                class="user-tips">2.每個比賽日前一天選取的球員才會計算積分</small></span>

                    </div>

                    <div class="user-section user-selection" v-if="matchState">
                        <!-- <div class="user-section user-selection"> -->

                        <player v-for="(player,index) in players" :playerdata="player" :index="index"
                            @trigger="sibblingCommunication(this ,$event, index)" :filtered="players"></player>


                    </div>


                    <div class="button-holder center" v-if="matchState">
                        <!-- <div class="button-holder center"> -->
                        <div class="red error" v-if="error !== ''">@{{ error }}</div>
                        <a href="#" class="btn btn-blue" @click.prevent="postData">選好送出</a>
                        <a href="#" class="btn btn-grey" @click.prevent="resetData">重設</a>
                    </div>

                    <p style="text-align: center; padding: 10px 0; color: #ff0000;" v-if="!matchState">
                        @{{ tomorrowDate }}
                        無進行比賽</p>


                </div>


                <div class="overlay"
                    :class="{
                                open: overlayState
                            }"
                    @click.self="closeBtn($event)">
                    <div class="overlay-container">
                        <span class="btn btn-close" @click.stop="closeBtn"></span>
                        <h3 class="overlay-heading">確認送出</h3>
                        <div class="overlay-info">
                            <div class="ads">
                                <!-- /4576170/NBA_Fantasy/NBA_Fantasy_PC_Mobile_300x250 -->
                                <div id='div-gpt-ad-1541142108937-0' style='height:250px; width:300px;'>
                                    <script>
                                        googletag.cmd.push(function() {
                                            googletag.display('div-gpt-ad-1541142108937-0');
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="event-info">
                                <h4><span>提醒您</span></h4>
                                <ul>
                                    <li>傷兵球員與被淘汰的隊伍球員將不計算積分</li>
                                    <li>下一場比賽日以NBA官方公布之賽程為主</li>
                                    <li>每個比賽日前一天選取的球員才會計算積分</li>
                                </ul>
                            </div>

                            <div class="terms">
                                <h4>【其他注意事項】</h4>
                                <ol>
                                    <li>NBA
                                        聯盟相關的人員及球隊的任何成員、活動任何型式的贊助商以及宣傳的相關人員(包括相關的代理商與公關公司)，或者是任何跟上述這些人員相關的家庭或同居成員皆不能參加此活動或者是贏取活動獎項。
                                    </li>
                                    <li>獎項不能隨意轉換或變現，也不可交換或想改變獎項內容，但如果獎項目前因為某種原因無法取得可由贊助商自行決定是否更換，但更換之項目必須為等值商品。得獎者必須要自行支付所有相應產生的稅金以及其他可能之花費。
                                    </li>
                                    <li>所有活動相關辦法，皆以本網頁公佈為主，獎品項目則依實物為主。</li>
                                    <li>網友填寫資料之目的係作為確認身分，以便進行活動。聯合線上保證登入資料不洩漏予第三人，亦不進行前述目的範圍以外之利用。未依規定授權臉書帳號及公開資訊（包含：姓名、E-Mail等），致網友有任何損失者，聯合線上恕不負責。
                                    </li>
                                    <li>本活動得獎資料如有不符合資格或取消者皆不遞補。所有獎項皆不重複得獎(包括 同IP)，如有發現偽造資格或不法得獎者，聯合線上皆有權取消得獎資格。</li>
                                    <li>
                                        參加者於參加本活動同時，即同意接受本活動之活動辦法與注意事項規範，並須遵守聯合線上的服務條款，若發現有使用網頁機器人參與活動違反之規定，聯合線上得取消其參加或得獎資格，並就因此所生之損害，得向參加者請求損害賠償。
                                    </li>
                                    <li>參加者應保證所有填寫或提出之資料均為真實且正確，且未冒用或盜用任何第三人之資料。如有不實 或不正確之情
                                        事，聯合線上得取消參加或得獎資格。如因此致聯合線上無法通知其得獎訊息時，聯合線上不負任何法律責任，且如有致損害於聯合
                                        線上或其他任何第三人，參加者應負一切相關責任。
                                    </li>
                                    <li>得獎者應於聯合線上通知之期限內回覆確認同意領取獎品，並提供聯合線上所要求之完整領獎文件， 逾期視為棄權。</li>
                                    <li>如有任何因電腦、網路、電話、技術或不可歸責於聯合線上之事由，而使參加者所寄出或登錄之資料 有遲延、遺失、
                                        錯誤、無法辨識或毀損之情況致使參加者無法參加活動時，聯合線上不負任何法律責任，參加者亦不得因此異議。
                                    </li>
                                    <li>如本活動因不可抗力或其他特殊原因致無法舉行時，聯合線上有權決定取消、終止、修改或暫停本活動。</li>
                                    <li>活動獎項以公佈於本網站上的資料為準，如遇不可抗拒或非可歸責於聯合線上之因素，致無法提供原訂獎項時，聯合線上保留更換其他等值獎項之權利。</li>
                                    <li>依中華民國稅法規定，獎項金額若超過新台幣 1,000
                                        元，得獎人須依規定填寫並繳交相關中獎收據。得獎者若無法依相關規定配合主辦單位辦理，則視為自動棄權，不具得獎資格。獎項價值超過新台幣 20,000
                                        元者，中獎者依法需自付 10% 稅額
                                        (海外人士或不具中華民國身分者，機會中獎所得稅為20%)。贈品廠商將開立各類所得稅扣繳憑單給中獎者。如果得獎者不願意給付得獎商品之稅額，則視為得獎者自動棄權，不具得獎資格。
                                    </li>
                                    <li>參加者如因參加本活動或因活動獎項而遭受任何損失，聯合線上及相關之母公司、子公司、關係企業、員工、及代理商不負任何責任。一旦得獎者領取獎品後，若有遺失或被竊，聯合線上或贊助廠商等不發給任何證明或補償。
                                    </li>
                                    <li>獎項寄送地區僅限台、澎、金、馬，聯合線上不處理郵寄獎品至海外地區之事宜。本活動之獎品不得轉換、轉讓或折換現金。</li>
                                    <li>參加者（包含相關繼承者、執行者或管理者）對於獲得的贈品，不可對 NBA
                                        相關單位以及其相關人員（主席、官員、員工、代理商、關係企業、廣告商、公關、贈品贊助商）提出質疑、要求、損壞賠償，或者是做出任何行為或是具有抗爭事實（對於人或者是活動及贈品）的行為，亦不可鼓勵他人和自己去發生對於贈品要求補償的行為。
                                    </li>
                                    <li>其他未盡事宜，悉依主辦單位相關規定。若有任何活動問題，請來信 <a
                                            href="mailto:vaservice@udn.com">vaservice@udn.com</a> 。
                                    </li>
                                </ol>

                                <ul class="info-smaller">
                                    <li>udn 聯合線上股份有限公司（以下簡稱本公司）茲依據個人資料保護法（以下簡稱個資法）之相關規定，告知以下個資宣告事項，敬請詳閱：</li>
                                    <li>蒐集個資機關名稱：udn 聯合線上股份有限公司</li>
                                    <li>蒐集目的：辦理「Regular Season Fantasy」網路活動，參加、中獎聯繫及稅務相關單據寄送事宜。</li>
                                    <li>個人資料項目：姓名、臉書帳號、email、手機、郵件地址。</li>
                                    <li>
                                        個人資料利用之期間、地區、對象及方式：
                                        <ol>
                                            <li>期間：中華民國107 年 11 月 1 日至 111 年 9 月 30 日</li>
                                            <li>地區：台灣地區。</li>
                                            <li>對象：活動參加者。</li>
                                            <li>方式：電子文件。</li>
                                        </ol>
                                    </li>
                                    <li>
                                        台端依據個資法第三條規定得行使之權利及方式：
                                        <ol>
                                            <li>資料使用期間，權利人得隨時向本公司請求查詢、閱覽、複製副本、刪除、修改其所提供之個人資料。</li>
                                            <li>所獲獎品其價值超過新台幣20,000元以上者，依所得稅法規定，中獎者須先行支付獎品
                                                價值10%之稅金，由活動小組向有關稅務機關代繳所得稅額，其中獎者之相關個人資料須
                                                由本公司存查。權利人無法為前項刪除個人資料之請求。
                                            </li>
                                        </ol>
                                    </li>
                                    <li>台端得自由選擇是否提供相關個人資料，惟若拒絕提供相關個人資料者，將無法參加本活動。</li>
                                </ul>
                            </div>

                            <div class="terms-agreement">
                                <input type="checkbox" id="agreement" v-model="agreement">
                                <label for="agreement">我已詳讀<a href="//nba.udn.com/fantasy/info" target="_blank">注意事項
                                    </a>
                                    並且願意遵守以上規定</label>
                            </div>
                        </div>

                        <div class="button-holder center">
                            <a href="#" class="btn btn-blue" @click.stop.prevent="confirmPost"><i
                                    class="i-spin5 animate-spin" v-if="loading"></i><span v-if="!loading">確認送出</span></a>
                            <a href="#" class="btn btn-grey" @click.stop.prevent="closeBtn">取消</a>
                        </div>
                    </div>
                </div>

                <simplert :useRadius="true" :useIcon="true" ref="simplert"></simplert>

            </div>
        </div>
        <canvas id="particles"></canvas>
    </main>
@endsection
