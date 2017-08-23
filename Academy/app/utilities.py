import phonenumbers
from pymongo import MongoClient
import os

host = "mongodb" if os.environ.get('ENVIRONMENT') == "PRODUCTION" else "0.0.0.0"
db = MongoClient(host=host)['AcademyCenter']


def clean_phone(phone):
    try:
        phone = phonenumbers.parse(phone, "US")
        _format = phonenumbers.PhoneNumberFormat.E164
        return phonenumbers.format_number(phone, _format)
    except:
        return phone
