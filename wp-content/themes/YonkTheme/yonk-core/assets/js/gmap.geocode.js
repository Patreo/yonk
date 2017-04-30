function geocodeLatLng(componentName, marker) {
    (new google.maps.Geocoder()).geocode({ 'latLng': marker.getPosition() }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                var address_components = results[0].address_components;
                var geometry = results[0].geometry.location;

                var address;
                var number;
                var zipcode;
                var city;
                var country;

                for (var i = 0; i < address_components.length; i++) {
                    switch (address_components[i].types[0]) {
                        case "route":
                            address = address_components[i].long_name;
                            break;
                        case "locality":
                            city = address_components[i].long_name;
                            break;
                        case "country":
                            country = address_components[i].long_name;
                            break;
                        case "street_number":
                            number = address_components[i].long_name;
                            break;
                        case "postal_code_prefix":
                        case "zipcode":
                            zipcode = address_components[i].long_name;
                            break;
                    }
                }

                var data =  {
                    address: address,
                    number: number,
                    zipcode: zipcode,
                    city: city,
                    country: country,
                    lat: geometry.lat(),
                    lng: geometry.lng()
                };

                $('#' + componentName).val(JSON.stringify(data));
            }
        }
    });
}