from bson.json_util import dumps
from bson import ObjectId
from flask import Blueprint, request, abort, render_template, url_for
from flask_login import current_user
from datetime import datetime
from app.decorators import access_level
from ..utilities import db
import boto3

blueprint = Blueprint('students', __name__, url_prefix='/students')


@blueprint.route("/", methods=['GET', 'POST'])
def students(json=False):
    query = {"role": "student"}
    if current_user.role == "parent":
        query['parent_ids'] = ObjectId(current_user.get_id())

    @access_level("parent")
    def get():
        data = dict(students=db.accounts.find(query))
        if request.args.get('json') or json:
            return dumps(data['students'])
        return render_template("students/students.html", **data)

    @access_level("administrator")
    def post():
        data = request.get_json(force=True)
        data['created'] = datetime.now()
        data['modified'] = datetime.now()
        data['role'] = "student"
        data['parent_ids'] = [ObjectId(data['parent_id'])]
        data['profile_image_url'] = url_for('static',
                                            filename="images/default.png")
        db.accounts.save(data)
        return dumps(data)

    if request.method == "GET":
        return get()
    if request.method == "POST":
        return post()


@blueprint.route("/<student_id>", methods=['GET', 'PUT', 'DELETE'])
def student(student_id, json=False):
    query = {"_id": ObjectId(student_id), "role": "student"}
    if current_user.role == "parent":
        query['parent_ids'] = ObjectId(current_user.get_id())

    @access_level("parent")
    def get():
        data = db.accounts.find_one(query)
        data = data if data else abort(404)
        if request.args.get('json') or json:
            return dumps(data)
        return render_template("students/student.html", student=data)

    @access_level("parent")
    def put():
        data = request.get_json(force=True)
        data['modified'] = datetime.now()
        db.accounts.update(query, {"$set": data})
        return dumps(data)

    @access_level("administrator")
    def delete():
        db.accounts.delete_one(query)
        db.reports.delete_many({"student_id": ObjectId(student_id)})
        db.events.delete_many({"student_id": ObjectId(student_id)})
        return dumps({'success': True})

    if request.method == "GET":
        return get()
    if request.method == "PUT":
        return put()
    if request.method == "DELETE":
        return delete()


@blueprint.route("/<student_id>/reports", methods=['GET', 'POST'])
def reports(student_id):
    query = {"_id": ObjectId(student_id)}
    if current_user.role in ['parent']:
        query['parent_ids'] = ObjectId(current_user.get_id())
        if not db.accounts.find_one(query): abort(404)

    @access_level('parent')
    def get():
        data = db.reports.find({"student_id": ObjectId(student_id)})
        return dumps(list(data))

    @access_level('teacher')
    def create():
        data = request.get_json(force=True)
        data['created'] = datetime.now()
        data['modified'] = datetime.now()
        data['created_by'] = ObjectId(current_user.get_id())
        data['student_id'] = ObjectId(student_id)
        db.reports.save(data)
        return dumps(data)

    if request.method == "POST":
        return create()
    elif request.method == "GET":
        return get()


@blueprint.route("/<student_id>/reports/<report_id>",
                 methods=['PUT', 'GET', 'DELETE'])
@access_level()
def report(student_id, report_id):
    query = {"_id": ObjectId(student_id)}
    if current_user.role in ['parent']:
        query['parent_ids'] = ObjectId(current_user.get_id())
        if not db.accounts.find_one(query): abort(404)

    @access_level('parent')
    def get():
        data = dict()
        data['report'] = db.reports.find_one(ObjectId(report_id))
        data['student'] = db.accounts.find_one(ObjectId(student_id))
        template = 'reports/{}.html'.format(data['report']['title'].lower())
        if request.args.get('json'):
            return dumps(data['report'])
        return render_template(template, **data)

    @access_level('teacher')
    def update():
        data = request.get_json(force=True)
        data['modified'] = datetime.now()
        data['modified_by'] = datetime.now()
        db.reports.update({'_id': ObjectId(report_id)}, {"$set": data})
        return dumps(data)

    @access_level('teacher')
    def delete():
        db.reports.delete_one({"_id": ObjectId(report_id)})
        return dumps({'success': True})

    if request.method == "GET":
        return get()
    elif request.method == "PUT":
        return update()
    elif request.method == "DELETE":
        return delete()


@blueprint.route('/<student_id>/reports/<report_id>/events',
                 methods=['POST', 'GET', 'DELETE'])
def events(student_id, report_id):
    query = {"_id": ObjectId(student_id)}
    if current_user.role in ['parent']:
        query['parent_ids'] = ObjectId(current_user.get_id())
        if not db.accounts.find_one(query): abort(404)

    @access_level('student')
    def get_events():
        data = db.events.find({"report_id": ObjectId(report_id)})
        return dumps(list(data))

    @access_level('teacher')
    def create_event():
        data = request.get_json(force=True)
        data['created'] = datetime.now()
        data['modified'] = datetime.now()
        data['student_id'] = ObjectId(student_id)
        data['created_by'] = ObjectId(current_user.id)
        data['report_id'] = ObjectId(report_id)
        db.events.save(data)
        return dumps(data)

    @access_level('teacher')
    def delete_events():
        db.events.delete_many({"report_id": ObjectId(report_id)})
        return dumps({"success": True})

    if request.method == 'GET':
        return get_events()
    elif request.method == 'POST':
        return create_event()
    elif request.method == 'DELETE':
        return delete_events()


@blueprint.route('/<student_id>/reports/<report_id>/events/<event_id>',
                 methods=['GET', 'PUT', 'DELETE'])
def event(student_id, report_id, event_id):
    event_id = ObjectId(event_id)

    @access_level('parent')
    def get_event():
        return dumps(db.events.find_one())

    @access_level('teacher')
    def update_event():
        data = request.get_json(force=True)
        data['modified'] = datetime.now()
        data['modified_by'] = ObjectId(current_user.id)
        db.events.update({'_id': event_id}, {"$set": data})
        return get_event()

    @access_level('teacher')
    def delete_event():
        db.events.delete_one({'_id': event_id})
        return dumps({"success": True})

    if request.method == "GET":
        return get_event()

    elif request.method == "PUT":
        return update_event()

    elif request.method == "DELETE":
        return delete_event()


@blueprint.route('/<student_id>/reports/<report_id>/send', methods=["POST"])
@access_level('teacher')
def report_send(student_id, report_id):
    sns = boto3.client('sns')
    parent_id = request.get_json(force=True)['parent_id']
    parent = db.accounts.find_one(ObjectId(parent_id))
    _student = db.accounts.find_one(ObjectId(student_id))
    message = "{name}'s daily report is now available! {link}"
    url = url_for('students.report', student_id=student_id, report_id=report_id)
    link = request.url_root[:-1] + url

    if parent['_id'] in _student['parent_ids']:
        message = message.format(name=_student['name'], link=link)
        sns.publish(Message=message, PhoneNumber=parent['cell_phone'])
        return dumps({"success": True})
    return dumps({"success": False}), 400


@blueprint.route('/search', methods=["POST"])
@access_level('teacher')
def search():
    name = request.get_json(force=True)['name']
    data = []
    if len(name) > 0:
        query = {'name': {'$regex': name, '$options': 'i'}, 'role': 'student'}
        data = db.accounts.find(query).limit(10)
    return dumps(data)
