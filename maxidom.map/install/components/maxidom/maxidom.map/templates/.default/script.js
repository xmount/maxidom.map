$(document).ready(function () {
    var DATA = BX.message('DATA');
    var CENTER = BX.message('CENTER');
    var ZOOM = BX.message('ZOOM');
    map_show('mx_mp_ya_map_preview', DATA, CENTER, ZOOM);
})

function map_show(map_id, DATA, CENTER, ZOOM) {
    ymaps.ready(function () {
        myMap = new ymaps.Map(map_id, {
            center: CENTER,
            zoom: ZOOM,
            controls: ['zoomControl']
        });

        var arData = DATA;
        for (var n = 0; n < arData.length; n++) {
            var poligon_dimension = arData[n].poligon;
            var poligonName = arData[n].settings.name;
            var poligonColor = arData[n].settings.color;
            myMap.geoObjects.add(new ymaps.Polygon([poligon_dimension],
                {
                    pointColor: poligonColor,
                    deliveryZone: poligonName,
                    hintContent: poligonName
                }, {fillColor: poligonColor, strokeColor: '#6691eb', opacity: 0.5}));
        }


    })
}

