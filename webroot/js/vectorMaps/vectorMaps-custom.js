jQuery('#vmap').vectorMap({
    map: 'world_en',
    backgroundColor: null,
    color: '#ffffff',
    hoverOpacity: 0.7,
    selectedColor: '#666666',
    enableZoom: true,
    showTooltip: true,
    values: sample_data,
    scaleColors: ['#C8EEFF', '#006491'],
    normalizeFunction: 'polynomial'
});


jQuery('#vmapUSA').vectorMap({
    map: 'usa_en',
    backgroundColor: null,
    color: '#ffffff',
    hoverColor: '#999999',
    selectedColor: '#666666',
    enableZoom: true,
    showTooltip: true,
    selectedRegion: 'MO'
});