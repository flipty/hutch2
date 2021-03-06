/*
 * Sidr - The Mobile Menu Creator
 *
 * @author Mat Lipe
 * @since 12.17.13
 *
 * https://github.com/lipemat/sidr  - forked
 *
 */

jQuery(function($){
   $('#nav-button').sidr({
      name: 'the-main-menu',
      source: '#nav_menu-2',
      side: 'left'
    });
});

//Below is compressed version https://github.com/lipemat/sidr/blob/master/dist/jquery.sidr.js
(function(e) {
  var f = false,
      d = false;
  var a = {
    init: function(g) {
      this.menu = g;
      this.mainUl = this.menu.find(".sidr-class-menu");
      this.pos = 0;
      this.speed = g.data("speed");
      this.side = g.data("side");
      this.width = g.outerWidth(true);
      this.menu.find(".sidr-class-sf-sub-indicator").html("&rarr;").click(function() {
        a.moveDown(e(this).parent());
        return false
      });
      this.menu.find("ul ul").prepend('<li class="sidr-class-menu-item back"><a title="Go Back on Level" href="javascript:void(0)"><span>&larr; Back</a></li>');
      this.menu.find("div > ul").prepend('<li class="sidr-class-menu-item close"><a title="Close Menu" href="javascript:void(0)"><span>Close X</a></li>');
      this.menu.find(".back").click(function() {
        a.moveUp()
      });
      this.menu.find(".close").click(function() {
        e.sidr("close", g.attr("id"))
      })
    },
    moveUp: function(g) {
      a.slide("up")
    },
    moveDown: function(g) {
      g.parent().parent().find("ul").hide();
      g.parent().find("ul").first().show();
      a.slide("down")
    },
    slide: function(g) {
      this.pos = this.mainUl.position();
      switch (g) {
      case "up":
        this.mainUl.animate({
          left: this.pos.left + this.width
        }, this.speed);
        break;
      case "down":
        this.mainUl.animate({
          left: this.pos.left - this.width
        }, this.speed);
        break
      }
    }
  };
  var c = {
    isUrl: function(h) {
      var g = new RegExp("^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$", "i");
      if (!g.test(h)) {
        return false
      } else {
        return true
      }
    },
    loadContent: function(g, h) {
      g.html(h);
      a.init(g)
    },
    addPrefix: function(g) {
      var h = g.attr("id"),
          i = g.attr("class");
      if (typeof h === "string" && "" !== h) {
        g.attr("id", h.replace(/([A-Za-z0-9_.\-]+)/g, "sidr-id-$1"))
      }
      if (typeof i === "string" && "" !== i && "sidr-inner" !== i) {
        g.attr("class", i.replace(/([A-Za-z0-9_.\-]+)/g, "sidr-class-$1"))
      }
      g.removeAttr("style")
    },
    execute: function(l, h, r) {
      if (typeof h === "function") {
        r = h;
        h = "sidr"
      } else {
        if (!h) {
          h = "sidr"
        }
      }
      var g = e("#" + h),
          n = e(g.data("body")),
          m = e("html"),
          p = g.outerWidth(true),
          j = g.data("speed"),
          q = g.data("side"),
          o, k, i;
      if ("open" === l || ("toogle" === l && !g.is(":visible"))) {
        if (g.is(":visible") || f) {
          return
        }
        if (d !== false) {
          b.close(d, function() {
            b.open(h)
          });
          return
        }
        f = true;
        if (q === "left") {
          o = {
            left: p + "px"
          };
          k = {
            left: "0px"
          }
        } else {
          o = {
            right: p + "px"
          };
          k = {
            right: "0px"
          }
        }
        i = m.scrollTop();
        m.css("overflow-x", "hidden").scrollTop(i);
        n.css({
          width: n.width(),
          position: "absolute"
        }).animate(o, j);
        g.css("display", "block").animate(k, j, function() {
          f = false;
          d = h;
          if (typeof r === "function") {
            r(h)
          }
        })
      } else {
        if (!g.is(":visible") || f) {
          return
        }
        f = true;
        if (q === "left") {
          o = {
            left: 0
          };
          k = {
            left: "-" + p + "px"
          }
        } else {
          o = {
            right: 0
          };
          k = {
            right: "-" + p + "px"
          }
        }
        i = m.scrollTop();
        m.removeAttr("style").scrollTop(i);
        n.animate(o, j);
        g.animate(k, j, function() {
          g.removeAttr("style");
          n.removeAttr("style");
          e("html").removeAttr("style");
          f = false;
          d = false;
          if (typeof r === "function") {
            r(h)
          }
        })
      }
    }
  };
  var b = {
    open: function(g, h) {
      c.execute("open", g, h)
    },
    close: function(g, h) {
      c.execute("close", g, h)
    },
    toogle: function(g, h) {
      c.execute("toogle", g, h)
    }
  };
  e.sidr = function(g) {
    if (b[g]) {
      return b[g].apply(this, Array.prototype.slice.call(arguments, 1))
    } else {
      if (typeof g === "function" || typeof g === "string" || !g) {
        return b.toogle.apply(this, arguments)
      } else {
        e.error("Method " + g + " does not exist on jQuery.sidr")
      }
    }
  };
  e.fn.sidr = function(i) {
    var m = e.extend({
      name: "sidr",
      speed: 200,
      side: "left",
      source: null,
      renaming: true,
      body: "body"
    }, i);
    var h = m.name,
        l = e("#" + h);
    if (l.length === 0) {
      l = e("<div />").attr("id", h).appendTo(e("body"))
    }
    l.addClass("sidr").addClass(m.side).data({
      speed: m.speed,
      side: m.side,
      body: m.body
    });
    if (typeof m.source === "function") {
      var g = m.source(h);
      c.loadContent(l, g)
    } else {
      if (typeof m.source === "string" && c.isUrl(m.source)) {
        e.get(m.source, function(o) {
          c.loadContent(l, o)
        })
      } else {
        if (typeof m.source === "string") {
          var n = "",
              k = m.source.split(",");
          e.each(k, function(o, p) {
            n += '<div class="sidr-inner">' + e(p).html() + "</div>"
          });
          if (m.renaming) {
            var j = e("<div />").html(n);
            j.find("*").each(function(p, q) {
              var o = e(q);
              c.addPrefix(o)
            });
            n = j.html()
          }
          c.loadContent(l, n)
        } else {
          if (m.source !== null) {
            e.error("Invalid Sidr Source")
          }
        }
      }
    }
    return this.each(function() {
      var p = e(this),
          o = p.data("sidr");
      if (!o) {
        p.data("sidr", h);
        p.click(function(q) {
          q.preventDefault();
          b.toogle(h)
        })
      }
    })
  }
})(jQuery);