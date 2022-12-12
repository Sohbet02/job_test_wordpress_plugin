document.addEventListener('DOMContentLoaded', function (params) {
    var city = document.querySelector("#city");
    var dealers = document.querySelectorAll('.dealer');

    city.addEventListener("change", function (e) {
        var cityId = city.options[city.selectedIndex].id;

        dealers.forEach(function (dealer) {
            if (cityId == -1) {
                dealer.style = "display: block;";
            } else if (dealer.getAttribute('city-id') !== cityId) {
                dealer.style = "display: none;";
            } else {
                dealer.style = "display: block;";
            }
        })
    });
})