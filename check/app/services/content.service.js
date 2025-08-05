const User = require('../models/user');
const Content = require('../models/content');
const ContentResult = require('../models/content_result');

const { verify } = require('../../config/sonar');
const { extractJSONFromMarkdown } = require('../../util/helper');

const { RESULT_TYPE, CONTENT_STATUS } = require('../../util/constant');

const getContent = async (msg, channel) => {
  const { id, user_id, content } = JSON.parse(msg.content.toString());

  try {
    const userInfo = await User.findByPk(user_id);
    const key = userInfo.sonar_key;

    const data = await verify(key, content);

    const result = extractResult(data);
    result.content_id = id;

    await ContentResult.create(result);

    await Content.update(
      { status: CONTENT_STATUS.Success },
      { where: { id: id }}
    );

    channel.ack(msg);
  } catch (error) {
    await Content.update(
      { status: CONTENT_STATUS.Fail },
      { where: { id: id }}
    );
    console.error(error);
  }
}

const extractResult = (data) => {
  if (!data) {
    throw new Error("Data is empty.");
  }

  try {
    const result = {};

    result.citations = JSON.stringify({
      links: data.citations
    });

    const markdownText = data.choices[0].message.content;
    const {Summary, Verdict} = extractJSONFromMarkdown(markdownText);

    result.summary = Summary;
    result.type = RESULT_TYPE[Verdict];

    return result;
  } catch (error) {
    throw new Error(error);
  }
}

module.exports = {
  getContent
}