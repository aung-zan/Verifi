const url = process.env.URL;
let headers = {
  Authorization: 'Bearer ',
  'Content-Type': 'application/json',
};
let payload = {
  model: 'sonar',
};

const verify = async (key, content) => {
  headers.Authorization += key;
  payload.messages = [
    { role: 'user', content: process.env.PROMPT + content }
  ];

  const response = await fetch(url, {
    method: 'POST',
    headers,
    body: JSON.stringify(payload)
  });

  const data = await response.json();

  return data;
}

module.exports = {
  verify
}