from bson import ObjectId
from random import randrange


class Account:
    def __init__(self, data):
        self.data = data

    def __getattr__(self, item):
        return self.data.get(item)

    def is_authenticated(self):
        return True

    def is_active(self):
        return True

    def is_anonymous(self):
        return False

    def get_id(self):
        return str(self._id)
