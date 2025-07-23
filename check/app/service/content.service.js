const { getUser, updateContent, saveResult } = require('../../config/psql');
const { verify } = require('../../config/sonar');
const { extractJSONFromMarkdown } = require('../../util/helper');

const resultValue = {
  True: 0,
  False: 1,
  Misleading: 2,
  Unproven: 3,
  Mixture: 4,
  Satire: 5,
};

const getContent = async (msg, channel) => {
  try {
    const { id, user_id, content } = JSON.parse(msg.content.toString());

    const userInfo = await getUser(user_id);
    const key = userInfo.sonar_key;

    // const data = await verify(key, content);
    // const citations = data.citations;

    // const makrdownText = data.choices[0].message.content;
    // const jsonText = extractJSONFromMarkdown(makrdownText);
    // const result = JSON.parse(jsonText);
    // console.log(result);

    const sample = 'Unproven';

    const sampleData = {
      content_id: 1,
      summary: 'Hello World',
      citations: 'Hello',
      result: resultValue[sample]
    };
    console.log(sampleData);

    await updateContent(id, 1);
    await saveResult(sampleData);

    // channel.ack(msg);
  } catch (error) {
    console.error('Something went wrong on getting content: ', error);
  }
}

module.exports = {
  getContent
}