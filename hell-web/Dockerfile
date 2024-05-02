FROM python:3.10.12-slim

WORKDIR /app

COPY requirements.txt .
RUN pip install -r requirements.txt

#RUN pip install Flask

COPY app.py .

CMD ["python", "app.py"]