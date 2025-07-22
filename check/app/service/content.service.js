const { getUser } = require('../../config/psql');
const { verify } = require('../../config/sonar');

const getContent = async (msg, channel) => {
  try {
    const { id, user_id, content } = JSON.parse(msg.content.toString());

    const userInfo = await getUser(user_id);
    const key = userInfo.sonar_key;

    const data = await verify(key, content);
    const result = data.choices[0].message.content;
    console.log(result);

    channel.ack(msg);
  } catch (error) {
    console.error('Something went wrong on getting content: ', error);
  }
}

module.exports = {
  getContent
}