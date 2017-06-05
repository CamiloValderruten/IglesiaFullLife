/*jshint strict:false */

var url = "//" + document.domain + ':' + location.port;

function create_report(student_id, data, callback) {
    $.ajax({
        url: url + "/students/" + student_id + "/reports",
        type: "POST",
        data: JSON.stringify(data),
        dataType: "JSON",
        success: function (data) {
            data._id = data['_id']['$oid'];
            callback(data);
        }
    });
}
function get_reports(student_id, callback) {
    $.ajax({
        url: url + "/students/" + student_id + '/reports',
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $.each(data, function(i){
                data[i]._id = data[i]['_id']['$oid'];
            });
            return callback(data);
        }
    });
}
function get_report(student_id, report_id, callback) {
    $.ajax({
        url: url + "/students/" + student_id + '/reports/' + report_id + '?json=true',
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            data._id = data['_id']['$oid'];
            return callback(data);
        }
    });
}
function update_report(student_id, report_id, data, callback) {
    $.ajax({
        url: url + "/students/" + student_id + "/reports/" + report_id,
        type: "PUT",
        dataType: "JSON",
        data: JSON.stringify(data),
        success: callback
    });
}
function delete_report(student_id, report_id) {
    $.ajax({
        url: url + "/students/" + student_id + "/reports/" + report_id,
        type: "DELETE",
        dataType: "JSON",
        success: function () {
            window.location = "/students/" + student_id;
        }
    });
}
function send_report(student_id, report_id, parent_id, callback){
    $.ajax({
        url: url + "/students/" + student_id + "/reports/" + report_id + '/send',
        type: "POST",
        dataType: "JSON",
        data: JSON.stringify({parent_id: parent_id}),
        success: callback
    });
}

