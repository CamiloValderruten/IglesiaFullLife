FROM python:3

WORKDIR /usr/src/app

COPY . .
RUN pip install -r requirements.txt

CMD gunicorn -k eventlet -b 0.0.0.0:5000 app:app
