from flask import Flask
from flask import render_template
from flask import request
from werkzeug import secure_filename
from pymongo import MongoClient
import boto3
import os

host = "mongodb" if os.environ.get('ENVIRONMENT') == "PRODUCTION" else "0.0.0.0"
db = MongoClient(host=host)['fulllife']
bucket = "full-life-media"
a_password = "38knCo2G7BLfz0O"
u_password = "fulllifestudent"
secret = 'rR2y7S9wIl9#40f@F9oc8DTrW8OQZ67&t^Pr16gPH@KiEi!'


app = Flask(__name__)
s3 = boto3.client('s3')
app.secret_key = secret


@app.route('/', methods=['GET'])
def home():
    return render_template('home.html', db=db)


@app.route('/upload', methods=['GET', 'POST'])
def upload():
    return_data = dict(db=db)
    if request.method == "POST" and request.form['password'] == a_password:
        data = {"author": request.form['author'],
                "title": request.form['title'],
                "date": request.form['date'],
                "category": request.form['category'].lower(),
                "subcategory": request.form['subcategory'].lower()}

        media = request.files.get('media')
        key = secure_filename(media.filename)
        data['url'] = "https://s3.amazonaws.com/{}/{}".format(bucket, key)
        s3.upload_fileobj(media, bucket, key)
        return_data['media_url'] = data['url']

        poster = request.files.get('poster')
        key = secure_filename(poster.filename)
        data['poster_url'] = "https://s3.amazonaws.com/{}/{}".format(bucket,
                                                                     key)
        s3.upload_fileobj(poster, bucket, key)

        db.media.save(data)
    return render_template('upload.html', **return_data)
