/*jshint strict:false */

var url = location.protocol + "//" + document.domain + ':' + location.port;

function create_student(data, callback) {
    $.ajax({
        method: 'POST',
        data: JSON.stringify(data),
        dataType: "JSON",
        url: url + "/students/",
        success: function (student) {
            student['_id'] = student['_id']['$oid'];
            callback(student);
        }
    });
}
function get_students(callback) {
    $.ajax({
        method: 'GET',
        dataType: "JSON",
        url: url + "/students/?json=true",
        success: function (students) {
            $.each(students, function (i) {
                students[i]._id = students[i]['_id']['$oid'];
            });
            callback(students);
        }
    });
}
function get_student(studentId, callback) {
    $.ajax({
        method: 'GET',
        dataType: "JSON",
        url: url + "/students/" + studentId + '?json=true',
        success: function (data) {
            data._id = data['_id']['$oid'];
            callback(data);
        }
    });
}
function update_student(studentId, data, callback) {
    $.ajax({
        method: 'PUT',
        data: JSON.stringify(data),
        dataType: "JSON",
        url: url + "/students/" + studentId,
        success: callback
    });
}
function delete_student(studentId) {
    $.ajax({
        url: url + "/students/" + studentId,
        type: "DELETE",
        success: function () {
            window.document.location = "/students";
        }
    });
}
function create_parent(data, callback) {
    $.ajax({
        method: 'POST',
        data: JSON.stringify(data),
        dataType: "JSON",
        url: url + "/parents/",
        success: function (parent) {
            parent['_id'] = parent['_id']['$oid'];
            callback(parent);
        }
    });
}
function get_parents(callback) {
    $.ajax({
        method: 'GET',
        dataType: "JSON",
        url: url + "/parents/?json=true",
        success: function (parents) {
            $.each(parents, function (i) {
                parents[i]._id = parents[i]['_id']['$oid'];
            });
            callback(parents);
        }
    });
}

function get_parent(parentId, callback) {
    $.ajax({
        method: 'GET',
        dataType: "JSON",
        url: url + "/parents/" + parentId + '?json=true',
        success: function (data) {
            data._id = data['_id']['$oid'];
            callback(data);
        }
    });
}

function update_parent(parentId, data, callback) {
    $.ajax({
        method: 'PUT',
        data: JSON.stringify(data),
        dataType: "JSON",
        url: url + "/parents/" + parentId,
        success: callback
    });
}

function delete_parent(parentId) {
    $.ajax({
        url: url + "/parents/" + parentId,
        type: "DELETE",
        success: function () {
            window.document.location = "/parents";
        }
    });
}

function search_student(studentName, callback) {
    $.ajax({
        method: 'POST',
        dataType: "JSON",
        url: url + "/students/search",
        data: JSON.stringify({name: studentName}),
        success: function (students) {
            $.each(students, function (i) {
                students[i]._id = students[i]['_id']['$oid'];
            });
            callback(students);
        }
    });
}
function link_parent_student(parentId, studentId, callback) {
    $.ajax({
        method: 'POST',
        dataType: "JSON",
        url: url + "/parents/" + parentId + "/students",
        data: JSON.stringify({student_id: studentId}),
        success: callback
    });
}
function get_parent_students(parentId, callback) {
    $.ajax({
        method: 'GET',
        dataType: "JSON",
        url: url + "/parents/" + parentId + '/students?json=true',
        success: function (students) {
            $.each(students, function (i, student) {
                students[i]['_id'] = students[i]['_id']['$oid'];
            });
            callback(students);
        }
    });
}
function change_password(accountId, password, callback) {
    $.ajax({
        method: 'POST',
        dataType: "JSON",
        url: url + "/settings/reset_password",
        data: JSON.stringify({"account_id": accountId, "password": password}),
        success: callback
    });
}
function send_verification(phoneNumber, callback, error) {
    $.ajax({
        method: 'POST',
        dataType: "JSON",
        url: url + "/verify",
        data: JSON.stringify({"cell_phone": phoneNumber}),
        success: callback,
        error: error
    });
}
function verify_account(phoneNumber, code, callback, error) {
    $.ajax({
        method: 'POST',
        dataType: "JSON",
        url: url + "/verify",
        data: JSON.stringify({"cell_phone": phoneNumber, "code": code}),
        success: callback,
        error: error
    });
}