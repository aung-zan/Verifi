FROM node:22-alpine

#Install bash
RUN apk add --no-cache bash

# Create app directory
WORKDIR /usr/src/app

# Bundle app source
COPY . .

# Install app dependencies
RUN npm install

# Expose port
EXPOSE 3000

# Start the application
CMD [ "npm", "start" ]