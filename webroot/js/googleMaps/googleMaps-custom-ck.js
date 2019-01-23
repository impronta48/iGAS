$("#map_canvas").gmap().bind("init", function(e, t) {
    $("#map_canvas").gmap("addMarker", {
        position: "57.7973333,12.0502107",
        bounds: !0
    }).click(function() {
        $("#map_canvas").gmap("openInfoWindow", {
            content: "Hello World!"
        }, this);
    });
});

$("#map_clustering").gmap({
    zoom: 2,
    disableDefaultUI: !0
}).bind("init", function(e, t) {
    var n = t.getBounds(), r = n.getSouthWest(), i = n.getNorthEast(), s = i.lng() - r.lng(), o = i.lat() - r.lat();
    for (var u = 0; u < 1e3; u++) {
        var a = r.lat() + o * Math.random(), f = r.lng() + s * Math.random();
        $("#map_clustering").gmap("addMarker", {
            position: new google.maps.LatLng(a, f)
        }).click(function() {
            $("#map_clustering").gmap("openInfoWindow", {
                content: "Hello world!"
            }, this);
        });
    }
    $("#map_clustering").gmap("set", "MarkerClusterer", new MarkerClusterer(t, $(this).gmap("get", "markers")));
});

$("#map_html5").gmap().bind("init", function(e, t) {
    $("[data-gmapping]").each(function(e, t) {
        var n = $(t).data("gmapping");
        $("#map_html5").gmap("addMarker", {
            id: n.id,
            tags: n.tags,
            position: new google.maps.LatLng(n.latlng.lat, n.latlng.lng),
            bounds: !0
        }, function(e, n) {
            $(t).click(function() {
                $(n).triggerEvent("click");
            });
        }).click(function() {
            $("#map_html5").gmap("openInfoWindow", {
                content: $(t).find(".info-box").text()
            }, this);
        });
    });
});