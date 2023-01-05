"use strict";

function _typeof(obj) {
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
        _typeof = function _typeof(obj) {
            return typeof obj;
        };
    } else {
        _typeof = function _typeof(obj) {
            return obj &&
                typeof Symbol === "function" &&
                obj.constructor === Symbol &&
                obj !== Symbol.prototype
                ? "symbol"
                : typeof obj;
        };
    }
    return _typeof(obj);
}

(function () {
    "use strict";
    var base = document
        .querySelector("meta[property='og:url']")
        .getAttribute("content");
    var getHistoryUrl = base + "/member/search?id=";
    var postUserData = base + "/member";

    Vue.use(VTooltip);
    VTooltip.enabled = window.innerWidth > 768;
    Vue.filter("position", function (value) {
        switch (value.toLowerCase()) {
            case "g":
                return "後衛";

            case "f":
                return "前鋒";

            case "c":
                return "中鋒";

            default:
                return "錯誤";
        }
    });
    Vue.filter("region", function (value) {
        return value === "東區" ? "east" : "west";
    });
    Vue.filter("uppercase", function (val) {
        return typeof val !== "undefined" ? val.toUpperCase() : val;
    });
    Vue.component("player", {
        props: ["playerdata", "index", "filtered"],
        components: {
            carousel: VueCarousel.Carousel,
            slide: VueCarousel.Slide,
            Simplert: Simplert,
        },
        template:
            '\n\t\t\t\t<section\n\t\t\t\t\tclass="player-position"\n\t\t\t\t\t:class="{\n\t\t\t\t\t\topen: playerdata.state\n\t\t\t\t\t}"\n\t\t\t\t>\n\t\t\t\t\t<div\n\t\t\t\t\t\tclass="selector"\n\t\t\t\t\t\t@click="emitOpenEvent"\n\t\t\t\t\t\t:class="{\n\t\t\t\t\t\t\tselected: playerdata.player.lastName\n\t\t\t\t\t\t}"\n\t\t\t\t\t>\n\t\t\t\t\t\t<span class="position-name">\u7403\u54E1\u4F4D\u7F6E  {{playerdata.position | position}} </span>\n\n\t\t\t\t\t\t<section class="player-selected">\n\t\t\t\t\t\t\t<div class="player-heading" v-if="playerdata.player.lastName" >\n\t\t\t\t\t\t\t\t<span class="team-name">{{playerdata.player.team | uppercase}}</span>\n\t\t\t\t\t\t\t\t<span class="player-no">{{playerdata.player.jerseyNo}}</span>\n\t\t\t\t\t\t\t\t<span class="player-name-first">{{playerdata.player.firstName}} </span>\n\t\t\t\t\t\t\t\t<span class="player-name-last">{{playerdata.player.lastName}} </span>\n\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t\t<div class="energy-used" v-if="playerdata.player.lastName" >\n\t\t\t\t\t\t\t\t\u82B1\u8CBB <span class="red">{{playerdata.player.rating}}</span> \u80FD\u529B\u503C\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t<span class="html-sign plus"></span>\n\t\t\t\t\t\t</section>\n\n\t\t\t\t\t</div>\n\n\n\t\t\t\t\t<div class="player-selection">\n\t\t\t\t\t\t<carousel :navigationEnabled="true" :perPageCustom="[[480, 3], [900, 5]]" :paginationPadding="5" :scrollPerPage="true">\n\t\t\t\t\t\t\t\t<slide v-for="team in teams" :class="{selected: selectedTeam === team}">\n\t\t\t\t\t\t\t\t\t<img :src="\'https://nba.udn.com/assets/img/teams/\' + team.toUpperCase() + \'.svg\'" @click="toggleTeam(team)" class="team-thumb" >\n\t\t\t\t\t\t\t\t</slide>\n\t\t\t\t\t\t</carousel>\n\n\t\t\t\t\t\t<div v-show="playerView">\n\t\t\t\t\t\t\t<table class="players-table">\n\t\t\t\t\t\t\t\t<thead>\n\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t<th></th>\n\t\t\t\t\t\t\t\t\t\t<th class="mobile-row">\u4F4D\u7F6E</th>\n\t\t\t\t\t\t\t\t\t\t<th class="average">\u5F97\u5206</th>\n\t\t\t\t\t\t\t\t\t\t<th class="average">\u7C43\u677F</th>\n\t\t\t\t\t\t\t\t\t\t<th class="average">\u52A9\u653B</th>\n\t\t\t\t\t\t\t\t\t\t<th class="average mobile-row">\u6284\u622A</th>\n\t\t\t\t\t\t\t\t\t\t<th class="average mobile-row">\u963B\u653B</th>\n\t\t\t\t\t\t\t\t\t\t<th class="average mobile-row">\u5931\u8AA4</th>\n\t\t\t\t\t\t\t\t\t\t<th>\u80FD\u529B\u503C</th>\n\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t</thead>\n\t\t\t\t\t\t\t\t<tbody>\n\t\t\t\t\t\t\t\t\t<tr\n\t\t\t\t\t\t\t\t\t\tv-for="player in filteredPlayers"\n\t\t\t\t\t\t\t\t\t\t@click="selectPlayer(player)"\n\t\t\t\t\t\t\t\t\t\t:data-id="player.playerId"\n\t\t\t\t\t\t\t\t\t\tclass="player"\n\t\t\t\t\t\t\t\t\t\t:class="{ selected: player.selected, injured: player.injured }"\n\t\t\t\t\t\t\t\t\t\tv-tooltip.top-center="{\n\t\t\t\t\t\t\t\t\t\t\tcontent: tooltipsContent(player).content,\n\t\t\t\t\t\t\t\t\t\t\tclasses: tooltipsContent(player).class\n\t\t\t\t\t\t\t\t\t\t}"\n\t\t\t\t\t\t\t\t\t>\n\t\t\t\t\t\t\t\t\t\t<td class="player-heading">\n                      <a\n\t\t\t\t\t\t\t\t\t\t\t\t:href="\'https://tw.global.nba.com/players/#!/\'+ player.code"\n\t\t\t\t\t\t\t\t\t\t\t\ttarget="_blank"\n\t\t\t\t\t\t\t\t\t\t\t\t@click="stopPropa($event)"\n\t\t\t\t\t\t\t\t\t\t\t\ttitle="\u5230\u7403\u54E1\u9801\u9762"\n\t\t\t\t\t\t\t\t\t\t\t\talt="\u5230\u7403\u54E1\u9801\u9762"\n\t\t\t\t\t\t\t\t\t\t\t\t>\n\t\t\t\t\t\t\t\t\t\t\t  <img :src="player.img" class="player-thumb">\n\t\t\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t\t\t<span class="player-no west">{{player.jerseyNo}}</span>\n\t\t\n                      <span class="player-name-first">{{player.firstName}}</span>\n                      <span class="player-name-last">{{player.lastName}}</span>\n\t\t\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\t\t</td>\n\n\t\t\t\t\t\t\t\t\t\t<td class="mobile-row">\n\t\t\t\t\t\t\t\t\t\t\t<span v-for="position in player.position" class="position">{{position | position}}</span>\n\t\t\t\t\t\t\t\t\t\t</td>\n\n\t\t\t\t\t\t\t\t\t\t<td class="points">{{player.points}}</td>\n\t\t\t\t\t\t\t\t\t\t<td class="rebounds">{{player.rebounds}}</td>\n\t\t\t\t\t\t\t\t\t\t<td class="assists">{{player.assists}}</td>\n\t\t\t\t\t\t\t\t\t\t<td class="steals mobile-row">{{player.steals}}</td>\n\t\t\t\t\t\t\t\t\t\t<td class="blocks mobile-row">{{player.blocks}}</td>\n\t\t\t\t\t\t\t\t\t\t<td class="turnovers mobile-row">{{player.turnovers}}</td>\n\t\t\t\t\t\t\t\t\t\t<td>{{player.rating}}</td>\n \n\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t<tbody>\n\t\t\t\t\t\t\t</table>\n\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t</section>\n\t\t\t\t',
        data: function data() {
            return {
                players: [],
                teams: [],
                selectedTeam: "",
                playerView: false,
                updated: 0,
            };
        },
        created: function created() {
            var _this = this;

            this.players = Object.assign(
                [],
                _NBA_STATE.filter(function (player) {
                    if (!_this.teams.includes(player.team))
                        _this.teams.push(player.team);
                    return player.position.includes(_this.playerdata.position);
                })
            );
        },
        computed: {
            filteredPlayers: function filteredPlayers() {
                var _this2 = this;

                // double mapping for filtering duplicate selection
                return this.players
                    .filter(function (player) {
                        if (player.team === _this2.selectedTeam) {
                            if (!player.hasOwnProperty("img")) {
                                var _that = _this2;
                                getLocalImage(player.playerId, function (img) {
                                    player.img = img;

                                    _that.$forceUpdate();
                                });
                            }

                            return player;
                        }
                    })
                    .map(function (player) {
                        // filter selected
                        var found = _this2.filtered.find(function (el) {
                            return el.player.playerId === player.playerId;
                        });

                        player.selected =
                            typeof found !== "undefined" ? true : false;
                        return player;
                    })
                    .map(function (player) {
                        // filter injured
                        var found = injuredPlayers.find(function (el) {
                            return el === player.playerId;
                        });
                        player.injured =
                            typeof found !== "undefined" ? true : false;
                        return player;
                    });
            },
        },
        methods: {
            tooltipsContent: function tooltipsContent(player) {
                if (player.injured) {
                    return {
                        content: "此球員已受傷",
                        class: "injured",
                    };
                }

                if (player.selected) {
                    return {
                        content: "此球員已被選取",
                        class: "selected",
                    };
                }

                return {
                    content: "選取此球員",
                    class: false,
                };
            },
            emitOpenEvent: function emitOpenEvent() {
                this.$emit("trigger", {
                    type: "open",
                    index: this.index,
                });
            },
            toggleTeam: function toggleTeam(team) {
                //team players data fetch if not available?
                var _that = this;

                this.selectedTeam = team;
                this.playerView = true;
                var selectedIds = this.filteredPlayers.map(function (el) {
                    return el.playerId.toString();
                });

                var host = "https://nba.udn.com/nba_data";
                fetch(
                    host +
                        "/players/" +
                        window.NBA_SEASON_STATUS +
                        "/" +
                        JSON.stringify(selectedIds)
                )
                    .then(function (res) {
                        return res.json();
                    })
                    .then(function (data) {
                        data.players.forEach(function (el, i) {
                            _that.players = _that.players.map(function (
                                player
                            ) {
                                if (
                                    player.playerId.toString() === el.playerId
                                ) {
                                    player.rebounds = Number(el.rebounds);
                                    player.points = Number(el.points);
                                    player.assists = Number(el.assists);
                                    player.blocks = Number(el.blocks);
                                    player.turnovers = Number(el.turnovers);
                                    player.steals = Number(el.steals);
                                }

                                return player;
                            });
                        });
                    });
            },
            selectPlayer: function selectPlayer(player) {
                if (player.selected || player.injured) return;
                this.selected = player;
                this.$emit("trigger", {
                    type: "playerSelection",
                    player: player,
                });
            },
            stopPropa: function stopPropa(e) {
                e.stopPropagation();
            },
        },
    });
    var fantasyVue = new Vue({
        el: "#fantasyVue",
        data: {
            overlayState: false,
            error: "",
            matchState: window.playState,
            tomorrowDate: window.tomorrow,
            loading: false,
            agreement: false,
            previousData: [],
            previousDataDate: window.date.prevPredict,
            todayDate: window.date.today,
            players: [
                {
                    position: "G",
                    player: {},
                    state: false, //open state
                },
                {
                    position: "G",
                    player: {},
                    state: false,
                },
                {
                    position: "F",
                    player: {},
                    state: false,
                },
                {
                    position: "F",
                    player: {},
                    state: false,
                },
                {
                    position: "C",
                    player: {},
                    state: false,
                },
            ],
            score: 430,
        },
        created: function created() {
            var _this3 = this;

            previousPrediction.forEach(function (el, i) {
                _this3.previousData.push(
                    _NBA_STATE.find(function (player) {
                        return player.playerId === el;
                    })
                );
            });

            if (this.previousDataDate === this.todayDate) {
                this.insertPreviousData();
            }
        },
        computed: {
            ratingCalculate: function ratingCalculate() {
                var culmulative = this.players.map(function (el, i) {
                    return _typeof(el.player) === "object" &&
                        el.player.hasOwnProperty("firstName")
                        ? parseInt(el.player.rating)
                        : 0;
                });
                var calculate = (this.score =
                    430 -
                    culmulative.reduce(function (acc, currentValue) {
                        return acc + currentValue;
                    }));
                return calculate;
            },
            checkError: function checkError() {
                var state = this.players.map(function (el, i) {
                    return Object.keys(el.player).length === 0 &&
                        el.player.constructor === Object
                        ? false
                        : true;
                });
                var checkAll = state.every(function (value) {
                    return value === true;
                });
                if (checkAll) this.error = "";
                return checkAll;
            },
        },
        methods: {
            closeBtn: function closeBtn() {
                // if(e.target !== $)
                this.overlayState = false;
            },
            confirmPost: function confirmPost() {
                var _this4 = this;
                if (this.loading) return;
                if (!this.agreement) {
                    this.$refs.simplert.openSimplert({
                        title: "錯誤",
                        message:
                            '請記得勾選<span style="text-decoration: underline;">注意事項</span>',
                        customCloseBtnText: "確認",
                        disableOverlayClick: true,
                        customIconUrl: "",
                    });
                    return;
                }

                var selectedData = this.players.map(function (item) {
                    return {
                        playerID: item.player.playerId,
                        position: item.position,
                    };
                });
                this.loading = true; // fetch here

                console.log(selectedData);
                fetch(postUserData, {
                    method: "post",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        players: selectedData,
                    }),
                })
                    .then(function (res) {
                        return res.text();
                    })
                    .then(function (data) {
                        _this4.loading = false;

                        if (data.trim() !== "ok") {
                            _this4.$refs.simplert.openSimplert({
                                title: "錯誤",
                                message: data,
                                customCloseBtnText: "確認",
                                disableOverlayClick: true,
                                customIconUrl: "",
                            });
                        } else {
                            _this4.$refs.simplert.openSimplert({
                                title: "感謝參與",
                                // message: `謝謝參與，祝您獲得高分！ <br>（此積分將在明天被計算）`,
                                message:
                                    '\u8B1D\u8B1D\u53C3\u8207\uFF0C\u795D\u60A8\u7372\u5F97\u9AD8\u5206\uFF01 <br>\uFF08\u6B64\u7A4D\u5206\u5C07\u5728\u660E\u5929\u88AB\u8A08\u7B97\uFF09<p></p>\n                \t\t<div><a href="https://member.udn.com/member/login.jsp?site=bd_fantasy&redirect=https://nba.udn.com/fantasy"><img src="https://nba.udn.com/assets/fantasy/img/300x250.gif" /></a></div>',
                                // customCloseBtnText: '確認',
                                disableOverlayClick: true,
                                customIconUrl: "",
                                hideAllButton: true,
                                showXclose: true,
                            });

                            _this4.closeBtn();
                        }
                    })
                    ["catch"](function (err) {
                        _this4.loading = false;
                        return console.warn(err);
                    });
            },
            resetData: function resetData() {
                this.players = this.players.map(function (item) {
                    return {
                        position: item.position,
                        player: {},
                        state: false,
                    };
                });
                this.score = 430;
            },
            postData: function postData() {
                if (this.score < 0) {
                    this.error = "您的能力值超過囉，請重新選擇球員。";
                    return;
                }

                if (!this.matchState) {
                    this.error = "明天沒有比賽，請擇日再來。";
                    return;
                }

                if (this.checkError) {
                    this.overlayState = true;
                    this.error = "";
                    return;
                } else {
                    this.error = "請確認您是否選了5位球員。";
                }
            },
            insertPreviousData: function insertPreviousData() {
                var _this5 = this;

                if (this.previousData.length) {
                    this.loading = true;
                    var initValue = 430;
                    this.previousData.forEach(function (el, i) {
                        if (typeof el === "undefined") return;

                        if (!el.hasOwnProperty("img")) {
                            var _that = _this5;
                            initValue = initValue - el.rating;
                            getLocalImage(el.playerId, function (img) {
                                el.img = img;
                                _that.players[i].player = el;
                            });
                        } else {
                            initValue = initValue - el.rating;
                            _this5.players[i].player = el;
                        }
                    });
                    this.score = initValue;
                    this.players.forEach(function (el) {
                        return (el.state = false);
                    });
                    this.error = "";
                    this.loading = false;
                }
            },
            sibblingCommunication: function sibblingCommunication(
                _that,
                event,
                index
            ) {
                if (event.type === "playerSelection") {
                    this.players[index].player = event.player;
                    this.players[index].state = false;
                }

                if (event.type === "open") {
                    this.players.forEach(function (el, i) {
                        event.index === i
                            ? (el.state = !el.state)
                            : (el.state = false);
                    });
                }
            },
        },
    });
    var historyVue = new Vue({
        el: "#historyVue",
        components: {
            Simplert: Simplert,
        },
        data: {
            state: false,
            loading: false,
            currentData: {},
            historySelection: "none",
            maxDate: new Date(),
            // current date
            minDate: "2018-10-01",
            // start of season
            attrs: [],
        },
        computed: {
            totalScore: function totalScore() {
                var total =
                    Object.keys(this.currentData).length === 0 &&
                    this.currentData.constructor === Object
                        ? [0]
                        : this.currentData.players.map(function (el) {
                              return parseInt(el.scores);
                          });
                return total.reduce(function (acc, currentValue) {
                    return acc + currentValue;
                });
            },
        },
        created: function created() {
            this.attrs = historyObject.map(function (history) {
                return {
                    dates: new Date(history.date),
                    highlight: {
                        backgroundColor: "#ff8080",
                    },
                    customObject: {
                        id: history.id,
                    },
                    // Just use a normal style
                    contentStyle: {
                        color: "#fafafa",
                    },
                };
            });
        },
        methods: {
            dayClicked: function dayClicked(day) {
                var id =
                    day.attributes.length &&
                    day.attributes[0].hasOwnProperty("customObject")
                        ? day.attributes[0].customObject.id
                        : false;
                if (!id) return;
                this.historySelection = id;
                this.getHistory();
            },
            getAlternativeInfo: function getAlternativeInfo(id) {
                var _that = this;

                fetch(
                    "https://nba.udn.com/nba_data/playerstats/season/".concat(
                        id
                    )
                )
                    .then(function (res) {
                        return res.json();
                    })
                    .then(function (data) {
                        console.log("data", data);
                        _that.currentData = {
                            players: _that.currentData.players.map(function (
                                player
                            ) {
                                if (player.player_id === parseInt(id)) {
                                    player.firstname = data.firstName;
                                    player.lastname = data.lastName;
                                    player.teamAbbr = data.team;
                                }

                                return player;
                            }),
                            date: _that.currentData.date,
                            rank: _that.currentData.rank,
                        };
                    });
            },
            getHistory: function getHistory() {
                var _that = this;

                if (this.historySelection === "none") {
                    console.log("not selected");
                    return;
                }

                if (this.loading) return;
                this.loading = true;

                fetch(getHistoryUrl.concat(this.historySelection), {
                    method: "get",
                    credentials: "include",
                })
                    .then(function (e) {
                        return e.json();
                    })
                    .then(function (data) {
                        if (data.hasOwnProperty("message")) {
                            alert(data.message);
                            return;
                        }
                        var players = data.players.map((el) => {
                            if (!el.position)
                                _that.getAlternativeInfo(el.player_id);

                            return {
                                player_id: el.player_id || "",
                                position: el.position ? el.position : [],
                                region: el.region ? el.region : "",
                                assists: el.assists ? el.assists : 0,
                                blocks: el.blocks ? el.blocks : 0,
                                jersey: el.jersey ? el.jersey : "",
                                lastname: el.lastname ? el.lastname : "",
                                firstname: el.firstname ? el.firstname : "",
                                rebs: el.rebs ? el.rebs : 0,
                                scores: el.scores ? el.scores : 0,
                                turnovers: el.turnovers ? el.turnovers : 0,
                                steals: el.steals ? el.steals : 0,
                                points: el.points ? el.points : 0,
                                teamAbbr: el.teamAbbr || "",
                            };
                        });
                        _that.currentData = {
                            date: data.date,
                            players: players,
                            rank: data.rank,
                        };
                        _that.state = true;
                        _that.loading = false;
                    })
                    ["catch"](function (err) {
                        console.log(_that.$refs.simplert.openSimplert);
                        _that.loading = false;
                        _that.$refs.simplert.openSimplert({
                            title: "錯誤",
                            message: err,
                            customCloseBtnText: "確認",
                            disableOverlayClick: true,
                            customIconUrl: "",
                        });
                    });
            },
        },
    });

    function getLocalImage(playerId, callback) {
        var img = new Image();
        img.src = "https://nba.udn.com/assets/img/players/" + playerId + ".png";

        img.onload = function () {
            callback(
                "https://nba.udn.com/assets/img/players/" + playerId + ".png"
            );
        };

        img.onerror = function (err) {
            callback("https://nba.udn.com/assets/img/players/not_found.png");
        };
    }

    function eraseCookie(name) {
        document.cookie =
            name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
    }
})();
