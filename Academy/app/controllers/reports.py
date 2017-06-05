import boto3
import os

from app.decorators import access_level
from bson import ObjectId
from bson.json_util import dumps
from datetime import datetime
from flask import abort
from flask import Blueprint
from flask import current_app as app
from flask import render_template
from flask import request
from flask import url_for
from flask_login import current_user
from pymongo import MongoClient

blueprint = Blueprint('reports', __name__,
                      url_prefix="/students/<student_id>/reports")
db = MongoClient().db


@blueprint.route('/', methods=['POST', 'GET'])
def reports(student_id):
    query = {"_id": ObjectId(student_id)}
    if "parent" in current_user.roles:
        query['parent_ids'] = ObjectId(current_user.id)
        if not db.accounts.find_one(query): abort(404)

    @access_level('parent')
    def get():
        data = db.reports.find({"student_id": ObjectId(student_id)})
        return dumps(list(data))

    @access_level('teacher')
    def create():
        data = request.get_json(force=True)
        data['type'] = data['type'].lower()
        data['created'] = datetime.now()
        data['modified'] = datetime.now()
        data['created_by'] = ObjectId(current_user.id)
        data['student_id'] = student_id
        db.reports.save(data)
        return dumps(data)

    if request.method == "POST":
        return create()
    elif request.method == "GET":
        return get()


@blueprint.route("/<report_id>", methods=['PUT', 'GET', 'DELETE'])
def report(student_id, report_id):
    query = {"_id": ObjectId(student_id)}
    if "parent" in current_user.roles:
        query['parent_ids'] = ObjectId(current_user.id)
        if not db.accounts.find_one(query): abort(404)

    @access_level('parent')
    def get():
        data = dict()
        data['report'] = db.reports.find_one(ObjectId(report_id))
        data['student'] = db.accounts.find_one(ObjectId(student_id))
        return render_template('reports/report.html', **data)

    @access_level('teacher')
    def update():
        data = request.get_json(force=True)
        data['modified'] = datetime.now()
        data['modified_by'] = datetime.now()
        db.reports.update({'_id': report_id}, {"$set": data})
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


@blueprint.route('/<report_id>/events', methods=['POST', 'GET', 'DELETE'])
def events(student_id, report_id):
    query = {"_id": ObjectId(student_id)}
    if "parent" in current_user.roles:
        query['parent_ids'] = ObjectId(current_user.id)
        if not db.accounts.find_one(query): abort(404)

    @access_level('parent')
    def get_events():
        data = db.events.find({"report_id": ObjectId(report_id)})
        return dumps(list(data))

    @access_level('teacher')
    def create_event():
        data = request.get_json(force=True)
        data['created'] = datetime.now()
        data['modified'] = datetime.now()
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


@blueprint.route('/<report_id>/events/<event_id>', methods=['GET', 'PUT', 'DELETE'])
def event(student_id, report_id, event_id):
    event_id = ObjectId(event_id)

    @access_level('parent')
    def get_event():
        return dumps(db.events.find_one())

    @access_level('teacher')
    def update_event():
        data = request.get_json(force=True)
        data['modified'] = datetime.now()
        data['modified_by'] = ObjectId(current_user._id)
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


@blueprint.route('/<report_id>/images', methods=['POST'])
def images(student_id, report_id):
    report_id = ObjectId(report_id)
    file = request.files.get('file')
    image = dict(_id=ObjectId(), report_id=report_id,
                 uploaded_by=current_user._id)
    report_path = app.config['UPLOAD_FOLDER'] + "images/reports/" + str(
        report_id)
    if not os.path.exists(report_path):
        os.mkdir(report_path)
    image['source'] = "images/reports/{}/{}".format(report_id, image['_id'])
    image['path'] = app.config['UPLOAD_FOLDER'] + image['source']
    file.save(image['path'])
    db.reports.update({'_id': report_id}, {'$push': {'images': image}})
    return dumps(image)


@blueprint.route('/<report_id>/messages', methods=['POST', 'GET'])
def messages(student_id, report_id):
    report_id = ObjectId(report_id)
    if request.method == "POST":
        message = dict(text=request.get_json(force=True).get('message'))
        message["_id"] = ObjectId()
        message['created_at'] = datetime.now()
        name = current_user.first_name + " " + current_user.last_name
        message['sender'] = {"_id": current_user._id, "name": name,
                             "profile_image": current_user.profile_image}
        message['report_id'] = report_id
        db.reports.update({'_id': report_id}, {'$push': {'messages': message}})
        return dumps(message)
    elif request.method == "GET":
        return dumps(db.reports.find(report_id).get('messages'), [])
    else:
        return abort(405)

