/*jshint strict:false */

var url = location.protocol + "//" + document.domain + ':' + location.port;

function create_event(student_id, report_id, data, callback) {
    $.ajax({
        url: url + "/students/" + student_id + "/reports/" + report_id + '/events',
        type: "POST",
        dataType: "JSON",
        data: JSON.stringify(data),
        success: function (data) {
            data._id = data['_id']['$oid'];
            return callback(data);
        }
    });
}
function update_event(student_id, report_id, event_id, event, callback) {
    $.ajax({
        url: url + "/students/" + student_id + "/reports/" + report_id + '/events/' + event_id,
        type: "PUT",
        dataType: "JSON",
        data: JSON.stringify(event),
        success: callback
    });
}
function get_events(student_id, report_id, callback) {
    $.ajax({
        url: url + "/students/" + student_id + "/reports/" + report_id + '/events?json=true',
        dataType: "JSON",
        type: "GET",
        success: function (events) {
            $.each(events, function (i) {
                events[i]['_id'] = events[i]['_id']['$oid']
            });
            callback(events);
        }
    });
}