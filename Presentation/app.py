from flask import Flask
from flask import request
from flask import render_template

from flask_socketio import SocketIO
from flask_socketio import emit

from pymongo import MongoClient
from bson.json_util import dumps
from bson import ObjectId

import os
from datetime import timedelta

host = "mongodb" if os.environ.get('ENVIRONMENT') == "PRODUCTION" else "0.0.0.0"
db = MongoClient(host=host)['Presentation']
app = Flask(__name__)
app.config['SECRET_KEY'] = 'BNJqqX8cuQe^$U68DrxMb8aGSk8LaD0CKO$78WKB!ySM'
socket = SocketIO(app, async='eventlet')

thread = None
currentTimer = None
paused = False
hidden = False


def background_thread():
    while True:
        if currentTimer and not paused:
            time = timedelta(hours=int(currentTimer.get('hours', 0)),
                             minutes=int(currentTimer.get('minutes', 0)),
                             seconds=int(currentTimer.get('seconds', 0)))
            if currentTimer['done']:
                time += timedelta(seconds=1)
            else:
                time -= timedelta(seconds=1)
            if time.seconds == 0:
                currentTimer['done'] = True
            elif time.seconds <= 300:
                currentTimer['warning'] = True
            hours, remainder = divmod(time.seconds, 3600)
            minutes, seconds = divmod(remainder, 60)
            currentTimer['hours'] = hours
            currentTimer['minutes'] = minutes
            currentTimer['seconds'] = seconds
        currentTimer['paused'] = paused
        currentTimer['hidden'] = hidden
        socket.emit('timer', dumps(currentTimer), broadcast=True)
        socket.sleep(1)


@socket.on('start')
def start(data):
    global thread
    global currentTimer
    currentTimer = db.timers.find_one(ObjectId(data["_id"]))
    currentTimer['done'] = False
    if thread is None:
        thread = socket.start_background_task(target=background_thread)


@socket.on('hide')
def hide():
    global hidden
    hidden = False if hidden else True


@socket.on('pause')
def pause():
    global paused
    paused = False if paused else True


@socket.on('next')
def next_(data):
    global currentTimer
    timers_ = db.timers.find({"category": data['category']})


@socket.on('show')
def show():
    emit('show', broadcast=True)


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