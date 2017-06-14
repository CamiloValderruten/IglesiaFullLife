FROM python:3

WORKDIR /usr/src/app

COPY . .
RUN pip install -r requirements.txt

CMD gunicorn -k gevent -b 0.0.0.0:5000 -w 4 app:app
