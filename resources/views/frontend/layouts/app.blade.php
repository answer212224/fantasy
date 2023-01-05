<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>NBA Fantasy｜夢幻籃球隊</title>
    <meta property="og:title" content="NBA Fantasy｜夢幻籃球隊" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ env('APP_URL') }}/" />
    <meta property="og:image" content="{{ asset('img/1200x630.jpeg') }}?1234" />
    <meta property="og:description" content="選球員、賺積分、拿獎品，全台球迷每日對決！" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_CLIENT_ID') }}" />
    <meta b="fb:app_id" content="{{ env('FACEBOOK_CLIENT_ID') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="//s.udn.com.tw/static/font-icons/css/fontello.css">
    <link rel="stylesheet" href="//s.udn.com.tw/static/font-icons/css/animation.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.5.2/tiny-slider.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tingle/0.13.2/tingle.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css?123') }}">
    <link rel='stylesheet' href='{{ asset('css/v-calendar.min.css') }}'>
    <link rel="stylesheet" href="{{ asset('css/simplert.css') }}">


    <!-- adobe digitalData -->
    <script>
        var digitalData = {
            "page": {
                "pageInfo": {
                    "pageName": "tw:fantasy:main",
                    "language": "Chinese",
                    "partner": "udn"
                },
                "category": {
                    "primaryCategory": "taiwan",
                    "subCategory1": "tw:fantasy",
                    "subCategory2": "taiwan|nba tw|fantasy|main"
                }
            },
            "content": {
                "type": "fantasy"
            }
        };
    </script>
    <script src="//assets.adobedtm.com/launch-ENf3a5eb5de5de40d787976f9eed9d236e.min.js" async></script>

    <script>
        googletag.cmd.push(function() {

            var mappingDesktop = googletag.sizeMapping().
            addSize([768, 690], [728, 90]).
            addSize([0, 0], []).
            build();

            var mappingMobile = googletag.sizeMapping().
            addSize([768, 690], []).
            addSize([0, 0], [
                [300, 100]
            ]).
            build();

            var indexMappingModile = googletag.sizeMapping().addSize([768, 690], []).addSize([0, 0], [300, 100])
                .build();


            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_PC_728x90', [
                    [728, 90]
                ], 'div-gpt-ad-1541142132668-0').defineSizeMapping(mappingDesktop).setCollapseEmptyDiv(true)
                .addService(googletag.pubads());
            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_Mobile_300x100', [
                    [300, 100]
                ], 'div-gpt-ad-1541142159376-0').defineSizeMapping(indexMappingModile).setCollapseEmptyDiv(true)
                .addService(googletag.pubads());

            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_PC_430x80_L', [
                [430, 80], 'fluid'
            ], 'div-gpt-ad-1541142199927-0').addService(googletag.pubads());
            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_PC_430x80_R', [
                [430, 80], 'fluid'
            ], 'div-gpt-ad-1541142222475-0').addService(googletag.pubads());

            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_Mobile_300x100_1', [
                    [300, 100], 'fluid'
                ], 'div-gpt-ad-1541142240662-0').defineSizeMapping(mappingMobile).setCollapseEmptyDiv(true)
                .addService(googletag.pubads());
            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_Mobile_300x100_2', [
                    [300, 100], 'fluid'
                ], 'div-gpt-ad-1541142268371-0').defineSizeMapping(mappingMobile).setCollapseEmptyDiv(true)
                .addService(googletag.pubads());

            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_PC_430x80_L_TopPlayers', [
                [430, 80], 'fluid'
            ], 'div-gpt-ad-1541470508404-0').setCollapseEmptyDiv(true).addService(googletag.pubads());
            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_PC_430x80_R_TopPlayers', [
                [430, 80], 'fluid'
            ], 'div-gpt-ad-1541470463802-0').setCollapseEmptyDiv(true).addService(googletag.pubads());

            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_Mobile_300x100_L_TopPlayers', [
                    [300, 100], 'fluid'
                ], 'div-gpt-ad-1541492483552-0').defineSizeMapping(mappingMobile).setCollapseEmptyDiv(true)
                .addService(googletag.pubads());
            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_Mobile_300x100_R_TopPlayers', [
                    [300, 100], 'fluid'
                ], 'div-gpt-ad-1541492555568-0').defineSizeMapping(mappingMobile).setCollapseEmptyDiv(true)
                .addService(googletag.pubads());

            googletag.defineSlot('/4576170/NBA_Fantasy/NBA_Fantasy_PC_Mobile_300x250', [
                [300, 250]
            ], 'div-gpt-ad-1541142108937-0').addService(googletag.pubads());

            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-19660006-1', 'auto');
        ga('create', 'UA-44955675-27', 'auto', {
            'name': 'nbatw'
        });
        ga('create', 'UA-20390369-7', 'auto', {
            'name': 'event'
        });
        ga('send', 'pageview');
        ga('nbatw.send', 'pageview');
        ga('event.send', 'pageview');
    </script>

    <!-- Begin comScore Tag -->
    <script>
        var _comscore = _comscore || [];
        _comscore.push({
            c1: "2",
            c2: "7390954"
        });
        (function() {
            var s = document.createElement("script"),
                el = document.getElementsByTagName("script")[0];
            s.async = true;
            s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") +
                ".scorecardresearch.com/beacon.js";
            el.parentNode.insertBefore(s, el);
        })();
    </script>
    <noscript><img src="//b.scorecardresearch.com/p?c1=2&c2=7390954&cv=2.0&cj=1" /></noscript>
    <!-- End comScore Tag -->

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WG7QNCK');
    </script>
    <!-- End Google Tag Manager -->

    <script>
        var NBA_SEASON_STATUS = "{{ $setting->type }}"
    </script>

    @stack('topScripts')

