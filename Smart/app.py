from flask import Flask
from flask import render_template
from flask import request
from flask import session
from flask import url_for
from flask import redirect
from werkzeug import secure_filename
from pymongo import MongoClient
import boto3
import os

SERVICE_NAME = "Smart"
SERVICE_SECRET = "vs4s^imJv0dtIW7UmcG0qYo2THPgqjbR#N0ZFy5K81*63Z6"
ENVIRONMENT = os.environ.get('ENVIRONMENT', "DEVELOPMENT").upper()
DATABASE_HOST = "mongodb" if ENVIRONMENT == "PRODUCTION" else "0.0.0.0"
S3_BUCKET = "full-life-media"
UPLOAD_PASSWORD = "38knCo2G7BLfz0O"


db = MongoClient(host=DATABASE_HOST)[SERVICE_NAME]


app = Flask(__name__)
app.secret_key = SERVICE_SECRET
s3 = boto3.client('s3')


def login_required():
    def decorator(f):
        @wraps(f)
        def decorated_function(*args, **kwargs):
            if session.get('AUTH_TOKEN') is None:
                return redirect(url_for('login'))
            return f(*args, **kwargs)
        return decorated_function
    return decorator


@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == "POST":
        data = request.form
        print(data)
        user = db.users.find_one({"email": data['email']})
        if user:
            session['AUTH_TOKEN'] = data['email']
            return redirect(url_for('home'))
    return render_template('login.html', db=db)


@app.route('/', methods=['GET'])
@login_required
def home():
    return render_template('home.html', db=db)


@app.route('/upload', methods=['GET', 'POST'])
def upload():
    return_data = dict(db=db)
    if request.method == "POST" and request.form['password'] == UPLOAD_PASSWORD:
        data = {"author": request.form['author'],
                "title": request.form['title'],
                "date": request.form['date'],
                "category": request.form['category'].lower(),
                "subcategory": request.form['subcategory'].lower()}

        media = request.files.get('media')
        key = secure_filename(media.filename)
        data['url'] = "https://s3.amazonaws.com/{}/{}".format(S3_BUCKET, key)
        s3.upload_fileobj(media, S3_BUCKET, key)
        return_data['media_url'] = data['url']

        poster = request.files.get('poster')
        key = secure_filename(poster.filename)
        data['poster_url'] = "https://s3.amazonaws.com/{}/{}".format(S3_BUCKET,
                                                                     key)
        s3.upload_fileobj(poster, S3_BUCKET, key)

        db.media.save(data)
    return render_template('upload.html', **return_data)
