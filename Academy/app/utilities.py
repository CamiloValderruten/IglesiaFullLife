import phonenumbers
from pymongo import MongoClient
from bson import ObjectId
import os
import boto3

host = "mongodb" if os.environ.get('ENVIRONMENT') == "PRODUCTION" else "0.0.0.0"
db = MongoClient(host=host)['AcademyCenter']


def clean_phone(phone):
    try:
        phone = phonenumbers.parse(phone, "US")
        _format = phonenumbers.PhoneNumberFormat.E164
        return phonenumbers.format_number(phone, _format)
    except:
        return phone

def upload_profile_image(key, file):
    s3 = boto3.client('s3')
    bucket = "profileimages-academycenter"
    s3.upload_fileobj(file.stream, bucket, key)
    url = "https://s3.amazonaws.com/{}/{}".format(bucket, key)
    db.accounts.update({"_id": ObjectId(key)},
                       {"$set": {"profile_image_url": url}})
    return url
