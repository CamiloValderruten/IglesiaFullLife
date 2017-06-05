FROM python:3

WORKDIR /usr/src/app

RUN apt-get install curl
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -
RUN apt-get install nodejs
RUN npm install -g bower
COPY . .
WORKDIR /usr/src/app/app/static
RUN bower --allow-root install
WORKDIR /usr/src/app
RUN pip install -r requirements.txt

CMD gunicorn -b 0.0.0.0:5000 wsgi:app
