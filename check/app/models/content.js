const { Sequelize } = require('sequelize');
const postgres = require('../../config/psql');

const Content = postgres.define('contents', {
  id: {
    type: Sequelize.INTEGER,
    autoIncrement: true,
    allowNull: false,
    primaryKey: true
  },
  user_id: {
    type: Sequelize.INTEGER,
    references: {
      model: 'users',
      key: 'id',
    }
  },
  content: {
    type: Sequelize.STRING,
    allowNull: false
  },
  status: {
    type: Sequelize.SMALLINT,
    defaultValue: 0
  },
});

module.exports = Content;