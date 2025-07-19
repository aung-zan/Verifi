const express = require('express');

const Router = express.Router();

Router.get('/', (req, res, next) => {
  return res.status(200).send('Hello');
});

module.exports = Router;