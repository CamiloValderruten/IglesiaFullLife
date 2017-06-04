from flask import Flask
from flask import request
from flask import render_template

from flask_socketio import SocketIO
from flask_socketio import emit

from pymongo import MongoClient
from bson.json_util import dumps
from bson import ObjectId

import os

host = "mongodb" if os.environ.get('ENVIRONMENT') == "PRODUCTION" else "0.0.0.0"
db = MongoClient(host=host)['Presentation']
app = Flask(__name__)
app.config['SECRET_KEY'] = 'BNJqqX8cuQe^$U68DrxMb8aGSk8LaD0CKO$78WKB!ySM'
socket = SocketIO(app)


@app.route('/')
def home():
    return render_template('home.html')


@app.route('/clock')
def clock():
    return render_template('clock.html')


@app.route('/timers', methods=['POST', 'GET'])
def timers():
    if request.method == "GET":
        return dumps(db.timers.find(request.args))
    data = request.get_json(force=True)
    db.timers.save(data)
    return dumps(data)


@app.route('/timers/<_id>', methods=['PUT', 'GET', 'DELETE'])
def timer(_id):
    if request.method == "GET":
        return dumps(db.timer.find_one(ObjectId(_id)))
    if request.method == "PUT":
        data = request.get_json(force=True)
        db.timers.update({"_id": ObjectId(_id)}, data)
        return dumps(data)
    if request.method == "DELETE":
        db.timers.delete_one({"_id": ObjectId(_id)})
        return dumps({"success": True})


@app.route('/categories', methods=['POST', 'GET'])
def categories():
    if request.method == "GET":
        return dumps(db.categories.find())
    data = request.get_json(force=True)
    db.categories.save(data)
    return dumps(data)


@app.route('/categories/<_id>', methods=['PUT', 'GET', 'DELETE'])
def category(_id):
    if request.method == "GET":
        return dumps(db.categories.find_one(ObjectId(_id)))
    if request.method == "PUT":
        data = request.get_json(force=True)
        db.categories.update({"_id": ObjectId(_id)}, data)
        return dumps(data)
    if request.method == "DELETE":
        db.categories.delete_one({"_id": ObjectId(_id)})
        return dumps({"success": True})


@socket.on('start_timer')
def start_timer(data):
    emit('clock_start', data, broadcast=True)


@socket.on('timer_done')
def timer_done(data):
    emit('timer_done', data, broadcast=True)


@socket.on('timer_changed')
def timer_changed(data):
    emit('timer_changed', data, broadcast=True)
