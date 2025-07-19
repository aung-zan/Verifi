const getContent = (msg, channel) => {
  try {
    const content = JSON.parse(msg.content.toString());
    console.log(content.id);
    console.log(content.content);

    channel.ack(msg);
  } catch (error) {
    console.error('Something went wrong on getting content: ', error);
  }
}

module.exports = {
  getContent
}