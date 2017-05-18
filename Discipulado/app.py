from flask import Flask, render_template, request
from pymongo import MongoClient

db = MongoClient(host="0.0.0.0")['fulllife']


def create_app():
    app = Flask(__name__)

    @app.route('/')
    def home():
        category = request.args.get('category', 'preach')
        media = db.media.find({"category": category})
        return render_template('home.html', media=media)

    return app
