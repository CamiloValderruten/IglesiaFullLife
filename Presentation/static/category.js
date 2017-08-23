function getCategories(callback) {
    $.ajax({
        url: "//" + document.domain + ':' + location.port + "/categories",
        dataType: "JSON",
        success: callback
    });
}

function createCategory(name, callback) {
    $.ajax({
        method: "POST",
        url: "//" + document.domain + ':' + location.port + "/categories",
        dataType: "JSON",
        data: JSON.stringify({name: name}),
        success: callback
    });
}

function deleteCategory(category) {
    $.ajax({
        url: "//" + document.domain + ':' + location.port + "/categories/" + category._id,
        dataType: "JSON",
        method: 'DELETE',
        success: function (data) {

        }
    });
}

function updateCategory(category, callback) {
    $.ajax({
        url: "//" + document.domain + ':' + location.port + "/categories/" + category._id,
        dataType: "JSON",
        data: JSON.stringify(category),
        method: 'PUT',
        success: callback
    });
}