</head>

<body>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src =
                'https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v10.0&appId=1945821345437674&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>



    <header class="header">
        <div class="social-container">
            <div class="social-bar container">
                <div class="fb-like" data-href="https://nba.udn.com/fantasy/" data-layout="button"
                    data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
                <div class="line-it-button" data-lang="en" data-type="share-a" data-url="https://nba.udn.com/fantasy/"
                    style="display: none;"></div>
                <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer">
                </script>
            </div>
        </div>
        <div class="logo-container container">
            <a href="//udn.com" class="logo logo-udn" title="聯合線上">聯合線上</a>
            <a href="//udn.com" class="logo logo-udn-title" title="聯合線上">聯合線上</a>
            <a href="//nba.udn.com" class="logo logo-nba" title="台灣 NBA">台灣 NBA</a>
        </div>
    </header>

    <nav class="menu-container">
        <div class="container navigation">
            <section class="menu">
                <div class="menu-item">
                    <a href="{{ env('APP_URL') }}">FANTASY 首頁</a>
                    <section class="menu-item__sub">
                        <a data-scroll href="{{ env('APP_URL') }}#news">焦點新聞</a>
                        <a data-scroll href="{{ env('APP_URL') }}#players">最夯球員</a>
                        <a data-scroll href="{{ env('APP_URL') }}#rank">積分風云榜</a>
                    </section>
                </div>
                <div class="menu-item">
                    <a href="{{ env('APP_URL') }}/info">遊戲規則與獎項</a>
                    <section class="menu-item__sub">
                        <a data-scroll href="{{ env('APP_URL') }}/info#rules">遊戲規則</a>
                        <a data-scroll href="{{ env('APP_URL') }}/info#prize">獎項</a>
                    </section>
                </div>

                <div class="menu-item">
                    <a href="{{ env('APP_URL') }}/awards">得獎名單</a>
                </div>


            </section>

            @if (Request::path() != 'member')
                @isset($member)
                    <div class="management">
                        <a href="{{ env('APP_URL') }}/member" class="manage">回到球隊管理頁</a>
                    </div>
                @endisset
            @else
                @isset($member)
                    <div class="management">

                        <a href="{{ env('APP_URL') }}/fblogout" class="manage">登出</a>

                    </div>
                @endisset
            @endif
        </div>
    </nav>

    @yield('content')


    <footer class="footer"><span class="container">The NBA identifications are the intellectual property of
            NBA
            Properties, Inc. © {{ today()->year }} NBA Properties, Inc.</span></footer>

    <a href="#" id="gotop"></a>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WG7QNCK" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.5.2/min/tiny-slider.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tingle/0.13.2/tingle.min.js"></script>
    <script src="//nba.udn.com/sports/js/es6-promise.min.js"></script>
    <script src="//nba.udn.com/sports/js/fetch.js"></script>
    <script src="{{ asset('js/polyfill.js') }}"></script>
    <script src="{{ asset('js/particle.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    @stack('bottomScripts')

</body>

</html>
