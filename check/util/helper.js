const extractJSONFromMarkdown = (markdownText) => {
  const jsonRegex = /```json\n([\s\S]*?)\n```/;
  const match = markdownText.match(jsonRegex);

  return match ? match[1] : null;
}

module.exports = {
  extractJSONFromMarkdown,
}