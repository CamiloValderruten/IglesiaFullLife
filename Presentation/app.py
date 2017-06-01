from flask import Flask
from flask import request
from flask import render_template
from bson.json_util import dumps
from flask_socketio import SocketIO
from flask_socketio import emit
from pymongo import MongoClient

db = MongoClient()['Presentation']
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
    timer = request.get_json(force=True)
    db.timers.save(timer)
    return dumps(timer)


@app.route('/categories', methods=['POST', 'GET'])
def categories():
    if request.method == "GET":
        return dumps(db.categories.find())
    category = request.get_json(force=True)
    db.categories.save(category)
    return dumps(category)


@socket.on('start_timer')
def start_timer(timer):
    emit('clock_start', timer, broadcast=True)


@socket.on('timer_done')
def timer_done(timer):
    emit('timer_done', timer, broadcast=True)


@socket.on('timer_changed')
def timer_changed(timer):
    emit('timer_changed', timer, broadcast=True)

