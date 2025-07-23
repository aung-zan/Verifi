const pgp = require('pg-promise')();

let db;

const connectDB = async () => {
  try {
    if (db) return db;

    const config = {
      host: process.env.DB_HOST,
      port: process.env.DB_PORT,
      database: process.env.DB_DATABASE,
      user: process.env.DB_USERNAME,
      password: process.env.DB_PASSWORD,
    };

    db = pgp(config);

    await db.connect();
    console.log('Connected to psql and database.');

    return db;

  } catch (error) {
    throw new Error(`Failed to connect pgsql: ${error}`);
  }
}

const getUser = async (id) => {
  if (!db) throw new Error('Database is not connected.');

  try {
    const user = await db.one('select id, sonar_key from users where id = $1', id);
    return user;

  } catch (error) {
    throw new Error(`Failed to get the user info: ${error}`);
  }
}

const updateContent = async (id, status) => {
  if (!db) throw new Error('Database is not connected.');

  try {
    await db.query('update contents set status = $1 where id = $2', [status, id]);
  } catch (error) {
    throw new Error(`Failed to update the content: ${error}`);
  }
}

const saveResult = async (data) => {
  if (!db) throw new Error('Database is not connected.');

  try {
    await db.query('insert into content_results values ($1)', [data]);
  } catch (error) {
    throw new Error(`Failed to create the result: ${error}`);
  }
}

module.exports = {
  connectDB,
  getUser,
  updateContent,
  saveResult
}