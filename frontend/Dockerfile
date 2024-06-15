FROM node:latest

WORKDIR /app

RUN npm install -g http-server

COPY ./ /app

EXPOSE 5500

CMD ["http-server", "-p", "5500"]