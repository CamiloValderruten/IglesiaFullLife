from flask import Flask, render_template, request
from pymongo import MongoClient

app = Flask(__name__)
db = MongoClient(host="0.0.0.0")['fulllife']


@app.route('/')
def home():
    category = request.args.get('category', 'preach')
    media = db.media.find({"category": category})
    return render_template('home.html', media=media)


if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000, debug=True)
