from bson.json_util import dumps
from bson import ObjectId
from flask import Blueprint, request, abort, render_template, url_for
from flask_login import current_user
from datetime import datetime
from app.decorators import access_level
from ..utilities import db, clean_phone

blueprint = Blueprint('parents', __name__, url_prefix='/parents')


@blueprint.route("/", methods=['GET', 'POST'])
def parents(json=False):
    query = {"role": "parent"}

    @access_level("teacher")
    def get():
        data = db.accounts.find(query)
        if request.args.get('json') or json:
            return dumps(data)
        return render_template("parents/parents.html", parents=data)

    @access_level("administrator")
    def post():
        data = request.get_json(force=True)
        data['created'] = datetime.now()
        data['modified'] = datetime.now()
        data['profile_image_url'] = url_for('static',
                                            filename="images/default.png")
        data['role'] = "parent"
        data['cell_phone'] = clean_phone(data['cell_phone'])
        db.accounts.save(data)
        return dumps(data)

    if request.method == "GET":
        return get()
    if request.method == "POST":
        return post()


@blueprint.route("/<parent_id>/students", methods=['GET', 'POST'])
def students(parent_id):
    def post():
        student_id = request.get_json(force=True)['student_id']
        push = {"$push": {"parent_ids": ObjectId(parent_id)}}
        db.accounts.update({"_id": ObjectId(student_id)}, push)
        return dumps({"success": True})

    def get():
        query = {"role": "student", "parent_ids": ObjectId(parent_id)}
        if current_user.role in ['parent']:
            if parent_id != current_user.get_id():
                abort(404)
        return dumps(db.accounts.find(query))

    if request.method == "GET":
        return get()
    if request.method == "POST":
        return post()


@blueprint.route("/<parent_id>", methods=['GET', 'PUT', 'DELETE'])
def parent(parent_id, json=False):
    query = {"_id": ObjectId(parent_id), "role": "parent"}

    @access_level("parent")
    def get():
        data = db.accounts.find_one(query)
        data = data if data else abort(404)
        if request.args.get('json') or json:
            return dumps(data)
        return render_template("parents/parent.html", parent=data)

    @access_level("parent")
    def put():
        data = request.get_json(force=True)
        data['modified'] = datetime.now()
        data['cell_phone'] = clean_phone(data['cell_phone'])
        data['work_phone'] = clean_phone(data['work_phone'])
        db.accounts.update(query, {"$set": data})
        return dumps(data)

    @access_level("administrator")
    def delete():
        db.accounts.delete_one(query)
        return dumps({'success': True})

    if request.method == "GET":
        return get()
    if request.method == "PUT":
        return put()
    if request.method == "DELETE":
        return delete()
