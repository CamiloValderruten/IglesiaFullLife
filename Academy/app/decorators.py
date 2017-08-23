from functools import wraps
from flask import abort
from flask_login import current_user
from flask_login import login_required


def access_level(required_role='student'):
    def decorator(f):
        @wraps(f)
        @login_required
        def decorated_function(*args, **kwargs):
            roles = ['student', 'parent', 'teacher', 'administrator']
            if roles.index(current_user.role) >= roles.index(required_role):
                return f(*args, **kwargs)
            return abort(401)
        return decorated_function
    return decorator
