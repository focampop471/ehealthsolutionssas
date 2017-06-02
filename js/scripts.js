function initMap() {
    $.ajax({
        url: "js/company.json",
        success: function (response) {
            var uluru = response;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map,
                animation: google.maps.Animation.DROP,
            });
        }
    });

}