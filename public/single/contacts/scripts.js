"use strict";
! function() {
    var e, r, n, s, a, i;
    "undefined" == typeof knife_custom_contacts || null !== (e = document.querySelector(".entry-content")) && (n = function(e) {
        r("button", {
            classes: ["button", "button--option"],
            html: e.case,
            parent: i
        }).addEventListener("click", function(t) {
            for (t.preventDefault(); i.firstChild;) i.removeChild(i.lastChild);
            r("h5", {
                html: e.case,
                parent: i
            }), r("h4", {
                html: e.more,
                parent: i
            }), e.options.forEach(function(t, e) {
                var n;
                r("button", {
                    classes: ["button", "button--option"],
                    html: (n = t).case,
                    parent: i
                }).addEventListener("click", function(t) {
                    for (t.preventDefault(); i.firstChild;) i.removeChild(i.lastChild);
                    r("h5", {
                        html: n.case,
                        parent: i
                    }), r("p", {
                        html: n.answer,
                        parent: i
                    }), a.textContent = knife_custom_contacts.retry, i.appendChild(a)
                })
            })
        })
    }, s = (r = function(t, e) {
        var n = document.createElement(t);
        if (e.hasOwnProperty("class") && n.classList.add(e.class), e.hasOwnProperty("classes") && e.classes.forEach(function(t) {
                n.classList.add(t)
            }), e.hasOwnProperty("text") && (n.textContent = e.text), e.hasOwnProperty("html") && (n.innerHTML = e.html), e.hasOwnProperty("attributes"))
            for (var r in e.attributes) n.setAttribute(r, e.attributes[r]);
        return e.hasOwnProperty("parent") && e.parent.appendChild(n), n
    })("p", {
        parent: e
    }), a = r("button", {
        text: knife_custom_contacts.start,
        classes: ["button", "button--start"],
        parent: s
    }), i = r("figure", {
        classes: ["figure", "figure--survey"]
    }), a.addEventListener("click", function(t) {
        for (t.preventDefault(); i.firstChild;) i.removeChild(i.lastChild);
        null !== s && e.removeChild(s), s = null, r("h4", {
            parent: i,
            html: knife_custom_contacts.heading
        }), knife_custom_contacts.fields.forEach(function(t, e) {
            n(t)
        }), e.appendChild(i)
    }))
}();