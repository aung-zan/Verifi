const getContent = async (msg, channel) => {
  try {
    const { id, user_id, content } = JSON.parse(msg.content.toString());

    const url = process.env.URL;
    const headers = {
      'Authorization': 'Bearer ' + process.env.KEY,
      'Content-Type': 'application/json'
    };

    const payload = {
      model: 'sonar',
      messages: [
        { role: 'user', content: process.env.PROMPT + content}
      ]
    };

    const response = await fetch(url, {
      method: 'POST',
      headers,
      body: JSON.stringify(payload)
    });

    const data = await response.json();
    console.log(data);

    channel.ack(msg);
  } catch (error) {
    console.error('Something went wrong on getting content: ', error);
  }
}

module.exports = {
  getContent
}