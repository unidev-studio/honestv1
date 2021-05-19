var myMap;

ymaps.ready(init);

function init() {
    var myProjection = new ymaps.projection.Cartesian([
        [-4096, -4096],
        [4096, 4096]
    ]),
            MyLayer = function() {
        return new ymaps.Layer(
                                function(tile, zoom) {

                                    return "/resource/img/map/map/tile-" + zoom + "-" + tile[1] + "-" + tile[0] + ".jpg";
                                }
                        );
                    };

            ymaps.layer.storage.add('my#layer', MyLayer);
            ymaps.mapType.storage.add('my#type', new ymaps.MapType(
                    'Схема',
                    ['my#layer']
                    ));
            myMap = new ymaps.Map('map', {
                center: [0, 0],
                zoom: 3,
                type: 'my#type'
            }, {
                maxZoom: 5,
                minZoom: 2, 
                projection: myProjection,
                restrictMapArea: [[-4096, -4096], [4096, 4096]]
            });

            myMap.controls
                    .add(new ymaps.control.MiniMap({
                type: 'my#type'
            }))
                    .add('smallZoomControl', {
                right: 5,
                top: 5
            });

            for (var i = 0; i < houseList.length; i++) {
                placemark = new ymaps.Placemark([houseList[i].y, houseList[i].x], {
                    balloonContentHeader: houseList[i].address,
                    balloonContentBody: houseList[i].owner
                }, { 
                    iconImageHref:  "/resource/img/map/mapicon/" + houseList[i].mapIconTypeForSale + ".png",
                    iconImageSize: [24, 24],
                    iconImageOffset: [0, 0]
                  });

                myMap.geoObjects.add(placemark);
            }

        }