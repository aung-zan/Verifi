const User = require('../models/user');
const Content = require('../models/content');
const ContentResult = require('../models/content_result');

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
  const { id, user_id, content } = JSON.parse(msg.content.toString());

  try {
    const userInfo = await User.findByPk(user_id);
    const key = userInfo.sonar_key;

    const data = await verify(key, content);

    const citations = JSON.stringify({
      links: data.citations
    });

    const makrdownText = data.choices[0].message.content;
    const result = extractJSONFromMarkdown(makrdownText);

    const resultData = {
      content_id: id,
      summary: result.Summary,
      citations: citations,
      result: resultValue[result.Verdict]
    };
    await ContentResult.create(resultData);

    await Content.update(
      { status: 1 },
      { where: { id: id }}
    );

    channel.ack(msg);
  } catch (error) {
    await Content.update(
      { status: 2 },
      { where: { id: id }}
    );
    console.error('Something went wrong on getting content: ', error);
  }
}

module.exports = {
  getContent
}