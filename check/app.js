const express = require('express');
require('dotenv').config();

const { connectDB } = require('./config/psql');
const rabbitmq = require('./config/rabbitmq');
const routes = require('./routes/web');
const { getContent } = require('./app/service/content.service');

const app = express();

app.use(routes);

(async () => {
  try {
    // other services
    await connectDB();
    await rabbitmq.connect();
    await rabbitmq.consume(getContent);

    app.listen(3000, () => {
      console.log('Server running on port:', 3000);
    });
  } catch (error) {
    console.error(error);
  }
})();