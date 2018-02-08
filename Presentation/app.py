from flask import Flask
from flask import request
from flask import render_template
from flask import session
from flask import redirect
from flask import url_for

from flask_socketio import SocketIO
from functools import wraps

from pymongo import MongoClient
from bson.json_util import dumps
from bson import ObjectId

db = MongoClient("mongodb")['Presentation']
app = Flask(__name__)
app.config['SECRET_KEY'] = 'BNJqqX8cuQe^$U68DrxMb8aGSk8LaD0CKO$78WKB!ySM'

socket = SocketIO(app, async=None)
username = "admin"
password = "fulllife2018"
thread = None

if not db.configurations.find_one():
    db.configurations.save({})

configuration_schema = {
    "_id": {"type": "string"},
    "hidden": {"type": "boolean"},
    "paused": {"type": "boolean"},
    "timer": {
        "type": "dictionary",
        "schema": {
            "hours": {"type": "integer"},
            "minutes": {"type": "integer"},
            "seconds": {"type": "integer"},
            "_id": {"type": "ObjectId"},
            "category_id": {"type": "ObjectId"}
        }
    }
}


def remove_second(timer):
    seconds = (int(timer.get('seconds', 0))) + (int(timer.get('minutes', 0)) * 60) + (int(timer.get('hours', 0)) * 3600)
    seconds -= 1
    m, s = divmod(seconds, 60)
    h, m = divmod(m, 60)
    timer.update(dict(hours=h, minutes=m, seconds=s))
    return timer


def background_thread():
    with app.app_context():
        while True:
            configuration_ = db.configurations.find_one()
            selected_timer = configuration_.get('timer')
            paused = configuration_.get('paused')
            if selected_timer and not paused:
                t = configuration_['timer']
                if t['hours'] == 0 and t['minutes'] == 0 and t['seconds'] == 0:
                    if t.get('next', False):
                        cursor = db.timers.find({"category_id": t.get('category_id')})
                        for timer_ in cursor:
                            if str(timer_['_id']) == str(t['_id']):
                                next_timer = next(cursor, None)
                                if next_timer:
                                    configuration_['timer'] = next_timer
                                    break
                                else:
                                    configuration_['paused'] = True
                    else:
                        configuration_['paused'] = True
                else:
                    configuration_['timer'] = remove_second(configuration_['timer'])
                db.configurations.save(configuration_)
            socket.emit('changed', dumps(dict(configuration=configuration_)), broadcast=True)
            socket.sleep(1)


def authentication_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if not session.get('logged_in'):
            return redirect(url_for('login'))
        return f(*args, **kwargs)

    return decorated_function


@socket.on('connect')
@authentication_required
def connect():
    global thread
    thread = thread if thread else socket.start_background_task(target=background_thread)
    return dumps(db.configurations.find_one())


@socket.on('configuration')
@authentication_required
def configuration(data):
    configuration_ = db.configurations.find_one()
    configuration_.update(data)
    db.configurations.save(configuration_)
    return dumps(data)


@socket.on('start')
@authentication_required
def start(data):
    timer = db.timers.find_one({"_id": ObjectId(data['timer_id'])})
    db.configurations.update({}, {"$set": {"timer": timer}})
    return dumps(db.configurations.find_one())


@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == "GET":
        return render_template('login.html')

    if request.method == "POST":
        form = request.form
        if username == form.get('username') and password == form.get('password'):
            session['logged_in'] = True
        return redirect(url_for('categories'))


@app.route('/logout', methods=['GET'])
@authentication_required
def logout():
    del (session['logged_in'])
    return redirect(url_for('login'))


@app.route('/clock')
@authentication_required
def clock():
    return render_template('clock.html')


#######################################################

timer_schema = {"name": {"type": "string"},
                "hours": {"type": "integer"},
                "minutes": {"type": "integer"},
                "seconds": {"type": "integer"},
                "category_id": {"type": "ObjectId"}}


@app.route('/categories/<category_id>/timers', methods=['POST', 'GET'])
@authentication_required
def timers(category_id):
    if request.method == "POST":
        data = {k: v for k, v in request.form.items()}
        data['category_id'] = ObjectId(category_id)
        data['name'] = data['name'].title()
        data['hours'] = data.get('hours', 0)
        data['minutes'] = data.get('minutes', 0)
        data['seconds'] = data.get('seconds', 0)
        db.timers.save(data)
        return redirect(url_for('timers', category_id=category_id))

    timers_ = db.timers.find({"category_id": ObjectId(category_id)})
    category_ = db.categories.find_one({"_id": ObjectId(category_id)})
    return render_template("timers.html", timers=timers_, category=category_)


@app.route('/categories/<category_id>/timers/<timer_id>/delete', methods=['GET'])
@authentication_required
def delete_timer(category_id, timer_id):
    db.timers.delete_one({"_id": ObjectId(timer_id)})
    return redirect(url_for('timers', category_id=category_id))


@app.route('/', methods=['POST', 'GET'])
@app.route('/categories', methods=['POST', 'GET'])
@authentication_required
def categories():
    if request.method == "POST":
        db.categories.save({"name": request.form['name']})
        return redirect(url_for('categories'))
    return render_template('home.html', categories=db.categories.find())


@app.route('/categories/<category_id>/delete', methods=['GET'])
@authentication_required
def delete_category(category_id):
    db.timers.delete_many({"category_id": ObjectId(category_id)})
    db.categories.delete_one({"_id": ObjectId(category_id)})
    return redirect(url_for('categories'))
