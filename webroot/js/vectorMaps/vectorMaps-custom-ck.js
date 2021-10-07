jQuery("#vmap").vectorMap({
    map: "world_en",
    backgroundColor: null,
    color: "#ffffff",
    hoverOpacity: .7,
    selectedColor: "#666666",
    enableZoom: !0,
    showTooltip: !0,
    values: sample_data,
    scaleColors: [ "#C8EEFF", "#006491" ],
    normalizeFunction: "polynomial"
});

jQuery("#vmapUSA").vectorMap({
    map: "usa_en",
    backgroundColor: null,
    color: "#ffffff",
    hoverColor: "#999999",
    selectedColor: "#666666",
    enableZoom: !0,
    showTooltip: !0,
    selectedRegion: "MO"
});