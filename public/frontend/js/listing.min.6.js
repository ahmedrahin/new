/*
 nouislider - 11.1.0 - 2018-04-02 11:18:13 */
var $jscomp = $jscomp || {};
$jscomp.scope = {};
$jscomp.ASSUME_ES5 = !1;
$jscomp.ASSUME_NO_NATIVE_MAP = !1;
$jscomp.ASSUME_NO_NATIVE_SET = !1;
$jscomp.defineProperty = $jscomp.ASSUME_ES5 || "function" == typeof Object.defineProperties ? Object.defineProperty : function(c, n, g) {
    c != Array.prototype && c != Object.prototype && (c[n] = g.value)
};
$jscomp.getGlobal = function(c) {
    return "undefined" != typeof window && window === c ? c : "undefined" != typeof global && null != global ? global : c
};
$jscomp.global = $jscomp.getGlobal(this);
$jscomp.SYMBOL_PREFIX = "jscomp_symbol_";
$jscomp.initSymbol = function() {
    $jscomp.initSymbol = function() {};
    $jscomp.global.Symbol || ($jscomp.global.Symbol = $jscomp.Symbol)
};
$jscomp.Symbol = function() {
    var c = 0;
    return function(n) {
        return $jscomp.SYMBOL_PREFIX + (n || "") + c++
    }
}();
$jscomp.initSymbolIterator = function() {
    $jscomp.initSymbol();
    var c = $jscomp.global.Symbol.iterator;
    c || (c = $jscomp.global.Symbol.iterator = $jscomp.global.Symbol("iterator"));
    "function" != typeof Array.prototype[c] && $jscomp.defineProperty(Array.prototype, c, {
        configurable: !0,
        writable: !0,
        value: function() {
            return $jscomp.arrayIterator(this)
        }
    });
    $jscomp.initSymbolIterator = function() {}
};
$jscomp.arrayIterator = function(c) {
    var n = 0;
    return $jscomp.iteratorPrototype(function() {
        return n < c.length ? {
            done: !1,
            value: c[n++]
        } : {
            done: !0
        }
    })
};
$jscomp.iteratorPrototype = function(c) {
    $jscomp.initSymbolIterator();
    c = {
        next: c
    };
    c[$jscomp.global.Symbol.iterator] = function() {
        return this
    };
    return c
};
$jscomp.iteratorFromArray = function(c, n) {
    $jscomp.initSymbolIterator();
    c instanceof String && (c += "");
    var g = 0,
        l = {
            next: function() {
                if (g < c.length) {
                    var t = g++;
                    return {
                        value: n(t, c[t]),
                        done: !1
                    }
                }
                l.next = function() {
                    return {
                        done: !0,
                        value: void 0
                    }
                };
                return l.next()
            }
        };
    l[Symbol.iterator] = function() {
        return l
    };
    return l
};
$jscomp.polyfill = function(c, n, g, l) {
    if (n) {
        g = $jscomp.global;
        c = c.split(".");
        for (l = 0; l < c.length - 1; l++) {
            var t = c[l];
            t in g || (g[t] = {});
            g = g[t]
        }
        c = c[c.length - 1];
        l = g[c];
        n = n(l);
        n != l && null != n && $jscomp.defineProperty(g, c, {
            configurable: !0,
            writable: !0,
            value: n
        })
    }
};
$jscomp.polyfill("Array.prototype.keys", function(c) {
    return c ? c : function() {
        return $jscomp.iteratorFromArray(this, function(c) {
            return c
        })
    }
}, "es6", "es3");
$jscomp.polyfill("Array.prototype.values", function(c) {
    return c ? c : function() {
        return $jscomp.iteratorFromArray(this, function(c, g) {
            return g
        })
    }
}, "es8", "es3");
$jscomp.findInternal = function(c, n, g) {
    c instanceof String && (c = String(c));
    for (var l = c.length, t = 0; t < l; t++) {
        var x = c[t];
        if (n.call(g, x, t, c)) return {
            i: t,
            v: x
        }
    }
    return {
        i: -1,
        v: void 0
    }
};
$jscomp.polyfill("Array.prototype.find", function(c) {
    return c ? c : function(c, g) {
        return $jscomp.findInternal(this, c, g).v
    }
}, "es6", "es3");
! function(c) {
    "function" == typeof define && define.amd ? define([], c) : "object" == typeof exports ? module.exports = c() : window.noUiSlider = c()
}(function() {
    function c(b) {
        return null !== b && void 0 !== b
    }

    function n(b) {
        b.preventDefault()
    }

    function g(b) {
        return b.filter(function(a) {
            return !this[a] && (this[a] = !0)
        }, {})
    }

    function l(b) {
        return "number" == typeof b && !isNaN(b) && isFinite(b)
    }

    function t(b, a, c) {
        0 < c && (p(b, a), setTimeout(function() {
            D(b, a)
        }, c))
    }

    function x(b) {
        return Array.isArray(b) ? b : [b]
    }

    function N(b) {
        b = String(b);
        b = b.split(".");
        return 1 < b.length ? b[1].length : 0
    }

    function p(b, a) {
        b.classList ? b.classList.add(a) : b.className += " " + a
    }

    function D(b, a) {
        b.classList ? b.classList.remove(a) : b.className = b.className.replace(new RegExp("(^|\\b)" + a.split(" ").join("|") + "(\\b|$)", "gi"), " ")
    }

    function K(b) {
        var a = void 0 !== window.pageXOffset,
            c = "CSS1Compat" === (b.compatMode || "");
        return {
            x: a ? window.pageXOffset : c ? b.documentElement.scrollLeft : b.body.scrollLeft,
            y: a ? window.pageYOffset : c ? b.documentElement.scrollTop : b.body.scrollTop
        }
    }

    function O() {
        var b = !1;
        try {
            var a = Object.defineProperty({}, "passive", {
                get: function() {
                    b = !0
                }
            });
            window.addEventListener("test", null, a)
        } catch (pa) {}
        return b
    }

    function d(b, a) {
        return 100 * a / (b[1] - b[0])
    }

    function e(b, a) {
        for (var c = 1; b >= a[c];) c += 1;
        return c
    }

    function ca(b, a, c) {
        var d;
        if ("number" == typeof a && (a = [a]), !Array.isArray(a)) throw Error("noUiSlider (" + k + "): 'range' contains invalid value.");
        if (d = "min" === b ? 0 : "max" === b ? 100 : parseFloat(b), !l(d) || !l(a[0])) throw Error("noUiSlider (" + k + "): 'range' value isn't numeric.");
        c.xPct.push(d);
        c.xVal.push(a[0]);
        d ? c.xSteps.push(!isNaN(a[1]) && a[1]) : isNaN(a[1]) || (c.xSteps[0] = a[1]);
        c.xHighestCompleteStep.push(0)
    }

    function S(b, a, c) {
        if (!a) return !0;
        c.xSteps[b] = d([c.xVal[b], c.xVal[b + 1]], a) / (100 / (c.xPct[b + 1] - c.xPct[b]));
        a = Math.ceil(Number(((c.xVal[b + 1] - c.xVal[b]) / c.xNumSteps[b]).toFixed(3)) - 1);
        c.xHighestCompleteStep[b] = c.xVal[b] + c.xNumSteps[b] * a
    }

    function y(b, a, c) {
        this.xPct = [];
        this.xVal = [];
        this.xSteps = [c || !1];
        this.xNumSteps = [!1];
        this.xHighestCompleteStep = [];
        this.snap = a;
        var d;
        a = [];
        for (d in b) b.hasOwnProperty(d) &&
            a.push([b[d], d]);
        a.length && "object" == typeof a[0][0] ? a.sort(function(a, b) {
            return a[0][0] - b[0][0]
        }) : a.sort(function(a, b) {
            return a[0] - b[0]
        });
        for (d = 0; d < a.length; d++) ca(a[d][1], a[d][0], this);
        this.xNumSteps = this.xSteps.slice(0);
        for (d = 0; d < this.xNumSteps.length; d++) S(d, this.xNumSteps[d], this)
    }

    function T(b) {
        if ("object" == typeof b && "function" == typeof b.to && "function" == typeof b.from) return !0;
        throw Error("noUiSlider (" + k + "): 'format' requires 'to' and 'from' methods.");
    }

    function G(b, a) {
        if (!l(a)) throw Error("noUiSlider (" +
            k + "): 'step' is not numeric.");
        b.singleStep = a
    }

    function B(b, a) {
        if ("object" != typeof a || Array.isArray(a)) throw Error("noUiSlider (" + k + "): 'range' is not an object.");
        if (void 0 === a.min || void 0 === a.max) throw Error("noUiSlider (" + k + "): Missing 'min' or 'max' in 'range'.");
        if (a.min === a.max) throw Error("noUiSlider (" + k + "): 'range' 'min' and 'max' cannot be equal.");
        b.spectrum = new y(a, b.snap, b.singleStep)
    }

    function da(b, a) {
        if (a = x(a), !Array.isArray(a) || !a.length) throw Error("noUiSlider (" + k + "): 'start' option is incorrect.");
        b.handles = a.length;
        b.start = a
    }

    function P(b, a) {
        if (b.snap = a, "boolean" != typeof a) throw Error("noUiSlider (" + k + "): 'snap' option must be a boolean.");
    }

    function ea(b, a) {
        if (b.animate = a, "boolean" != typeof a) throw Error("noUiSlider (" + k + "): 'animate' option must be a boolean.");
    }

    function fa(b, a) {
        if (b.animationDuration = a, "number" != typeof a) throw Error("noUiSlider (" + k + "): 'animationDuration' option must be a number.");
    }

    function ha(b, a) {
        var c, d = [!1];
        if ("lower" === a ? a = [!0, !1] : "upper" === a && (a = [!1, !0]), !0 === a || !1 ===
            a) {
            for (c = 1; c < b.handles; c++) d.push(a);
            d.push(!1)
        } else {
            if (!Array.isArray(a) || !a.length || a.length !== b.handles + 1) throw Error("noUiSlider (" + k + "): 'connect' option doesn't match handle count.");
            d = a
        }
        b.connect = d
    }

    function va(b, a) {
        switch (a) {
            case "horizontal":
                b.ort = 0;
                break;
            case "vertical":
                b.ort = 1;
                break;
            default:
                throw Error("noUiSlider (" + k + "): 'orientation' option is invalid.");
        }
    }

    function U(b, a) {
        if (!l(a)) throw Error("noUiSlider (" + k + "): 'margin' option must be numeric.");
        if (0 !== a && (b.margin = b.spectrum.getMargin(a), !b.margin)) throw Error("noUiSlider (" + k + "): 'margin' option is only supported on linear sliders.");
    }

    function wa(b, a) {
        if (!l(a)) throw Error("noUiSlider (" + k + "): 'limit' option must be numeric.");
        if (b.limit = b.spectrum.getMargin(a), !b.limit || 2 > b.handles) throw Error("noUiSlider (" + k + "): 'limit' option is only supported on linear sliders with 2 or more handles.");
    }

    function xa(b, a) {
        if (!l(a) && !Array.isArray(a)) throw Error("noUiSlider (" + k + "): 'padding' option must be numeric or array of exactly 2 numbers.");
        if (Array.isArray(a) && 2 !== a.length && !l(a[0]) && !l(a[1])) throw Error("noUiSlider (" + k + "): 'padding' option must be numeric or array of exactly 2 numbers.");
        if (0 !== a) {
            if (Array.isArray(a) || (a = [a, a]), b.padding = [b.spectrum.getMargin(a[0]), b.spectrum.getMargin(a[1])], !1 === b.padding[0] || !1 === b.padding[1]) throw Error("noUiSlider (" + k + "): 'padding' option is only supported on linear sliders.");
            if (0 > b.padding[0] || 0 > b.padding[1]) throw Error("noUiSlider (" + k + "): 'padding' option must be a positive number(s).");
            if (100 <= b.padding[0] + b.padding[1]) throw Error("noUiSlider (" + k + "): 'padding' option must not exceed 100% of the range.");
        }
    }

    function ya(b, a) {
        switch (a) {
            case "ltr":
                b.dir = 0;
                break;
            case "rtl":
                b.dir = 1;
                break;
            default:
                throw Error("noUiSlider (" + k + "): 'direction' option was not recognized.");
        }
    }

    function za(b, a) {
        if ("string" != typeof a) throw Error("noUiSlider (" + k + "): 'behaviour' must be a string containing options.");
        var c = 0 <= a.indexOf("tap"),
            d = 0 <= a.indexOf("drag"),
            g = 0 <= a.indexOf("fixed"),
            e = 0 <= a.indexOf("snap");
        a = 0 <= a.indexOf("hover");
        if (g) {
            if (2 !== b.handles) throw Error("noUiSlider (" + k + "): 'fixed' behaviour must be used with 2 handles");
            U(b, b.start[1] - b.start[0])
        }
        b.events = {
            tap: c || e,
            drag: d,
            fixed: g,
            snap: e,
            hover: a
        }
    }

    function Aa(b, a) {
        if (!1 !== a)
            if (!0 === a)
                for (b.tooltips = [], a = 0; a < b.handles; a++) b.tooltips.push(!0);
            else {
                if (b.tooltips = x(a), b.tooltips.length !== b.handles) throw Error("noUiSlider (" + k + "): must pass a formatter for all handles.");
                b.tooltips.forEach(function(a) {
                    if ("boolean" != typeof a && ("object" != typeof a ||
                            "function" != typeof a.to)) throw Error("noUiSlider (" + k + "): 'tooltips' must be passed a formatter or 'false'.");
                })
            }
    }

    function Ba(b, a) {
        b.ariaFormat = a;
        T(a)
    }

    function Ca(b, a) {
        b.format = a;
        T(a)
    }

    function Da(b, a) {
        if ("string" != typeof a && !1 !== a) throw Error("noUiSlider (" + k + "): 'cssPrefix' must be a string or `false`.");
        b.cssPrefix = a
    }

    function Ea(b, a) {
        if ("object" != typeof a) throw Error("noUiSlider (" + k + "): 'cssClasses' must be an object.");
        if ("string" == typeof b.cssPrefix) {
            b.cssClasses = {};
            for (var c in a) a.hasOwnProperty(c) &&
                (b.cssClasses[c] = b.cssPrefix + a[c])
        } else b.cssClasses = a
    }

    function qa(b) {
        var a = {
                margin: 0,
                limit: 0,
                padding: 0,
                animate: !0,
                animationDuration: 300,
                ariaFormat: V,
                format: V
            },
            d = {
                step: {
                    r: !1,
                    t: G
                },
                start: {
                    r: !0,
                    t: da
                },
                connect: {
                    r: !0,
                    t: ha
                },
                direction: {
                    r: !0,
                    t: ya
                },
                snap: {
                    r: !1,
                    t: P
                },
                animate: {
                    r: !1,
                    t: ea
                },
                animationDuration: {
                    r: !1,
                    t: fa
                },
                range: {
                    r: !0,
                    t: B
                },
                orientation: {
                    r: !1,
                    t: va
                },
                margin: {
                    r: !1,
                    t: U
                },
                limit: {
                    r: !1,
                    t: wa
                },
                padding: {
                    r: !1,
                    t: xa
                },
                behaviour: {
                    r: !0,
                    t: za
                },
                ariaFormat: {
                    r: !1,
                    t: Ba
                },
                format: {
                    r: !1,
                    t: Ca
                },
                tooltips: {
                    r: !1,
                    t: Aa
                },
                cssPrefix: {
                    r: !0,
                    t: Da
                },
                cssClasses: {
                    r: !0,
                    t: Ea
                }
            },
            g = {
                connect: !1,
                direction: "ltr",
                behaviour: "tap",
                orientation: "horizontal",
                cssPrefix: "noUi-",
                cssClasses: {
                    target: "target",
                    base: "base",
                    origin: "origin",
                    handle: "handle",
                    handleLower: "handle-lower",
                    handleUpper: "handle-upper",
                    horizontal: "horizontal",
                    vertical: "vertical",
                    background: "background",
                    connect: "connect",
                    connects: "connects",
                    ltr: "ltr",
                    rtl: "rtl",
                    draggable: "draggable",
                    drag: "state-drag",
                    tap: "state-tap",
                    active: "active",
                    tooltip: "tooltip",
                    pips: "pips",
                    pipsHorizontal: "pips-horizontal",
                    pipsVertical: "pips-vertical",
                    marker: "marker",
                    markerHorizontal: "marker-horizontal",
                    markerVertical: "marker-vertical",
                    markerNormal: "marker-normal",
                    markerLarge: "marker-large",
                    markerSub: "marker-sub",
                    value: "value",
                    valueHorizontal: "value-horizontal",
                    valueVertical: "value-vertical",
                    valueNormal: "value-normal",
                    valueLarge: "value-large",
                    valueSub: "value-sub"
                }
            };
        b.format && !b.ariaFormat && (b.ariaFormat = b.format);
        Object.keys(d).forEach(function(e) {
            if (!c(b[e]) && void 0 === g[e]) {
                if (d[e].r) throw Error("noUiSlider (" + k + "): '" +
                    e + "' is required.");
                return !0
            }
            d[e].t(a, c(b[e]) ? b[e] : g[e])
        });
        a.pips = b.pips;
        var e = document.createElement("div"),
            l = void 0 !== e.style.msTransform;
        a.transformRule = void 0 !== e.style.transform ? "transform" : l ? "msTransform" : "webkitTransform";
        return a.style = [
            ["left", "top"],
            ["right", "bottom"]
        ][a.dir][a.ort], a
    }

    function Fa(b, a, c) {
        function d(a, b) {
            var f = L.createElement("div");
            return b && p(f, b), a.appendChild(f), f
        }

        function e(b, h) {
            b = d(b, a.cssClasses.origin);
            var f = d(b, a.cssClasses.handle);
            return f.setAttribute("data-handle",
                h), f.setAttribute("tabindex", "0"), f.setAttribute("role", "slider"), f.setAttribute("aria-orientation", a.ort ? "vertical" : "horizontal"), 0 === h ? p(f, a.cssClasses.handleLower) : h === a.handles - 1 && p(f, a.cssClasses.handleUpper), b
        }

        function l(b, h) {
            return !!a.tooltips[h] && d(b.firstChild, a.cssClasses.tooltip)
        }

        function ca() {
            var b = q.map(l);
            ia("update", function(f, m, c) {
                b[m] && (f = f[m], !0 !== a.tooltips[m] && (f = a.tooltips[m].to(c[m])), b[m].innerHTML = f)
            })
        }

        function pa(a, b, m) {
            if ("range" === a || "steps" === a) return r.xVal;
            if ("count" ===
                a) {
                if (2 > b) throw Error("noUiSlider (" + k + "): 'values' (>= 2) required for mode 'count'.");
                a = b - 1;
                var f = 100 / a;
                for (b = []; a--;) b[a] = a * f;
                b.push(100);
                a = "positions"
            }
            return "positions" === a ? b.map(function(a) {
                return r.fromStepping(m ? r.getStep(a) : a)
            }) : "values" === a ? m ? b.map(function(a) {
                return r.fromStepping(r.getStep(r.toStepping(a)))
            }) : b : void 0
        }

        function y(a, b, m) {
            var f = {},
                h = r.xVal[0],
                c = r.xVal[r.xVal.length - 1],
                d = !1,
                e = !1,
                k = 0;
            return m = g(m.slice().sort(function(a, b) {
                return a - b
            })), m[0] !== h && (m.unshift(h), d = !0), m[m.length -
                1] !== c && (m.push(c), e = !0), m.forEach(function(h, c) {
                var z, u = m[c + 1];
                if ("steps" === b && (z = r.xNumSteps[c]), z || (z = u - h), !1 !== h && void 0 !== u)
                    for (z = Math.max(z, 1E-7); h <= u; h = (h + z).toFixed(7) / 1) {
                        var ja = r.toStepping(h);
                        var g = ja - k;
                        var H = g / a;
                        H = Math.round(H);
                        var l = g / H;
                        for (g = 1; g <= H; g += 1) {
                            var Ga = k + g * l;
                            f[Ga.toFixed(5)] = ["x", 0]
                        }
                        H = -1 < m.indexOf(h) ? 1 : "steps" === b ? 2 : 0;
                        !c && d && (H = 0);
                        h === u && e || (f[ja.toFixed(5)] = [h, H]);
                        k = ja
                    }
            }), f
        }

        function da(b, h, m) {
            function f(b, f) {
                var h = f === a.cssClasses.value;
                return f + " " + (h ? k : l)[a.ort] + " " + (h ? e :
                    g)[b]
            }
            var c = L.createElement("div"),
                e = [a.cssClasses.valueNormal, a.cssClasses.valueLarge, a.cssClasses.valueSub],
                g = [a.cssClasses.markerNormal, a.cssClasses.markerLarge, a.cssClasses.markerSub],
                k = [a.cssClasses.valueHorizontal, a.cssClasses.valueVertical],
                l = [a.cssClasses.markerHorizontal, a.cssClasses.markerVertical];
            return p(c, a.cssClasses.pips), p(c, 0 === a.ort ? a.cssClasses.pipsHorizontal : a.cssClasses.pipsVertical), Object.keys(b).forEach(function(z) {
                var u = b[z];
                u[1] = u[1] && h ? h(u[0], u[1]) : u[1];
                var e = d(c, !1);
                e.className =
                    f(u[1], a.cssClasses.marker);
                e.style[a.style] = z + "%";
                u[1] && (e = d(c, !1), e.className = f(u[1], a.cssClasses.value), e.setAttribute("data-value", u[0]), e.style[a.style] = z + "%", e.innerText = m.to(u[0]))
            }), c
        }

        function S() {
            Q && (Q.parentElement.removeChild(Q), Q = null)
        }

        function B(a) {
            S();
            var b = a.mode,
                f = a.density || 1,
                c = a.filter || !1,
                d = pa(b, a.values || !1, a.stepped || !1);
            b = y(f, b, d);
            return Q = w.appendChild(da(b, c, a.format || {
                to: Math.round
            }))
        }

        function P() {
            var b = E.getBoundingClientRect(),
                h = "offset" + ["Width", "Height"][a.ort];
            return 0 ===
                a.ort ? b.width || E[h] : b.height || E[h]
        }

        function I(b, h, m, c) {
            var f = function(f) {
                    var d;
                    if (d = !!(f = T(f, c.pageOffset, c.target || h)))
                        if (d = !(w.hasAttribute("disabled") && !c.doNotReject)) {
                            d = w;
                            var z = a.cssClasses.tap;
                            d = !((d.classList ? d.classList.contains(z) : (new RegExp("\\b" + z + "\\b")).test(d.className)) && !c.doNotReject) && !(b === J.start && void 0 !== f.buttons && 1 < f.buttons) && (!c.hover || !f.buttons) && (ra || f.preventDefault(), f.calcPoint = f.points[a.ort], void m(f, c))
                        }
                    return d
                },
                d = [];
            return b.split(" ").forEach(function(a) {
                h.addEventListener(a,
                    f, !!ra && {
                        passive: !0
                    });
                d.push([a, f])
            }), d
        }

        function T(a, b, c) {
            var f = 0 === a.type.indexOf("touch"),
                h = 0 === a.type.indexOf("mouse"),
                m = 0 === a.type.indexOf("pointer");
            if (0 === a.type.indexOf("MSPointer") && (m = !0), f) {
                var d = function(a) {
                    return a.target === c || c.contains(a.target)
                };
                if ("touchstart" === a.type) {
                    var e = Array.prototype.filter.call(a.touches, d);
                    if (1 < e.length) return !1;
                    d = e[0].pageX;
                    e = e[0].pageY
                } else {
                    e = Array.prototype.find.call(a.changedTouches, d);
                    if (!e) return !1;
                    d = e.pageX;
                    e = e.pageY
                }
            }
            return b = b || K(L), (h || m) && (d = a.clientX +
                b.x, e = a.clientY + b.y), a.pageOffset = b, a.points = [d, e], a.cursor = h || m, a
        }

        function G(b) {
            var f = E;
            var c = a.ort;
            var d = f.getBoundingClientRect(),
                e = f.ownerDocument;
            f = e.documentElement;
            e = K(e);
            c = (/webkit.*Chrome.*Mobile/i.test(navigator.userAgent) && (e.x = 0), c ? d.top + e.y - f.clientTop : d.left + e.x - f.clientLeft);
            b = 100 * (b - c) / P();
            return b = Math.max(Math.min(b, 100), 0), a.dir ? 100 - b : b
        }

        function fa(a) {
            var b = 100,
                f = !1;
            return q.forEach(function(c, h) {
                    c.hasAttribute("disabled") || (c = Math.abs(v[h] - a), (c < b || 100 === c && 100 === b) && (f = h, b = c))
                }),
                f
        }

        function N(a, b) {
            "mouseout" === a.type && "HTML" === a.target.nodeName && null === a.relatedTarget && ka(a, b)
        }

        function ea(b, c) {
            if (-1 === navigator.appVersion.indexOf("MSIE 9") && 0 === b.buttons && 0 !== c.buttonsProperty) return ka(b, c);
            b = (a.dir ? -1 : 1) * (b.calcPoint - c.startCalcPoint);
            sa(0 < b, 100 * b / c.baseSize, c.locations, c.handleNumbers)
        }

        function ka(b, c) {
            c.handle && (D(c.handle, a.cssClasses.active), --la);
            c.listeners.forEach(function(a) {
                W.removeEventListener(a[0], a[1])
            });
            0 === la && (D(w, a.cssClasses.drag), ma(), b.cursor && (X.style.cursor =
                "", X.removeEventListener("selectstart", n)));
            c.handleNumbers.forEach(function(a) {
                A("change", a);
                A("set", a);
                A("end", a)
            })
        }

        function na(b, c) {
            if (1 === c.handleNumbers.length) {
                var f = q[c.handleNumbers[0]];
                if (f.hasAttribute("disabled")) return !1;
                var d = f.children[0];
                la += 1;
                p(d, a.cssClasses.active)
            }
            b.stopPropagation();
            f = [];
            var h = I(J.move, W, ea, {
                    target: b.target,
                    handle: d,
                    listeners: f,
                    startCalcPoint: b.calcPoint,
                    baseSize: P(),
                    pageOffset: b.pageOffset,
                    handleNumbers: c.handleNumbers,
                    buttonsProperty: b.buttons,
                    locations: v.slice()
                }),
                e = I(J.end, W, ka, {
                    target: b.target,
                    handle: d,
                    listeners: f,
                    doNotReject: !0,
                    handleNumbers: c.handleNumbers
                });
            d = I("mouseout", W, N, {
                target: b.target,
                handle: d,
                listeners: f,
                doNotReject: !0,
                handleNumbers: c.handleNumbers
            });
            f.push.apply(f, h.concat(e, d));
            b.cursor && (X.style.cursor = getComputedStyle(b.target).cursor, 1 < q.length && p(w, a.cssClasses.drag), X.addEventListener("selectstart", n, !1));
            c.handleNumbers.forEach(function(a) {
                A("start", a)
            })
        }

        function U(b) {
            b.stopPropagation();
            var c = G(b.calcPoint),
                f = fa(c);
            if (!1 === f) return !1;
            a.events.snap || t(w, a.cssClasses.tap, a.animationDuration);
            Y(f, c, !0, !0);
            ma();
            A("slide", f, !0);
            A("update", f, !0);
            A("change", f, !0);
            A("set", f, !0);
            a.events.snap && na(b, {
                handleNumbers: [f]
            })
        }

        function V(a) {
            a = G(a.calcPoint);
            a = r.getStep(a);
            var b = r.fromStepping(a);
            Object.keys(C).forEach(function(a) {
                "hover" === a.split(".")[0] && C[a].forEach(function(a) {
                    a.call(Z, b)
                })
            })
        }

        function ia(a, b) {
            C[a] = C[a] || [];
            C[a].push(b);
            "update" === a.split(".")[0] && q.forEach(function(a, b) {
                A("update", b)
            })
        }

        function A(b, c, d) {
            Object.keys(C).forEach(function(f) {
                var h =
                    f.split(".")[0];
                b === h && C[f].forEach(function(b) {
                    b.call(Z, R.map(a.format.to), c, R.slice(), d || !1, v.slice())
                })
            })
        }

        function aa(b, c, d, e, u, g) {
            return 1 < q.length && (e && 0 < c && (d = Math.max(d, b[c - 1] + a.margin)), u && c < q.length - 1 && (d = Math.min(d, b[c + 1] - a.margin))), 1 < q.length && a.limit && (e && 0 < c && (d = Math.min(d, b[c - 1] + a.limit)), u && c < q.length - 1 && (d = Math.max(d, b[c + 1] - a.limit))), a.padding && (0 === c && (d = Math.max(d, a.padding[0])), c === q.length - 1 && (d = Math.min(d, 100 - a.padding[1]))), d = r.getStep(d), !((d = Math.max(Math.min(d, 100), 0)) ===
                b[c] && !g) && d
        }

        function oa(b, c) {
            var d = a.ort;
            return (d ? c : b) + ", " + (d ? b : c)
        }

        function sa(a, b, c, d) {
            var f = c.slice(),
                h = [!a, a],
                e = [a, !a];
            d = d.slice();
            a && d.reverse();
            1 < d.length ? d.forEach(function(a, c) {
                c = aa(f, a, f[a] + b, h[c], e[c], !1);
                !1 === c ? b = 0 : (b = c - f[a], f[a] = c)
            }) : h = e = [!0];
            var m = !1;
            d.forEach(function(a, d) {
                m = Y(a, c[a] + b, h[d], e[d]) || m
            });
            m && d.forEach(function(a) {
                A("update", a);
                A("slide", a)
            })
        }

        function ma() {
            M.forEach(function(a) {
                q[a].style.zIndex = 3 + (q.length + (50 < v[a] ? -1 : 1) * a)
            })
        }

        function Y(b, c, d, e) {
            if (d = !1 !== (c = aa(v, b, c, d,
                    e, !1))) v[b] = c, R[b] = r.fromStepping(c), c = "translate(" + oa((a.dir ? 100 - c : c) - ha + "%", "0") + ")", q[b].style[a.transformRule] = c, ta(b), ta(b + 1), d = !0;
            return d
        }

        function ta(b) {
            if (F[b]) {
                var c = 0,
                    d = 100;
                0 !== b && (c = v[b - 1]);
                b !== F.length - 1 && (d = v[b]);
                d -= c;
                c = "translate(" + oa((a.dir ? 100 - c - d : c) + "%", "0") + ")";
                d = "scale(" + oa(d / 100, "1") + ")";
                F[b].style[a.transformRule] = c + " " + d
            }
        }

        function ba(b, c) {
            var d = x(b);
            b = void 0 === v[0];
            c = void 0 === c || !!c;
            a.animate && !b && t(w, a.cssClasses.tap, a.animationDuration);
            M.forEach(function(b) {
                var c = d[b];
                var f =
                    null === c || !1 === c || void 0 === c ? v[b] : ("number" == typeof c && (c = String(c)), c = a.format.from(c), c = r.toStepping(c), !1 === c || isNaN(c) ? v[b] : c);
                Y(b, f, !0, !1)
            });
            M.forEach(function(a) {
                Y(a, v[a], !0, !0)
            });
            ma();
            M.forEach(function(a) {
                A("update", a);
                null !== d[a] && c && A("set", a)
            })
        }

        function ua() {
            var b = R.map(a.format.to);
            return 1 === b.length ? b[0] : b
        }
        var E, q, F, Z, Q, J = window.navigator.pointerEnabled ? {
                start: "pointerdown",
                move: "pointermove",
                end: "pointerup"
            } : window.navigator.msPointerEnabled ? {
                start: "MSPointerDown",
                move: "MSPointerMove",
                end: "MSPointerUp"
            } : {
                start: "mousedown touchstart",
                move: "mousemove touchmove",
                end: "mouseup touchend"
            },
            ra = window.CSS && CSS.supports && CSS.supports("touch-action", "none") && O(),
            w = b,
            v = [],
            M = [],
            la = 0,
            r = a.spectrum,
            R = [],
            C = {},
            L = b.ownerDocument,
            W = L.documentElement,
            X = L.body,
            ha = "rtl" === L.dir || 1 === a.ort ? 0 : 100;
        return function(b) {
                p(b, a.cssClasses.target);
                0 === a.dir ? p(b, a.cssClasses.ltr) : p(b, a.cssClasses.rtl);
                0 === a.ort ? p(b, a.cssClasses.horizontal) : p(b, a.cssClasses.vertical);
                E = d(b, a.cssClasses.base)
            }(w),
            function(b, c) {
                var f =
                    d(c, a.cssClasses.connects);
                q = [];
                F = [];
                F.push(!!b[0] && d(f, a.cssClasses.connect));
                for (var h = 0; h < a.handles; h++) q.push(e(c, h)), M[h] = h, F.push(!!b[h + 1] && d(f, a.cssClasses.connect))
            }(a.connect, E),
            function(b) {
                b.fixed || q.forEach(function(a, b) {
                    I(J.start, a.children[0], na, {
                        handleNumbers: [b]
                    })
                });
                b.tap && I(J.start, E, U, {});
                b.hover && I(J.move, E, V, {
                    hover: !0
                });
                b.drag && F.forEach(function(c, d) {
                    if (!1 !== c && 0 !== d && d !== F.length - 1) {
                        var f = q[d - 1],
                            e = q[d],
                            h = [c];
                        p(c, a.cssClasses.draggable);
                        b.fixed && (h.push(f.children[0]), h.push(e.children[0]));
                        h.forEach(function(a) {
                            I(J.start, a, na, {
                                handles: [f, e],
                                handleNumbers: [d - 1, d]
                            })
                        })
                    }
                })
            }(a.events), ba(a.start), Z = {
                destroy: function() {
                    for (var b in a.cssClasses) a.cssClasses.hasOwnProperty(b) && D(w, a.cssClasses[b]);
                    for (; w.firstChild;) w.removeChild(w.firstChild);
                    delete w.noUiSlider
                },
                steps: function() {
                    return v.map(function(a, b) {
                        var c = r.getNearbySteps(a),
                            d = R[b];
                        b = c.thisStep.step;
                        !1 !== b && d + b > c.stepAfter.startValue && (b = c.stepAfter.startValue - d);
                        c = d > c.thisStep.startValue ? c.thisStep.step : !1 !== c.stepBefore.step && d -
                            c.stepBefore.highestStep;
                        100 === a ? b = null : 0 === a && (c = null);
                        a = r.countStepDecimals();
                        return null !== b && !1 !== b && (b = Number(b.toFixed(a))), null !== c && !1 !== c && (c = Number(c.toFixed(a))), [c, b]
                    })
                },
                on: ia,
                off: function(a) {
                    var b = a && a.split(".")[0],
                        c = b && a.substring(b.length);
                    Object.keys(C).forEach(function(a) {
                        var d = a.split(".")[0],
                            e = a.substring(d.length);
                        b && b !== d || c && c !== e || delete C[a]
                    })
                },
                get: ua,
                set: ba,
                reset: function(b) {
                    ba(a.start, b)
                },
                __moveHandles: function(a, b, c) {
                    sa(a, b, v, c)
                },
                options: c,
                updateOptions: function(b, d) {
                    var e =
                        ua(),
                        f = "margin limit padding range animate snap step format".split(" ");
                    f.forEach(function(a) {
                        void 0 !== b[a] && (c[a] = b[a])
                    });
                    var h = qa(c);
                    f.forEach(function(c) {
                        void 0 !== b[c] && (a[c] = h[c])
                    });
                    r = h.spectrum;
                    a.margin = h.margin;
                    a.limit = h.limit;
                    a.padding = h.padding;
                    a.pips && B(a.pips);
                    v = [];
                    ba(b.start || e, d)
                },
                target: w,
                removePips: S,
                pips: B
            }, a.pips && B(a.pips), a.tooltips && ca(),
            function() {
                ia("update", function(b, c, d, e, g) {
                    M.forEach(function(b) {
                        var c = q[b],
                            e = aa(v, b, 0, !0, !0, !0),
                            f = aa(v, b, 100, !0, !0, !0),
                            h = g[b];
                        b = a.ariaFormat.to(d[b]);
                        c.children[0].setAttribute("aria-valuemin", e.toFixed(1));
                        c.children[0].setAttribute("aria-valuemax", f.toFixed(1));
                        c.children[0].setAttribute("aria-valuenow", h.toFixed(1));
                        c.children[0].setAttribute("aria-valuetext", b)
                    })
                })
            }(), Z
    }
    var k = "11.1.0";
    y.prototype.getMargin = function(b) {
        var a = this.xNumSteps[0];
        if (a && 0 != b / a % 1) throw Error("noUiSlider (" + k + "): 'limit', 'margin' and 'padding' must be divisible by step.");
        return 2 === this.xPct.length && d(this.xVal, b)
    };
    y.prototype.toStepping = function(b) {
        var a = this.xVal,
            c = this.xPct;
        if (b >= a.slice(-1)[0]) var g = 100;
        else {
            var k = e(b, a);
            g = c[k - 1];
            c = c[k];
            a = [a[k - 1], a[k]];
            b = d(a, 0 > a[0] ? b + Math.abs(a[0]) : b - a[0]);
            g += b / (100 / (c - g))
        }
        return g
    };
    y.prototype.fromStepping = function(b) {
        var a = this.xVal,
            c = this.xPct;
        if (100 <= b) b = a.slice(-1)[0];
        else {
            var d = e(b, c),
                g = c[d - 1];
            a = [a[d - 1], a[d]];
            b = 100 / (c[d] - g) * (b - g) * (a[1] - a[0]) / 100 + a[0]
        }
        return b
    };
    y.prototype.getStep = function(b) {
        var a = this.xPct,
            c = this.xSteps,
            d = this.snap;
        if (100 !== b) {
            var g = e(b, a),
                k = a[g - 1],
                l = a[g];
            d ? b = b - k > (l - k) / 2 ? l : k : c[g - 1] && (c = c[g - 1], b = a[g -
                1] + Math.round((b - a[g - 1]) / c) * c)
        }
        return b
    };
    y.prototype.getNearbySteps = function(b) {
        b = e(b, this.xPct);
        return {
            stepBefore: {
                startValue: this.xVal[b - 2],
                step: this.xNumSteps[b - 2],
                highestStep: this.xHighestCompleteStep[b - 2]
            },
            thisStep: {
                startValue: this.xVal[b - 1],
                step: this.xNumSteps[b - 1],
                highestStep: this.xHighestCompleteStep[b - 1]
            },
            stepAfter: {
                startValue: this.xVal[b - 0],
                step: this.xNumSteps[b - 0],
                highestStep: this.xHighestCompleteStep[b - 0]
            }
        }
    };
    y.prototype.countStepDecimals = function() {
        var b = this.xNumSteps.map(N);
        return Math.max.apply(null,
            b)
    };
    y.prototype.convert = function(b) {
        return this.getStep(this.toStepping(b))
    };
    var V = {
        to: function(b) {
            return void 0 !== b && b.toFixed(2)
        },
        from: Number
    };
    return {
        version: k,
        create: function(b, a) {
            if (!b || !b.nodeName) throw Error("noUiSlider (" + k + "): create requires a single element, got: " + b);
            if (b.noUiSlider) throw Error("noUiSlider (" + k + "): Slider was already initialized.");
            var c = qa(a, b);
            a = Fa(b, c, a);
            return b.noUiSlider = a, a
        }
    }
});

