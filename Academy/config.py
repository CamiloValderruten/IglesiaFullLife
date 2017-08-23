class Configuration(object):
    VERSION = "1.0.5"
    DAYCARE_NAME = "Full Life Christian Academy"
    DOMAIN_NAME = "ac.flcacademy.org"
    DEFAULT_PROFILE_IMAGE_LOCATION = "dist/img/default-user.png"
    DEFAULT_PASSWORD = "0123456789"


class Development(Configuration):
    DEBUG = True
    STRIPE_SECRET_KEY = "sk_test_Qk1hfNuxymDm3qQCIiFFZ7uN"
    STRIPE_PUBLISHABLE_KEY = "pk_test_2SfsChGdbH84re7zlS088moZ"
    SECRET_KEY = "UkiYEteRqykjoszgPriKUoTHiYKvhLucwQqrThDvtgZeWcqLAG3ApoNxKo"
    DOMAIN_NAME = None


class Production(Development):
    STRIPE_SECRET_KEY = "sk_live_rdVGeUdFjGyJPJnGwhNBTEud"
    STRIPE_PUBLISHABLE_KEY = "pk_live_Ob3sI9CeCc8YXTA1t4XClcS7"
    SECRET_KEY = "n8e23bdn37ybf82ybfdib"
