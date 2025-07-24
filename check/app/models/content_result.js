const { Sequelize } = require('sequelize');
const postgres = require('../../config/psql');

const ContentResult = postgres.define('content_results', {
  id: {
    type: Sequelize.INTEGER,
    autoIncrement: true,
    allowNull: false,
    primaryKey: true
  },
  content_id: {
    type: Sequelize.INTEGER,
    references: {
      model: 'contents',
      key: 'id',
    }
  },
  summary: {
    type: Sequelize.STRING,
    allowNull: false
  },
  citations: {
    type: Sequelize.STRING,
    allowNull: false
  },
  result: {
    type: Sequelize.SMALLINT,
    allowNull: false
  },
});

module.exports = ContentResult;