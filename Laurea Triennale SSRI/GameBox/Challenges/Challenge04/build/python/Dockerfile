FROM python:latest
WORKDIR /usr/app/src
COPY proxy.py ./
COPY ./requirements.txt .
RUN pip install -r requirements.txt
CMD [ "python", "./proxy.py"]
