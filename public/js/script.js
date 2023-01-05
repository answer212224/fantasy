"use strict";

(function () {
    "use strict";

    var goTop = document.querySelector("#gotop");
    var supportPageOffset = window.pageXOffset !== undefined;
    var isCSS1Compat = (document.compatMode || "") === "CSS1Compat";
    var canvas = document.getElementById("particles");
    var ctx = canvas.getContext("2d");

    var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName("body")[0],
        x = w.innerWidth || e.clientWidth || g.clientWidth;

    var scrollIt = function scrollIt(destination) {
        var duration =
            arguments.length > 1 && arguments[1] !== undefined
                ? arguments[1]
                : 200;
        var easing =
            arguments.length > 2 && arguments[2] !== undefined
                ? arguments[2]
                : "linear";
        var callback = arguments[3];

        var easings = {
            linear: function linear(t) {
                return t;
            },
            easeInQuad: function easeInQuad(t) {
                return t * t;
            },
            easeOutQuad: function easeOutQuad(t) {
                return t * (2 - t);
            },
            easeInOutQuad: function easeInOutQuad(t) {
                return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            },
            easeInCubic: function easeInCubic(t) {
                return t * t * t;
            },
            easeOutCubic: function easeOutCubic(t) {
                return --t * t * t + 1;
            },
            easeInOutCubic: function easeInOutCubic(t) {
                return t < 0.5
                    ? 4 * t * t * t
                    : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
            },
            easeInQuart: function easeInQuart(t) {
                return t * t * t * t;
            },
            easeOutQuart: function easeOutQuart(t) {
                return 1 - --t * t * t * t;
            },
            easeInOutQuart: function easeInOutQuart(t) {
                return t < 0.5 ? 8 * t * t * t * t : 1 - 8 * --t * t * t * t;
            },
            easeInQuint: function easeInQuint(t) {
                return t * t * t * t * t;
            },
            easeOutQuint: function easeOutQuint(t) {
                return 1 + --t * t * t * t * t;
            },
            easeInOutQuint: function easeInOutQuint(t) {
                return t < 0.5
                    ? 16 * t * t * t * t * t
                    : 1 + 16 * --t * t * t * t * t;
            },
        };

        var start = window.pageYOffset;
        var startTime =
            "now" in window.performance
                ? performance.now()
                : new Date().getTime();

        var documentHeight = Math.max(
            document.body.scrollHeight,
            document.body.offsetHeight,
            document.documentElement.clientHeight,
            document.documentElement.scrollHeight,
            document.documentElement.offsetHeight
        );
        var windowHeight =
            window.innerHeight ||
            document.documentElement.clientHeight ||
            document.getElementsByTagName("body")[0].clientHeight;
        var destinationOffset =
            typeof destination === "number"
                ? destination
                : destination.offsetTop;
        var destinationOffsetToScroll = Math.round(
            documentHeight - destinationOffset < windowHeight
                ? documentHeight - windowHeight
                : destinationOffset
        );

        if ("requestAnimationFrame" in window === false) {
            window.scroll(0, destinationOffsetToScroll);
            if (callback) {
                callback();
            }
            return;
        }

        function scroll() {
            var now =
                "now" in window.performance
                    ? performance.now()
                    : new Date().getTime();
            var time = Math.min(1, (now - startTime) / duration);
            var timeFunction = easings[easing](time);
            window.scroll(
                0,
                Math.ceil(
                    timeFunction * (destinationOffsetToScroll - start) + start
                )
            );

            if (window.pageYOffset === destinationOffsetToScroll) {
                if (callback) {
                    callback();
                }
                return;
            }

            requestAnimationFrame(scroll);
        }

        scroll();
    };

    var party = smokemachine(ctx, [255, 255, 255]);

    var y = supportPageOffset
        ? window.pageYOffset
        : isCSS1Compat
        ? document.documentElement.scrollTop
        : document.body.scrollTop;

    window.addEventListener("scroll", function () {
        y = supportPageOffset
            ? window.pageYOffset
            : isCSS1Compat
            ? document.documentElement.scrollTop
            : document.body.scrollTop;
        y > 100 ? goTop.classList.add("open") : goTop.classList.remove("open");
    });

    goTop.addEventListener("click", function (e) {
        e.preventDefault();
        scrollIt(document.body);
    });

    // particle
    if (x >= 767) {
        canvas.width = x;
        canvas.height = document.querySelector(".main").offsetHeight;
        party.start(); // start animating
    }

    window.addEventListener("mousemove", function (e) {
        var x = e.clientX;
        var y = e.clientY;
        var n = 0.5;
        var t = Math.floor(Math.random() * 200) + 3800;
        party.addsmoke(x, y, n, t);
    });

    setInterval(function () {
        party.addsmoke(innerWidth / 2, innerHeight, 1);
    }, 100);

    //slider

    var slider = tns({
        container: ".slick-slider",
        items: 1,
        slideBy: "page",
        autoplay: true,
        controls: false,
        // autoplayButton: true,
        mouseDrag: false,
    });
})();
