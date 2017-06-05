from bson.json_util import dumps
from bson import ObjectId
from flask import Blueprint, request, abort, render_template
from flask_login import current_user
from datetime import datetime
from app.decorators import access_level
from ..utilities import db

blueprint = Blueprint('administrators', __name__, url_prefix='/administrators')


@blueprint.route("/", methods=['GET', 'POST'])
def administrators(json=False):
    query = {"role": "student"}
    if current_user.role == "parent":
        query['parent_ids'] = ObjectId(current_user.id)

    @access_level("parent")
    def get():
        data = dict(accounts=db.accounts.find(query))
        data['role'] = "student"
        if request.args.get('json') or json:
            return dumps(data['accounts'])
        return render_template("accounts/list.html", **data)

    def post():
        data = request.get_json(force=True)
        data['created'] = datetime.now()
        data['modified'] = datetime.now()
        data['role'] = "student"
        data['parent_ids'] = [ObjectId(i) for i in data['parent_ids']]
        db.accounts.save(data)
        return dumps(data)

    if request.method == "GET":
        return get()
    if request.method == "POST":
        return post()


@blueprint.route("/<_id>", methods=['GET', 'PUT', 'DELETE'])
def administrator(_id, json=False):
    query = {"_id": ObjectId(_id), "role": "student"}
    if current_user.role == "parent":
        query['parent_ids'] = ObjectId(current_user.id)

    @access_level("parent")
    def get():
        data = db.accounts.find_one(query)
        data = data if data else abort(404)
        if request.args.get('json') or json:
            return dumps(data)
        return render_template("accounts/account.html", account=data)

    @access_level("parent")
    def put():
        data = request.get_json(force=True)
        data['modified'] = datetime.now()
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