var $jscomp = $jscomp || {};
$jscomp.scope = {};
$jscomp.checkStringArgs = function (a, b, d) {
    if (null == a) throw new TypeError("The 'this' value for String.prototype." + d + " must not be null or undefined");
    if (b instanceof RegExp) throw new TypeError("First argument to String.prototype." + d + " must not be a regular expression");
    return a + "";
};
$jscomp.ASSUME_ES5 = !1;
$jscomp.ASSUME_NO_NATIVE_MAP = !1;
$jscomp.ASSUME_NO_NATIVE_SET = !1;
$jscomp.defineProperty =
    $jscomp.ASSUME_ES5 || "function" == typeof Object.defineProperties
        ? Object.defineProperty
        : function (a, b, d) {
              a != Array.prototype && a != Object.prototype && (a[b] = d.value);
          };
$jscomp.getGlobal = function (a) {
    return "undefined" != typeof window && window === a ? a : "undefined" != typeof global && null != global ? global : a;
};
$jscomp.global = $jscomp.getGlobal(this);
$jscomp.polyfill = function (a, b, d, e) {
    if (b) {
        d = $jscomp.global;
        a = a.split(".");
        for (e = 0; e < a.length - 1; e++) {
            var g = a[e];
            g in d || (d[g] = {});
            d = d[g];
        }
        a = a[a.length - 1];
        e = d[a];
        b = b(e);
        b != e && null != b && $jscomp.defineProperty(d, a, { configurable: !0, writable: !0, value: b });
    }
};
$jscomp.polyfill(
    "String.prototype.startsWith",
    function (a) {
        return a
            ? a
            : function (a, d) {
                  var b = $jscomp.checkStringArgs(this, a, "startsWith");
                  a += "";
                  var g = b.length,
                      h = a.length;
                  d = Math.max(0, Math.min(d | 0, b.length));
                  for (var k = 0; k < h && d < g; ) if (b[d++] != a[k++]) return !1;
                  return k >= h;
              };
    },
    "es6",
    "es3"
);
$jscomp.findInternal = function (a, b, d) {
    a instanceof String && (a = String(a));
    for (var e = a.length, g = 0; g < e; g++) {
        var h = a[g];
        if (b.call(d, h, g, a)) return { i: g, v: h };
    }
    return { i: -1, v: void 0 };
};
$jscomp.polyfill(
    "Array.prototype.find",
    function (a) {
        return a
            ? a
            : function (a, d) {
                  return $jscomp.findInternal(this, a, d).v;
              };
    },
    "es6",
    "es3"
);
$jscomp.polyfill(
    "String.prototype.endsWith",
    function (a) {
        return a
            ? a
            : function (a, d) {
                  var b = $jscomp.checkStringArgs(this, a, "endsWith");
                  a += "";
                  void 0 === d && (d = b.length);
                  d = Math.max(0, Math.min(d | 0, b.length));
                  for (var g = a.length; 0 < g && 0 < d; ) if (b[--d] != a[--g]) return !1;
                  return 0 >= g;
              };
    },
    "es6",
    "es3"
);
(function () {
    function a() {
        h = !0;
        d.removeEventListener("DOMContentLoaded", a);
        e.removeEventListener("load", a);
        g.forEach(function (c) {
            c();
        });
    }
    function b(c) {
        return parseFloat(c ? c : 0);
    }
    var d = document,
        e = window,
        g = [],
        h = !1;
    "complete" === d.readyState ? a() : (d.addEventListener("DOMContentLoaded", a), e.addEventListener("load", a));
    var k = Array.prototype.slice;
    String.prototype.startsWith ||
        (String.prototype.startsWith = function (c, a) {
            return this.substr(!a || 0 > a ? 0 : +a, c.length) === c;
        });
    String.prototype.endsWith ||
        (String.prototype.endsWith = function (c, a) {
            if (void 0 === a || a > this.length) a = this.length;
            return this.substring(a - c.length, a) === c;
        });
    e.$ = function (c, a) {
        if (c instanceof Function) return h ? c() : g.push(c), d;
        if (c instanceof NodeList) return new JQLite(k.call(c));
        if (c instanceof Node && 1 === c.nodeType) return new JQLite([c]);
        var b;
        if ((b = "string" === typeof c)) (b = c.trim()), (b = "<" === b[0] && ">" === b[b.length - 1] && 3 <= b.length);
        if (b) {
            c = c.trim();
            if ((b = c.match(/^<([\w-]+)\s*\/?>(?:<\/\1>|)$/))) {
                a = a || {};
                c = d.createElement(b[1]);
                for (var l in a) a.hasOwnProperty(l) && c.setAttribute(l, a[l]);
                c = [c];
            } else c.startsWith("<!DOCTYPE") || c.startsWith("<!doctype") ? (c = [new DOMParser().parseFromString(c, "text/html").documentElement]) : ((a = d.createElement("div")), (a.innerHTML = c), (c = k.call(a.childNodes)));
            return new JQLite(c);
        }
        if ("string" === typeof c) return new JQLite(k.call(d.querySelectorAll(c)));
        if (c instanceof Document) return new JQLite([c.documentElement]);
    };
    e.JQLite = function (c) {
        this.elements = c;
        return this;
    };
    var f = ($.fn = JQLite.prototype);
    f.html = function (c) {
        if ("undefined" !== typeof c) {
            var a = "";
            c instanceof JQLite
                ? c.each(function () {
                      a += this.outerHTML;
                  })
                : (a = c);
            this.elements.forEach(function (c) {
                c.innerHTML = a;
            });
            return this;
        }
        return this.elements[0].innerHTML;
    };
    f.empty = function () {
        this.html("");
        return this;
    };
    f.prevSiblings = function () {
        for (var c = [], a = this.get(0); (a = a.previousElementSibling); ) c.push(a);
        return new JQLite(c);
    };
    f.nextSiblings = function () {
        for (var c = [], a = this.get(0); (a = a.nextElementSibling); ) c.push(a);
        return new JQLite(c);
    };
    f.siblings = function (c) {
        var a = this.prevSiblings().elements.concat(this.nextSiblings().elements),
            b = [];
        c
            ? a.forEach(function (a) {
                  $(a).is(c) && b.push(a);
              })
            : (b = a);
        return new JQLite(b);
    };
    f.appendToFirst = function (c) {
        this.elements[0].appendChild(c);
    };
    f.prepend = function (c) {
        c instanceof JQLite
            ? c.elements.forEach(
                  function (c) {
                      this.elements[0].prepend(c);
                  }.bind(this)
              )
            : this.elements[0].prepend(c);
        return this;
    };
    f.append = function (c) {
        c instanceof JQLite
            ? c.elements.forEach(
                  function (c) {
                      this.elements[0].appendChild(c);
                  }.bind(this)
              )
            : c instanceof HTMLElement
            ? this.elements[0].appendChild(c)
            : "string" === typeof c &&
              this.elements.forEach(function (a) {
                  a.innerHTML += c;
              });
        return this;
    };
    f.before = function (c) {
        var a = 1 < this.size();
        this.elements.forEach(function (b) {
            var d = b.parentNode;
            "string" === typeof c && (c = $(c));
            c.each(function () {
                var c = a ? this.cloneNode(!0) : this;
                d.insertBefore(c, b);
            });
        });
    };
    f.after = function (c) {
        var a = 1 < this.size();
        this.elements.forEach(function (b) {
            var d = b.parentNode,
                e = b.nextSibling;
            "string" === typeof c && (c = $(c));
            c.each(function () {
                var c = a ? this.cloneNode(!0) : this;
                e ? d.insertBefore(c, e) : d.appendChild(c);
            });
        });
    };
    f.attr = function (c, a) {
        if ("undefined" !== typeof a)
            return (
                this.elements.forEach(function (b) {
                    b.setAttribute(c, a);
                }),
                this
            );
        var b = this.elements[0];
        return b ? b.getAttribute(c) : null;
    };
    f.removeAttr = function (c) {
        this.elements.forEach(function (a) {
            a.removeAttribute(c);
        });
    };
    f.get = function (c) {
        return this.elements[c];
    };
    f.hasClass = function (c) {
        var a = this.get(0);
        return new RegExp(" " + c + " ").test(" " + a.className + " ");
    };
    f.addClass = function (c) {
        this.elements.forEach(function (a) {
            a.classList ? a.classList.add(c) : $(a).hasClass(c) || (a.className += " " + c);
        });
        return this;
    };
    f.removeClass = function (c) {
        this.elements.forEach(function (a) {
            if (a.classList) a.classList.remove(c);
            else {
                var b = " " + a.className.replace(/[\t\r\n]/g, " ") + " ";
                if ($(a).hasClass(c)) {
                    for (; 0 <= b.indexOf(" " + c + " "); ) b = b.replace(" " + c + " ", " ");
                    a.className = b.replace(/^\s+|\s+$/g, "");
                }
            }
        });
        return this;
    };
    f.toggleClass = function (c) {
        this.each(function (a, b) {
            b = $(b);
            b.hasClass(c) ? b.removeClass(c) : b.addClass(c);
        });
    };
    f.hasClass = function (a) {
        return new RegExp(" " + a + " ").test(" " + this.get(0).className + " ");
    };
    f.children = function () {
        var a = [],
            b;
        this.elements.forEach(function (c) {
            b = Array.prototype.slice.call(c.children);
            a = a.concat(b);
        });
        return new JQLite(a);
    };
    f.val = function (a) {
        if (void 0 !== a)
            this.each(function () {
                this.value = a;
            });
        else {
            var c = this.get(0);
            return c ? c.value : null;
        }
    };
    f.parent = function () {
        var a = [],
            b;
        this.elements.forEach(function (c) {
            (b = c.parentElement) && -1 === a.indexOf(b) && a.push(b);
        });
        return new JQLite(a);
    };
    f.parents = function (a) {
        if (!a) return this.parent();
        for (var c = $(this.get(0).parentElement); c.size() && !c.is(a); ) c = c.parent();
        return c;
    };
    f.find = function (a) {
        var c = [],
            b,
            d;
        this.elements.forEach(function (e) {
            b = e.querySelectorAll(a);
            d = Array.prototype.slice.call(b);
            d.forEach(function (a) {
                -1 === c.indexOf(a) && c.push(a);
            });
        });
        return new JQLite(c);
    };
    f.is = function (a) {
        if (0 === this.elements.length) return !1;
        var c = !0;
        this.elements.forEach(function (b) {
            var e = !1;
            if (a.nodeType) e = b === a;
            else for (var l = "string" === typeof a ? d.querySelectorAll(a) : a.elements, m = l.length; m--; ) l[m] === b && (e = !0);
            c = e && c;
        });
        return c;
    };
    f.has = function (a) {
        var c = [];
        a = a instanceof Node ? a : a.get(0);
        this.each(function () {
            this.contains(a) && c.push(this);
        });
        return new JQLite(c);
    };
    f.remove = function () {
        this.elements.forEach(function (a) {
            try {
                a.remove();
            } catch (l) {
                a.parentNode.removeChild(a);
            }
        });
    };
    f.on = function (a, b) {
        this.elements.forEach(function (c) {
            c.addEventListener(a, b);
        });
        return this;
    };
    f.delegate = function (a, b, d) {
        this.on(b, function (c) {
            $(c.target).is(a) && d.apply(c.target, arguments);
        });
    };
    f.off = function (a, b) {
        this.elements.forEach(function (c) {
            c.removeEventListener(a, b);
        });
        return this;
    };
    f.trigger = function (a) {
        try {
            var c = new Event(a);
        } catch (n) {
            (c = d.createEvent("Event")), c.initCustomEvent(a, !0, !0);
        }
        this.elements.forEach(function (a) {
            a.dispatchEvent(c);
        });
    };
    f.each = function (a) {
        this.elements.forEach(function (c, b) {
            a.call(c, b, c);
        });
    };
    f.hide = function () {
        this.originalDisplay = this.css("display");
        this.css("display", "none");
        return this;
    };
    f.show = function () {
        this.css("display", this.originalDisplay && "none" !== this.originalDisplay ? this.originalDisplay : "block");
        return this;
    };
    f.css = function (a, b) {
        if (a && "string" !== typeof a)
            for (var c in a)
                this.elements.forEach(function (b) {
                    b.style[c] = a[c];
                });
        else {
            if ("undefined" === typeof b) return this.elements[0].style.getPropertyValue(a);
            this.elements.forEach(function (c) {
                c.style[a] = b;
            });
            return this;
        }
    };
    f.outerHeight = function () {
        var a = b(this.css("marginTop")) + b(this.css("marginBottom"));
        return Math.ceil(this.get(0).offsetHeight + a);
    };
    f.offset = function () {
        var a = this.get(0);
        var b = a && a.ownerDocument;
        var d = b.documentElement;
        a = a.getBoundingClientRect();
        b = b.defaultView;
        return { top: a.top + b.pageYOffset - d.clientTop, left: a.left + b.pageXOffset - d.clientLeft };
    };
    f.position = function () {
        var a = this.get(0);
        var d = { top: 0, left: 0 };
        if ("fixed" === this.css("position")) a = a.getBoundingClientRect();
        else {
            var e = new JQLite([a.offsetParent]);
            a = this.offset();
            "html" !== this.get(0).nodeName && (d = e.offset());
            d.top += b(e.css("borderTopWidth"));
            d.left += b(e.css("borderLeftWidth"));
        }
        return { top: a.top - d.top - this.css("marginTop"), left: a.left - d.left - this.css("marginLeft") };
    };
    f.text = function (a) {
        if ("undefined" !== typeof a)
            return (
                this.elements.forEach(function (b) {
                    b.innerText = a;
                }),
                this
            );
        text = "";
        this.elements.forEach(function (a) {
            text += a.innerText;
        });
        return text;
    };
    f.size = function () {
        return this.elements.length;
    };
    f.data = function (a, b) {
        var c = this.get(0).dataset;
        c = c || {};
        if (a && b) c[a] = b;
        else return a ? c[a] : c;
    };
    f.scrollTop = function (a) {
        var b = this.get(0);
        if (!b) return null;
        void 0 !== a && (this.get(0).scrollTop = a);
        return b.scrollTop;
    };
    $.extend = function (a) {
        Array.prototype.slice.call(arguments, 1).forEach(function (b) {
            for (var c in b) a[c] = b[c];
        });
        return a;
    };
    var p = function (a) {
        var b = a.method.toUpperCase().trim(),
            c = a.data,
            d = a.url;
        if (c instanceof JQLite) {
            var f = c.elements;
            c = {};
            f.forEach(function (a) {
                a.name && (c[a.name] = a.value);
            });
        }
        if ("string" !== typeof c && !(e.FormData && c instanceof FormData)) {
            f = [];
            for (var m in c) "GET" === b ? (d = updateURLVar(d, m, c[m])) : f.push(m + "=" + encodeURIComponent(c[m]));
            c = f.join("&");
        }
        var g = new XMLHttpRequest();
        g.onreadystatechange = function () {
            if (g.readyState === XMLHttpRequest.DONE) {
                if (200 === g.status) {
                    var b = g.response || g.responseText;
                    "json" === a.dataType && (b = JSON.parse(b));
                    a.success(b);
                } else a.error(g, g.status, g.response);
                a.complete();
            }
        };
        g.open(b, d, !0);
        "GET" !== b && a.contentType && g.setRequestHeader("Content-type", a.contentType);
        a.beforeSend(a);
        g.send(c);
    };
    $.ajax = function (a) {
        var b = { success: function () {}, error: function () {}, url: e.location.href, method: "GET", complete: function () {}, beforeSend: function () {}, dataType: "html", data: "", contentType: "application/x-www-form-urlencoded" };
        $.extend(b, a);
        p(b);
    };
    f.load = function (a, b, d) {
        var c,
            e = this,
            m = a.indexOf(" ");
        if (-1 < m) {
            var f = a.slice(m).trim();
            a = a.slice(0, m);
        }
        b && "object" === typeof b && (c = "POST");
        $.ajax({
            url: a,
            method: c || "GET",
            dataType: "html",
            data: b,
            success: function (a) {
                e.html(f ? $("<div>").append(a).find(f) : a);
                d && d(a);
            },
        });
    };
    $.get = function (a, b, d) {
        $.ajax($.extend({ url: a, success: b }, d));
    };
    $.post = function (a, b, d) {
        $.ajax({ url: a, data: b, method: "POST", success: d });
    };
})();
var app = window.app || {};
app.event = (function () {
    function a() {
        this.events = {};
    }
    var b = a.prototype;
    b.on = function (a, b) {
        var d = this.events[a] || [];
        d.push(b);
        this.events[a] = d;
    };
    b.trigger = function (a, b) {
        (this.events[a] || []).forEach(function (a) {
            a.apply(null, b);
        });
    };
    return new a();
})();
Number.prototype.toCommaFormat = function () {
    var a = this.toString().split(".");
    a[0] = a[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return a.join(".");
};
String.prototype.replaceAll = function (a, b) {
    return this.replace(new RegExp(a, "g"), b);
};
function getURLVar(a, b) {
    var d = {};
    b = b || String(document.location);
    b = b.split("?");
    if (b[1]) {
        b = b[1].split("&");
        for (i = 0; i < b.length; i++) {
            var e = b[i].split("=");
            e[0] && e[1] && (d[e[0]] = e[1]);
        }
        if (d[a]) return d[a];
    }
    return "";
}
function updateURLVar(a, b, d) {
    var e = new RegExp("([?&])" + b + "=.*?(&|$)", "i"),
        g = -1 !== a.indexOf("?") ? "&" : "?";
    a.match(e) && d ? (a = a.replace(e, "$1" + b + "=" + d + "$2")) : a.match(e) && !d ? (a = a.replace(e, "$1")) : d && (a = a + g + b + "=" + d);
    if (a.endsWith("&") || a.endsWith("?")) a = a.substr(0, a.length - 1);
    return a;
}
function shareOnSocialMedea(a, b, d, e) {
    
}
function isMobile() {
    return 768 > window.innerWidth;
}
function showMsg(a, b, d) {
    b || (b = "success");
    d = d || {};
    mgs_type = d.mgs_type ? d.mgs_type : app.mgs_type;
    if ("popup" === mgs_type) {
        var e = new Popup(a, "mgs-popup " + b);
        b = d.duration || 5;
        e.render();
        setTimeout(function () {
            e.close();
        }, 1e3 * b);
    } else
        $(".alert, .text-danger").remove(),
            (d = $(".container.alert-container")),
            0 === d.size() && ((d = $('<div class="container alert-container"></div>')), $(".after-header").after(d)),
            (a = $('<div class="alert alert-' + b + '">' + a + '<button type="button" class="close" data-dismiss="alert">x</button></div>')),
            d.append(a),
            a.find(".close").on("click", function () {
                a.remove();
            }),
            $("body, html").scrollTo(0, 600);
}
$(function () {
    $(".text-danger").each(function () {
        $(this).parents(".form-group").addClass("has-error");
    });
    var a = $("#search input[name='search']");
    a.parent()
        .find("button")
        .on("click", function () {
            var b = $("base").attr("href") + "product/search",
                d = a.val(),
                h = [];
            d && h.push("search=" + encodeURIComponent(d));
            var k = $("#search select[name='category_id']").val();
            k && h.push("category_id=" + k);
            h && (b = b + "?" + h.join("&"));
            location = b;
            fbq("track", "Search");
            window.gtag && gtag("event", "search", { search_term: d });
        });
    a.on("keydown", function (b) {
        13 === b.keyCode && a.parent().find("button").trigger("click");
    });
    $(document).delegate(".checkout-btn", "click", function () {
        try {
            fbq("track", "InitiateCheckout");
        } catch (e) {}
    });
    var b = $(".mc-toggler");
    b.on("click", function () {
        
    });
    var d = $(".cmpr-toggler");
    d.on("click", function () {
        
    });
});

$.fn.autocomplete = function (a) {
    return this.each(function () {
        var b = $(this),
            d = this;
        this.timer = null;
        this.items = [];
        this.wrap = '<ul class="dropdown-menu"></ul>';
        $.extend(this, a);
        b.attr("autocomplete", "off");
        b.on("focus", function () {
            d.request();
        });
        b.on("blur", function () {
            setTimeout(
                function (a) {
                    a.hide();
                },
                200,
                this
            );
        });
        b.on("keydown", function (a) {
            switch (a.keyCode) {
                case 27:
                    d.hide();
                    break;
                default:
                    d.request();
            }
        });
        d.click = function (a) {
            (value = $(a.target).parent().attr("data-value")) && this.items[value] && (a.preventDefault(), this.select(this.items[value]));
        };
        d.show = function () {
            var a = b.position(),
                d = b.siblings(".dropdown-menu");
            d.css({ top: a.top + b.outerHeight() + "px", left: a.left + "px" });
            d.show();
        };
        d.hide = function () {
            b.siblings(".dropdown-menu").hide();
        };
        this.request = function () {
            clearTimeout(d.timer);
            d.timer = setTimeout(
                function (a) {
                    a.source($(a).val(), a.response.bind(a));
                },
                500,
                this
            );
        };
        d.response = function (a) {
            var e = "";
            if (a.length) {
                for (i = 0; i < a.length; i++) d.items[a[i].value] = a[i];
                for (i = 0; i < a.length; i++) a[i].category || (e += '<li data-value="' + a[i].value + '"><a href="#">' + a[i].label + "</a></li>");
            }
            e ? d.show() : d.hide();
            b.siblings(".dropdown-menu").html(e);
        };
        b.after(this.wrap);
        b.siblings(".dropdown-menu").delegate("a", "click", this.click.bind(this));
    });
};
$.fn.button = function (a) {
    0 !== this.size() &&
        ("loading" === a ? (this.addClass("disabled"), this.attr("disabled", ""), this.data("old_text", this.text()), this.text("Loading...")) : (this.removeClass("disabled"), this.removeAttr("disabled"), this.text(this.data("old_text"))));
};
$.fn._scrollTo = function (a, b) {
    var d = this,
        e = null;
    if (1 < d.size()) {
        for (var g = 0; g < d.size(); g++) {
            var h = d.elements[g];
            if (h.scrollHeight > h.clientHeight) {
                e = h;
                break;
            }
        }
        e && (d = $(e));
    } else e = d.get(0);
    if (null == e)
        this.each(function () {
            this.scrollTop = a;
        });
    else if (!(0 >= b || 0 === d.size())) {
        var k = ((a - e.scrollTop) / b) * 10;
        setTimeout(
            function () {
                e.scrollTop += k;
                e.scrollTop !== a && this._scrollTo(a, b - 10);
            }.bind(d),
            10
        );
    }
};
$.fn.scrollTo = function (a, b) {
    try {
        window.scroll({ top: a, behavior: "smooth" });
    } catch (d) {
        window.scroll(0, a);
    }
};
function Popup(a, b) {
    var d = this;
    this.el = a = $('<div class="popup ' + b + '"><div class="popup-inner">' + a + '<span class="popup-close"></span></div></div>');
    a.find(".popup-close,.close").on("click", function () {
        d.close();
    });
    a.on("click", function (a) {
        $(a.target).is(".popup") && d.close();
    });
}
var _p = Popup.prototype;
_p.render = function () {
    this.timer && clearTimeout(this.timer);
    this.el.addClass("f-in").removeClass("f-out");
    $("body").append(this.el);
};
_p.close = function () {
    var a = this;
    a.el.addClass("f-out").removeClass("f-in");
    a.timer = setTimeout(function () {
        a.el.remove();
    }, 2e3);
};
function Tab(a) {
    var b = this;
    b.elm = a;
    b.headers = a.find("li");
    var d = null;
    b.headers.each(function () {
        var e = $(this);
        a.find("#" + e.attr("data-tab")).hide();
        e.on("click", function () {
            b.activate(e);
        });
        e.is(".active") && (d = e);
    });
    null == d && (d = $(b.headers.get(0)));
    b.activate(d);
}
var _t = Tab.prototype;
_t.activate = function (a) {
    this.active && (this.active.removeClass("active"), this.elm.find("#" + this.active.attr("data-tab")).hide());
    this.elm.find("#" + a.attr("data-tab")).show();
    a.addClass("active");
    this.active = a;
};
(function () {
    function a(a, b) {
        var d = new Image(),
            f = a.getAttribute("data-src");
        d.onload = function () {
            a.parent ? a.parent.replaceChild(d, a) : (a.src = f);
            b ? b() : null;
        };
        d.src = f;
    }
    function b(a) {
        a = a.getBoundingClientRect();
        return 0 <= a.top && 0 <= a.left && a.top <= (window.innerHeight || document.documentElement.clientHeight);
    }
    var d = [],
        e = function () {
            for (var e = [], h = 0; h < d.length; h++) b(d[h]) && (a(d[h]), e.push(d[h]));
            e.forEach(function (a) {
                a = d.indexOf(a);
                -1 < a && d.splice(a, 1);
            });
        };
    $(function () {
        $("img.lazy").each(function () {
            d.push(this);
        });
        e();
        window.addEventListener("scroll", e);
    });
})();

$(function () {
    function a(a) {
        var b = this;
        a.forEach(function (a) {
            var c = $(a.toggle);
            c.on("click", function () {
                c.hasClass("close") ? b.hide(a) : b.show(a);
            });
        });
    }
    function b(a) {
        var b = this;
        b.elm = a;
        b.slides = [];
        b.dots = [];
        var c = $("<div>", { class: "slider-dot" });
        a.find(".slide").each(function (a, d) {
            d = $(d);
            b.slides[a] = d;
            var e = $("<span>", { class: "dot" });
            c.append(e);
            b.dots[a] = e;
            d.hide();
            e.on("click", function () {
                b.showSlides(a);
            });
        });
        0 !== b.slides.length && (a.append(c), (b.index = 0), b.showSlides(0));
    }
    function d(a) {
        var b = a.position,
            d = '<a href="' + a.url + '"><img src="' + a.image + '" alt="' + a.title + '" class="img-responsive"></a>';
        1 == b
            ? setTimeout(function () {
                  var a = new Popup(d);
                  a.render();
                  localStorage.showed = c;
                  setTimeout(function () {
                      a.close();
                  }, 14e3);
              }, 6e3)
            : $(".ads-pos-" + b).html(d);
    }
    function e(a) {
        var b = this;
        b.elm = a;
        var c = isNaN(a.data("date")) ? a.data("date") : parseInt(a.data("date"));
        b.date = new Date(c).getTime();
        var d = setInterval(function () {
            var c = new Date().getTime();
            c = b.date - c;
            0 > c ? (a.trigger("complete"), clearInterval(d)) : b.update(c);
        }, 1e3);
    }
    var g = $("html"),
        h = $("body"),
        k = $(".overlay"),
        f = a.prototype;
    f.show = function (a) {
        this.active && this.hide(this.active);
        var b = $(a.target),
            c = $(a.toggle);
        a.overlay && k.addClass("open");
        a.no_scroll && $("body").addClass("no-scroll");
        c.addClass("close");
        b.addClass("open");
        this.active = a;
    };
    f.hide = function (a) {
        if ((a = a || this.active)) {
            var b = $(a.target);
            $(a.toggle).removeClass("close");
            b.removeClass("open");
            k.removeClass("open");
            $("body").removeClass("no-scroll");
            this.active = a;
        }
    };
    var p = new a([
        { toggle: "#nav-toggler", target: "#main-nav", overlay: !0, no_scroll: !0 },
        { toggle: ".mc-toggler", target: "#m-cart" },
        { toggle: ".cmpr-toggler", target: "#cmpr-panel" },
        { toggle: ".search-toggler", target: "#search" },
        { toggle: "#lc-toggle, .lc-close", target: "#column-left", overlay: !0, no_scroll: !0 },
    ]);
    k.on("click", function () {
        p.hide();
    });
   
    app.event.on("addToCart", function () {
        $(".mc-toggler").addClass("bounce");
        setTimeout(function () {
            $(".mc-toggler").removeClass("bounce");
        }, 900);
    });
    $(".has-child a").on("click", function (a) {
        $(this).parent().toggleClass("open");
        var b = $(a.target);
        ((isMobile() && b.is(".has-child > a")) || b.is(".responsive-menu > .has-child > a")) && a.preventDefault();
    });
    "" == $(".category-description").text() && $(".category-description").remove();
    b.prototype.showSlides = function (a) {
        this.timer && clearTimeout(this.timer);
        a >= this.slides.length && (a = 0);
        this.slides[this.index].hide();
        this.slides[a].show();
        this.dots[this.index].removeClass("active");
        this.dots[a].addClass("active");
        this.index = a;
        this.timer = setTimeout(this.showSlides.bind(this, ++a), 5e3);
    };
    $(".home-slider").each(function () {
        new b($(this));
    });
    window.addClearFix = function () {};
    window.addEventListener("scroll", function () {
        132 < g.scrollTop() ? h.addClass("on-scroll") : h.removeClass("on-scroll");
    });
    $(".alert .close").on("click", function () {
        $(this).parent(".alert").remove();
    });
    $("[data-area]").on("click", function (a) {
        a.preventDefault();
        a = $(this);
        $("html,body").scrollTo($("#" + a.data("area")).offset().top - 140, 600);
    });
    var c = new Date().getTime();
    f = localStorage.showed;
    var l = localStorage.lastVisited,
        n = [];
    f = parseInt(f);
    f = isNaN(f) ? null : f;
    l = parseInt(l);
    l = isNaN(l) ? null : l;
    var r = app.popupDuration ? app.popupDuration : 12;
    app.enablePopup && l && 36e4 > c - l && (!f || c - f > 36e5 * r) && n.push(1);
    $(".ads:not(.loaded)").each(function () {
        n.push($(this).attr("data-position"));
    });
    if (n.length) {
        var q = "device_type=" + (isMobile() ? 1 : 3);
        n.forEach(function (a) {
            q += "&ads_position[]=" + a;
        });
        $.ajax({
            url: "api/ads",
            data: q,
            method: "post",
            dataType: "json",
            success: function (a) {
                a.forEach(function (a) {
                    d(a);
                });
                (a = a[1]) && a.image && d(a.image, a.title, a.url);
            },
        });
    }
    f = new Date().getHours();
    9 <= f && 21 >= f && $(".svg-icon svg").show();
    localStorage.lastVisited = c;
   
    f = e.prototype;
    f.setGroupVal = function (a, b) {
        b = b.toString();
        1 === b.length && (b = "0" + b);
        var c = this.elm.find("." + a);
        c.find(".digit").remove();
        b.split("").forEach(function (a) {
            c.find(".tag").before('<span class="digit">' + a + "</span>");
        });
    };
    f.update = function (a) {
        this.setGroupVal("days", Math.floor(a / 864e5));
        this.setGroupVal("hours", Math.floor((a % 864e5) / 36e5));
        this.setGroupVal("minutes", Math.floor((a % 36e5) / 6e4));
        this.setGroupVal("seconds", Math.floor((a % 6e4) / 1e3));
    };
    $(".countdown").each(function () {
        new e($(this));
    });
});
