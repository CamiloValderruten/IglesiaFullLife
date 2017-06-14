
function getTimers(categoryName, callback) {
    $.ajax({
        url: "//" + document.domain + ':' + location.port + "/timers",
        dataType: "JSON",
        data: {category: categoryName},
        success: callback
    });
}

function createTimer(timer, callback) {
    $.ajax({
        method: "POST",
        url: "//" + document.domain + ':' + location.port + "/timers",
        dataType: "JSON",
        data: JSON.stringify(timer),
        success: callback
    });
}

function updateTimer(timer, callback) {
    $.ajax({
        url: "//" + document.domain + ':' + location.port + "/timers/" + timer._id,
        dataType: "JSON",
        data: JSON.stringify(timer),
        method: 'PUT',
        success: callback
    });
}

function deleteTimer(timer, callback) {
    $.ajax({
        url: "//" + document.domain + ':' + location.port + "/timers/" + timer._id['$oid'],
        dataType: "JSON",
        method: 'DELETE',
        success: callback
    });
}
