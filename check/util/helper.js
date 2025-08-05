const extractJSONFromMarkdown = (markdownText) => {
  try {
    const jsonRegex = /```json\n([\s\S]*?)\n```/;
    const match = markdownText.match(jsonRegex);

    return match ? JSON.parse(match[1]) : JSON.parse(markdownText);
  } catch (error) {
    throw new Error(`Something went wrong in extracting JSON data: ${error}`);
  }
}

module.exports = {
  extractJSONFromMarkdown,
}