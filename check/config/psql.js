const { Sequelize } = require('sequelize');

const database = process.env.DB_DATABASE;
const username = process.env.DB_USERNAME;
const password = process.env.DB_PASSWORD;
const host = process.env.DB_HOST;

const postgres = new Sequelize(
  database,
  username,
  password,
  {
    host: host,
    dialect: 'postgres',
    define: {
      underscored: true,
      underscoredAll: true,
      createdAt: 'created_at',
      updatedAt: 'updated_at'
    }
  }
);

module.exports = postgres;