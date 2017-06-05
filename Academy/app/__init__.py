import os
from app import controllers
from flask import Flask, url_for
from flask_login import LoginManager
from app.models import Account
from bson.objectid import ObjectId
from werkzeug.security import generate_password_hash
from .utilities import db


def create_app():
    app = Flask(__name__)

    environment = os.environ.get('SERVICE_ENVIRONMENT', 'Development')
    app.config.from_object('config.{}'.format(environment.title()))

    app.register_blueprint(controllers.home.blueprint)
    app.register_blueprint(controllers.students.blueprint)
    app.register_blueprint(controllers.teachers.blueprint)
    app.register_blueprint(controllers.administrators.blueprint)
    app.register_blueprint(controllers.parents.blueprint)

    register_login_manager(app, login_view='home.login')
    initial_setup(app)

    return app


def register_login_manager(app, login_view):
    def load_account(account_id):
        account = db.accounts.find_one(ObjectId(account_id))
        return Account(account) if account else None

    login_manager = LoginManager(app)
    login_manager.user_loader(load_account)
    login_manager.login_view = login_view


def initial_setup(app):
    if db.accounts.find({"role": "administrator"}).count() == 0:
        password = generate_password_hash(app.config['DEFAULT_PASSWORD'])
        url = "/static/images/default.png"
        db.accounts.save({'name': "Administrator", 'password': password,
                          'cell_phone': "+10123456789",
                          'role': "administrator", "profile_image_url": url})
