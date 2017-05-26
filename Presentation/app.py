#!/usr/bin/env python
# -*- coding: utf-8 -*-

from flask import Flask
from flask import render_template

timers = [
    {"title": "Starting", "minutes": 5, 'icon': 'adjust'},
    {"title": "Worship", "minutes": 5, 'icon': 'music'},
    {"title": "Interlude", "minutes": 5, 'icon': 'clock-o'},
    {"title": "Preach", "minutes": 32, 'icon': 'commenting'},
    {"title": "Ministering", "minutes": 8, 'icon': 'fire'},
    {"title": "Offering", "minutes": 5, 'icon': 'money'},
    {"title": "Conéctate", "minutes": 3, 'icon': 'plug'},
    {"title": "Despedida", "minutes": 1, 'icon': 'sign-out'}
]


def create_app():
    app = Flask(__name__)

    @app.route('/')
    def home():
        return render_template('home.html', timers=timers)

    return app
