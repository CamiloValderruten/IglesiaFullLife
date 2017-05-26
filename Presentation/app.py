from flask import Flask
from flask import render_template

timers = [
    {"title": "Starting", "minutes": 5, 'icon': 'adjust'},
    {"title": "Worship", "minutes": 30, 'icon': 'music'},
    {"title": "Interlude", "minutes": 5, 'icon': 'clock-o'},
    {"title": "Preach", "minutes": 32, 'icon': 'commenting'},
    {"title": "Ministering", "minutes": 8, 'icon': 'fire'},
    {"title": "Offering", "minutes": 5, 'icon': 'money'},
    {"title": "Conectate", "minutes": 3, 'icon': 'plug'},
    {"title": "Despedida", "minutes": 1, 'icon': 'sign-out'}
]


def create_app():
    app = Flask(__name__)

    @app.route('/')
    def home():
        return render_template('home.html', timers=timers)

    return app
