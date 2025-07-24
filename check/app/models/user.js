const { Sequelize } = require('sequelize');
const postgres = require('../../config/psql');

const User = postgres.define('users', {
  id: {
    type: Sequelize.INTEGER,
    autoIncrement: true,
    allowNull: false,
    primaryKey: true
  },
  name: {
    type: Sequelize.STRING,
    allowNull: false
  },
  email: {
    type: Sequelize.STRING,
    allowNull: false
  },
  password: {
    type: Sequelize.STRING,
    allowNull: false
  },
  remember_token: {
    type: Sequelize.STRING
  },
  sonar_key: {
    type: Sequelize.STRING
  }
});

module.exports = User;