from flask import Flask
from flask import request
from flask import render_template
from flask import session
from flask import redirect
from flask import url_for

from flask_socketio import SocketIO
from flask_sqlalchemy import SQLAlchemy

from functools import wraps

app = Flask(__name__)
app.config['SECRET_KEY'] = 'BNJqqX8cuQe^$U68DrxMb8aGSk8LaD0CKO$78WKB!ySM'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:////tmp/countdown.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
socket = SocketIO(app, async=None)
db = SQLAlchemy(app)

username = "admin"
password = "fulllife2018"

thread = None
current_timer = None
paused = False
hidden = False


def authentication_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if not session.get('logged_in'):
            return redirect(url_for('login'))
        return f(*args, **kwargs)

    return decorated_function


#  #####################################################################################################################


class Category(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(80), unique=False, nullable=False)
    timers = db.relationship('Timer', backref='category', lazy=True, cascade="all,delete")

    def __repr__(self):
        return '<Category %r>' % self.name


class Timer(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(80), unique=False, nullable=False)
    seconds = db.Column(db.Integer, unique=False, nullable=False)
    order = db.Column(db.Integer, unique=False, nullable=True)
    category_id = db.Column(db.Integer, db.ForeignKey('category.id'), nullable=False)

    def __repr__(self):
        return '<Timer %r>' % self.name


db.create_all()


#  #####################################################################################################################


def background_thread():
    with app.app_context():
        global current_timer, paused, hidden
        while True:
            if current_timer and current_timer.seconds < 0:
                current_timer = db.session.query(Timer).order_by(Timer.id.asc()).filter(
                    Timer.id > current_timer.id).filter(Timer.category_id == current_timer.category_id).first()

            if current_timer is not None and not paused:
                data = dict(id=current_timer.id, name=current_timer.name, seconds=current_timer.seconds)
                socket.emit('timer', data, broadcast=True)
                current_timer.seconds -= 1

            data = dict(paused=paused, hidden=hidden)
            socket.emit('configuration', data, broadcast=True)
            socket.sleep(1)


#  #####################################################################################################################


@socket.on('connect')
@authentication_required
def connect():
    global thread
    thread = thread if thread else socket.start_background_task(target=background_thread)


@socket.on('start')
@authentication_required
def start(timer_id):
    global current_timer, paused
    paused = False
    current_timer = Timer.query.get(timer_id)


@socket.on('add_minute')
@authentication_required
def add_minute():
    global current_timer
    if current_timer:
        current_timer.seconds += 60


@socket.on('subtract_minute')
@authentication_required
def subtract_minute():
    global current_timer
    if current_timer:
        current_timer.seconds -= 60


@socket.on('pause')
@authentication_required
def pause():
    global paused
    paused = not paused


@socket.on('hide')
@authentication_required
def hide():
    global hidden
    hidden = not hidden


#  #####################################################################################################################


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


#  #####################################################################################################################


@app.route('/categories/<category_id>/timers', methods=['POST', 'GET'])
@authentication_required
def timers(category_id):
    category = Category.query.get(category_id)
    if request.method == "POST":
        seconds = int(request.form['seconds']) + (int(request.form['minutes']) * 60) + (
                    int(request.form['hours']) * 3600)
        timer = Timer(name=request.form['name'], seconds=seconds, order=0, category=category)
        db.session.add(timer)
        db.session.commit()
        return redirect(url_for('timers', category_id=category_id))

    return render_template("timers.html", timers=category.timers, category=category)


@app.route('/categories/<category_id>/timers/<timer_id>/delete', methods=['GET'])
@authentication_required
def delete_timer(category_id, timer_id):
    timer = Timer.query.get(timer_id)
    db.session.delete(timer)
    db.session.commit()
    return redirect(url_for('timers', category_id=category_id))


@app.route('/', methods=['POST', 'GET'])
@app.route('/categories', methods=['POST', 'GET'])
@authentication_required
def categories():
    if request.method == "POST":
        category = Category(name=request.form['name'])
        db.session.add(category)
        db.session.commit()
        return redirect(url_for('categories'))
    return render_template('home.html', categories=Category.query.all())


@app.route('/categories/<category_id>/delete', methods=['GET'])
@authentication_required
def delete_category(category_id):
    category = Category.query.get(category_id)
    db.session.delete(category)
    db.session.commit()
    return redirect(url_for('categories'))
