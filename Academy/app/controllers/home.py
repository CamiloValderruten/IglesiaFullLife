from flask import Blueprint, render_template, request, jsonify, redirect, \
    url_for, abort
from bson.json_util import dumps
from app.decorators import access_level
from .students import students
from bson import json_util, ObjectId
from werkzeug.security import check_password_hash, generate_password_hash
from flask_login import login_user, logout_user, current_user
from ..models import Account
import boto3
import random
from flask import current_app as app
from ..utilities import clean_phone, db, upload_profile_image

blueprint = Blueprint("home", __name__)


@blueprint.route('/', methods=['GET'])
@access_level("student")
def dashboard():
    data = {"students": json_util.loads(students(json=True))}
    return render_template('home.html', **data)


@blueprint.route('/login', methods=['POST', 'GET'])
def login():
    def post():
        data = request.get_json(force=True)
        cell_phone = clean_phone(data['cell_phone'])
        account = db.accounts.find_one({"cell_phone": cell_phone})
        if account:
            hashed = account.get('password')
            if hashed and check_password_hash(hashed, data['password']):
                if login_user(Account(account)):
                    return jsonify({'success': True})
        return jsonify({'success': False}), 400

    if request.method == "POST":
        return post()
    return render_template('login.html', next=request.args.get('next'))


@blueprint.route('/logout', methods=['GET'])
@access_level("student")
def logout():
    logout_user()
    return redirect(url_for('home.login'))


@blueprint.route('/verify', methods=['POST', 'GET'])
def verify():
    if request.method == 'GET':
        return render_template('activate.html')
    client = boto3.client('sns')
    data = request.get_json(force=True)
    cell_phone = clean_phone(data['cell_phone'])
    code = data.get('code')
    account = db.accounts.find_one({"cell_phone": cell_phone})
    if account:
        if code:
            if str(code) == str(account.get('activation_code')):
                login_user(Account(account))
                return json_util.dumps(account)
            else:
                return jsonify(
                    {"success": False,
                     "message": "Incorrect activation code"}), 400
        code = random.randint(111111, 999999)
        name = app.config['DAYCARE_NAME']
        message = "Your activation code for {} is {}".format(name, code)
        client.publish(Message=message, PhoneNumber=cell_phone)
        db.accounts.update({"_id": account['_id']},
                           {"$set": {"activation_code": code}})
        return jsonify({'success': True})
    else:
        return jsonify(
            {"success": False,
             "message": "Could not find account with cell phone"}), 404


@blueprint.route('/settings', methods=['GET'])
def settings():
    return render_template('settings.html')


@blueprint.route('/settings/reset_password', methods=['POST'])
@access_level('student')
def reset_password():
    data = request.get_json(force=True)
    account_id = data['account_id']
    password = data['password']
    if account_id == current_user.get_id():
        hashed_password = generate_password_hash(password)
        db.accounts.update({"_id": ObjectId(account_id)},
                           {"$set": {"password": hashed_password}})
        return jsonify({"success": True})
    return jsonify({"success": False}), 400

@blueprint.route("/<account_type>/<id_>/image", methods=["POST"])
def image(account_type, id_):
    url = upload_profile_image(id_, request.files['file'])
    return dumps({"source": url})