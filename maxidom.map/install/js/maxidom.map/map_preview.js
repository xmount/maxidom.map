var arColor = ['#F2F7A6', '#F1B8AD', '#FF0000', '#FFA500', '#E6E6FA', '#32CD32', '#006400', '#1E90FF', '#808080'];

function map_show(map_id, data) {
    ymaps.ready(function () {

        data = JSON.parse(data);

        myMap = new ymaps.Map(map_id, {
            center: JSON.parse(data.CENTER),
            zoom: data.ZOOM,
            controls: ['zoomControl']
        });

        var arData = JSON.parse(data.DATA);
        var arPoligonName = [];
        var arPoligonColor = [];

        if (arData) {
	        for (var n = 0; n < arData.length; n++) {
	            var poligon_dimension = arData[n].poligon;
	            var poligonName = arData[n].settings.name;
	            var poligonColor = arData[n].settings.color;
	            arPoligonName[n] = poligonName;
	            arPoligonColor[n] = poligonColor;
	
	            myMap.geoObjects.add(new ymaps.Polygon([poligon_dimension],
	                {
	                    pointColor: poligonColor,
	                    deliveryZone: poligonName,
	                    hintContent: poligonName
	                }, {fillColor: poligonColor, strokeColor: '#6691eb', opacity: 0.5}));
	        }
        }
        if (!n)
            var n = 0;

        var myPolygon = new ymaps.Polygon([], {}, {
            editorDrawingCursor: "crosshair",
            fillColor: arColor[n],
            opacity: 0.5,
            strokeWidth: 3
        });

        arPoligonColor[n] = arColor[n];
        myMap.geoObjects.add(myPolygon);

        myMap.geoObjects.each(function (geoObject) {
            geoObject.editor.startEditing();
        })

        if (data.DATA) {
	        for (var n = 0; n < JSON.parse(data.DATA).length; n++) {
	            if (!arPoligonName[n]) arPoligonName[n] = "";
	            var input = '<input name = "mx_mp_settings_color" type="color" value="' + arPoligonColor[n] + '"> <input type="text" name = "mx_mp_settings_name" value="' + arPoligonName[n] + '">';
	            $('.mx_mp_settings').append(
	                '<div class="mx_mp_setting_col">' + input + '</div>'
	            );
	        }
        }
        $('.mx_mp_settings').append('<div style="margin-top: 20px;"><span class="map_button" id="saveColor">Сохранить цвета и названия</span></div>')

        $('#saveColor').on('click', function () {

            var nomer = 0;
            var arColorNew = [];
            var arNameNew = [];

            $('input[name="mx_mp_settings_color"]').each(function (index) {
                arColorNew[nomer] = $(this).val();
                nomer++;
            });

            var nomer = 0;

            $('input[name="mx_mp_settings_name"]').each(function (index) {
                arNameNew[nomer] = $(this).val();
                nomer++;
            });

            var poligons_data_settings = [];

            for (var n = 0; n < arData.length; n++) {
                var poligon_dimension = arData[n].poligon;
                poligons_data_settings.push({
                    poligon: poligon_dimension,
                    settings: {name: arNameNew[n], color: arColorNew[n]}
                });
            }
            var json = JSON.stringify(poligons_data_settings);

            save_poligon(json);

        });

        $('#EditSetting').on('click', function () {
            if ($('.mx_mp_settings').is(":visible")) {
                $('.mx_mp_settings').hide();
                $('#EditSetting').html('Отредактировать цвета и названия');
            } else {
                $('.mx_mp_settings').show();
                $('#EditSetting').html('Не редактировать цвета и названия');
            }

        });
        $('#startDrawing').on('click', function () {
            $('#startDrawing').css('background', '#f6f6f6');
            $('#stopDrawing').css('background', 'antiquewhite');
            myPolygon.editor.startDrawing();
        });

        $('#stopDrawing').on('click', function () {
            $('#startDrawing').css('background', 'antiquewhite');
            $('#stopDrawing').css('background', '#f6f6f6');

            myPolygon.editor.stopDrawing();
            myPolygon.editor.stopEditing();


            if (myPolygon.geometry.getCoordinates().length > 0) {

                var poligon_dimension = [];
                var nomer = 0;
                var poligons_data = [];

                myMap.geoObjects.each(function (geoObject) {
                    if (geoObject.geometry.getCoordinates().length == 0) {
                        myMap.geoObjects.remove(geoObject);
                    } else if (geoObject.geometry.getCoordinates()[0].length < 3) {
                        myMap.geoObjects.remove(geoObject);
                    }
                })

                myMap.geoObjects.each(function (geoObject) {
                    poligon_dimension[nomer] = geoObject.geometry.getCoordinates();
                    poligons_data.push({
                        poligon: geoObject.geometry.getCoordinates()[0],
                        settings: {name: arPoligonName[nomer], color: arPoligonColor[nomer]}
                    })
                    nomer++;
                });

                var json = JSON.stringify(poligons_data);

                save_poligon(json);
            }
        });
    });
}

$(document).ready(function () {
    mx_mp_ya_map_preview.style.display = 'block';
    $.post("/bitrix/components/maxidom/maxidom.map/tools/poligon_get.php")
        .done(function (data) {
            map_show('mx_mp_ya_map_preview', data);
        });
});

function save_poligon(data) {

    var newCenter = JSON.stringify(myMap.getCenter());
    var newZoom = myMap.getZoom();

    $.ajax({
        type: "POST",
        url: "/bitrix/components/maxidom/maxidom.map/tools/poligon_save.php",
        data: {"data": data, "center": newCenter, "zoom": newZoom},
        success: function (result) {
        }
    });
}