const amqp = require('amqplib');

const exchange = process.env.RABBITMQ_EXCHANGE;
const queue = process.env.RABBITMQ_QUEUE;
let connection = null;
let channel = null;

const connect = async () => {
  try {
    connection = await amqp.connect(process.env.RABBITMQ_HOST);
    channel = await connection.createChannel();

    connection.on('error', (err) => {
      console.error('RabbitMQ connection error: ', err);
    });

    connection.on('close', () => {
      console.log('Close RabbitMQ connection. Bye Bye');
    });

    await setUpExchangeAndQueue();

  } catch (error) {
    console.error('Failed to connect to RabbitMQ: ', error);
  }
}

const setUpExchangeAndQueue = async () => {
  try {
    await channel.assertExchange(exchange, 'direct', {
      durable: true
    });
    console.log('Created exchange.');

    await channel.assertQueue(queue, { durable: true });
    // bindQueue(queue, exchange, routingKey);
    await channel.bindQueue(queue, exchange, 'content');
    console.log('Setup exchange and queue.');

  } catch (error) {
    console.error('Failed to setup exchange and queue: ', error);
  }
}

const consume = async (callback) => {
  try {
    await channel.consume(queue, (msg) => {
      callback(msg, channel);
    });

  } catch (error) {
    console.error('Failed to consume message: ', error);
  }
}

const close = async () => {
  try {
    if (channel) {
      await channel.close();
    }

    if (connection) {
      await connection.close();
    }
  } catch (error) {

  }
}

module.exports = {
  connect,
  consume
};