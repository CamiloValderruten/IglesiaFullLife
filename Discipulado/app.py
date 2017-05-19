from flask import Flask, render_template, request
from werkzeug import secure_filename
import boto3
from pymongo import MongoClient

db = MongoClient(host="0.0.0.0")['fulllife']
bucket = "full-life-media"
password = "38knCo2G7BLfz0O"
categories = ["discipulado", "preach", "snack", "youth"]


def create_app():
    app = Flask(__name__)
    s3 = boto3.client('s3')

    @app.route('/', methods=['GET'])
    def home():
        query = dict()
        if request.args.get('category'):
            query = {"category": request.args.get('category')}
        if request.args.get('author'):
            query['author'] = request.args.get('author')
        media = db.media.find(query)
        data = {"categories": db.media.distinct("category"), 'media': media}
        return render_template('home.html', **data)

    @app.route('/upload', methods=['GET', 'POST'])
    def upload():
        if request.method == "POST" and request.form['password'] == password:
            data = {"author": request.form['author'],
                    "title": request.form['title'],
                    "date": request.form['date'],
                    "category": request.form['category'],
                    "subcategory": request.form['subcategory']}

            media = request.files.get('media')
            key = secure_filename(media.filename)
            data['type'] = 'audio' if key.split('.')[-1] == 'mp3' else 'video'
            data['url'] = "https://s3.amazonaws.com/{}/{}".format(bucket, key)
            s3.upload_fileobj(media, bucket, key)

            poster = request.files.get('poster')
            key = secure_filename(poster.filename)
            data['poster_url'] = "https://s3.amazonaws.com/{}/{}".format(bucket,
                                                                         key)
            s3.upload_fileobj(poster, bucket, key)

            db.media.save(data)
        return render_template('upload.html', categories=categories)

    return app
